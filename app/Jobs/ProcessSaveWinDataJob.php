<?php

namespace App\Jobs;

use App\Events\GetBalanceByUsernameEvent;
use App\Models\AnalyticQueue;
use App\Models\Company;
use App\Models\Historytransaction;
use App\Models\HistorytransactionOld;
use App\Models\Member;
use App\Models\MonitorQueue;
use App\Models\Outstanding;
use App\Models\PendingSeamless;
use App\Models\Period;
use App\Models\PeriodBet;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSaveWinDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle(): void
    {
        $start = microtime(true);
        $monitor = MonitorQueue::create([
            'name' => 'createHistoryJob',
            'attempt' => 1,
            'duration' => "00:00:00",
            'status' => 1
        ]);
        
        $analytic = AnalyticQueue::first();
        if (!$analytic) {
            $analytic = AnalyticQueue::create([
                'total_job_success' => 0,
                'total_job_failed' => 0,
                'total_time_execution' => 0
            ]);
        }
        try {
            foreach($this->data['dataWin'] as $dt) {
                $this->saveWinData($dt, $this->data['periodno'], $this->data['gameId']);
                $this->apiGetBalance($dt['username']);
            }

            $duration = round(microtime(true) - $start, 3);
            $monitor->update([
                'duration' => $duration,
                'status' => 2
            ]);

            $analytic->update([
                'total_job_success' => $analytic->total_job_success + 1,
                'total_time_execution' => $analytic->total_time_execution + $duration,
            ]);
        } catch (\Throwable $e) {
            $duration = round(microtime(true) - $start, 3);
            $monitor->update([
                'duration' => $duration,
                'status' => 3,
                'exception' => $e->getMessage()
            ]);

            $analytic->update([
                'total_job_failed' => $analytic->total_job_failed + 1,
                'total_time_execution' => $analytic->total_time_execution + $duration,
            ]);

            Log::channel('error-custom-logs')->error("Job Error: " . $e->getMessage());
        }
    }


    function saveWinData($dataWin, $periodno, $gameId)
    {
        $period = Period::where('periodno', $periodno)->first();
        $dataBet = PeriodBet::where('period_id', $period->id)
            ->where('username', $dataWin['username'])
            ->firstOrFail();
        $member = Member::where('username', $dataWin['username'])->first();
        $companyId = $member->company_id ?? 1;

        try {
            DB::transaction(function () use ($period, $dataWin, $dataBet, $companyId, $periodno, $gameId) {
                $totalWin = $dataWin['mc'] + $dataWin['head_mc'] + $dataWin['body_mc'] +
                            $dataWin['leg_mc'] + $dataWin['bm'] + $dataWin['head_bm'] +
                            $dataWin['body_bm'] + $dataWin['leg_bm'];

                $statusgame = $totalWin > 0 ? 'win' : 'lose';

                $dataBet->update([
                    'mc_win' => $dataWin['mc'],
                    'head_mc_win' => $dataWin['head_mc'],
                    'body_mc_win' => $dataWin['body_mc'],
                    'leg_mc_win' => $dataWin['leg_mc'],
                    'bm_win' => $dataWin['bm'],
                    'head_bm_win' => $dataWin['head_bm'],
                    'body_bm_win' => $dataWin['body_bm'],
                    'leg_bm_win' => $dataWin['leg_bm'],
                    'amount_win' => $totalWin,
                ]);
            
                $this->apiSettle($period, $dataBet, $dataWin['username'], $totalWin, $companyId, $gameId, $periodno);
                Outstanding::where('username', $dataWin['username'])->where('periode_code', $periodno)->delete();
                return;
            });
        } catch (\Throwable $e) {
            Log::channel('error-custom-logs')->error("Error saving win data: " . json_encode($e->getMessage()));
        }
    }

    function apiGetBalance($username)
    {
        $url = env('URL_SEAMLESS') . '/api/GetBalance';

        $data = [
            'CompanyKey' => Member::where('username', $username)->first()->company->key,
            'Username'   => $username,
        ];

        try {
            $response = Http::post($url, $data);

            if ($response->successful()) {
                $balance = $response->json()["Balance"];
                if($response->json()["ErrorCode"] !== 0) {
                    Log::channel('error-custom-logs')->error("Failed GetBalance failed response for user {$username} Error Code: " . $response->json()["ErrorCode"]);
                } 
            } else {
                Log::channel('error-custom-logs')->error("Failed GetBalance failed response for user {$username}: " . json_encode($response->json()));
                $balance = 0;
            }

            try {
                Http::get(env('WS_URL') . '/api/broadcastBalance/' . $username . '/' . $balance);
            } catch (\Throwable $e) {
                Log::channel('error-custom-logs')->error("Failed GetBalance failed response for user {$username}: " . json_encode($e->getMessage()));
            }

        } catch (\Throwable $e) {
            Log::channel('error-custom-logs')->error("Failed GetBalance failed response for user {$username}: " . json_encode($e->getMessage()));
        }
    }
    
    function apiSettle($period, $dataBet, $username, $totalWin, $companyId, $gameId, $periodno){
        $url = env('URL_SEAMLESS') . '/api/Settle';
        $transactionCode = $dataBet['transaction_code'];
        
        $data = [
            "CompanyKey" => Company::where('id', $companyId)->first()->key,
            "TransactionCode" => $transactionCode,
            'Username' => $username,
            "WinLoss" => $totalWin,
        ];

        try {
            $response = Http::post($url, $data); 

            if ($response->successful()) {
                if($response->json()["ErrorCode"] !== 0) {
                    PendingSeamless::create([
                        'jenis_request' => 1,
                        'periodno' => $periodno,
                        'transaction_code' => $transactionCode,
                        'username' => $username,
                    ]);
                    Log::channel('error-custom-logs')->error("Failed Settle failed response for user {$username} Error Code: " . json_encode($response->json()));
                } else {
                    $totalBet = 
                    ($dataBet->mc ?? 0) + ($dataBet->head_mc ?? 0) + ($dataBet->body_mc ?? 0) + ($dataBet->leg_mc ?? 0) +
                    ($dataBet->bm ?? 0) + ($dataBet->head_bm ?? 0) + ($dataBet->body_bm ?? 0) + ($dataBet->leg_bm ?? 0);
                    
                    $dataBetting = $this->getDataBet($dataBet);

                    if($totalWin > 0 ) {
                        $allTotalWin = $totalWin - $totalBet; 
                    } else {
                        $allTotalWin = $totalBet * -1;
                    }

                    if($totalWin > 0 ) {
                        $dataHistory = [
                            'company_id' => $companyId,
                            'game_id' => $gameId,
                            'period_id' => $period->id,
                            'username' => $username,
                            'periodno' => $periodno,
                            'transaction_code' => $transactionCode,
                            'keterangan' => '-',
                            'status' => 'menang',
                            'betting' => json_encode($dataBetting),
                            'debit' => 0,
                            'kredit' => $totalBet + $allTotalWin,
                        ];
                        Historytransaction::create($dataHistory);
                        HistorytransactionOld::create($dataHistory);
                    }

                    //Create Report
                    $modelReport = ['ReportDailyWinlose', 'ReportMonthlyWinlose', 'ReportYearlyWinlose'];
                    $modelRekapReport = ['ReportRekapDailyWinlose', 'ReportRekapMonthlyWinlose', 'ReportRekapYearlyWinlose'];

                    foreach($modelReport as $modelrpt) {
                        $model = "App\\Models\\$modelrpt";
                        
                        $datawinlose = $model::where('company_id', $companyId)->where('username', $username)->whereDate('created_at', date('Y-m-d'));

                        if ($modelrpt == 'ReportMonthlyWinlose') {
                            $datawinlose = $datawinlose->where('month', date('n'))->where('year', date('Y'));
                        }

                        if ($modelrpt == 'ReportYearlyWinlose') {
                            $datawinlose = $datawinlose->where('year', date('Y'));
                        }

                        $datawinlose = $datawinlose->first(); 

                        if($datawinlose) {
                            $datawinlose->increment('turnover', $totalBet);
                            $datawinlose->increment('bet_count', 1);
                            $datawinlose->increment('member_win', $allTotalWin);
                        } else {
                            $model::create([
                                'company_id' => $companyId, 
                                'game_id' => $gameId,
                                'username' => $username,
                                'turnover' => $totalBet,
                                'bet_count' => 1,
                                'member_win' => $allTotalWin,
                                'month' => date('n'),
                                'year' => date('Y')
                            ]);
                        }
                    }

                    foreach($modelRekapReport as $modelrekap) {

                        $model = "App\\Models\\$modelrekap";

                        $datarekapwinlose = $model::where('company_id', $companyId)->whereDate('created_at', date('Y-m-d'));

                        if ($modelrpt == 'ReportRekapMonthlyWinlose') {
                            $datarekapwinlose = $datarekapwinlose->where('month', date('n'))->where('year', date('Y'));
                        }

                        if ($modelrpt == 'ReportRekapYearlyWinlose') {
                            $datarekapwinlose = $datarekapwinlose->where('year', date('Y'));
                        }

                        $datarekapwinlose = $datarekapwinlose->first(); 
                        if($datarekapwinlose) {
                            $datarekapwinlose->increment('turnover', $totalBet);
                            $datarekapwinlose->increment('bet_count', 1);
                            $datarekapwinlose->increment('member_win', $allTotalWin);
                        } else {
                            $model::create([
                                'company_id' => $companyId,
                                'turnover' => $totalBet,
                                'bet_count' => 1,
                                'member_win' => $allTotalWin,
                                'month' => date('n'),
                                'year' => date('Y')
                            ]);
                        }  
                    }
                   
                }
            } else {
                Log::channel('error-custom-logs')->error("Settle API gagal: HTTP " . $response->status() . " response : " . json_encode($response->json()) . ' ,body : ' . json_encode($data) . ' ,url : ' . $url);
            }
        } catch (\Throwable $e) {
            Log::channel('error-custom-logs')->error("Settle API Exception: " . json_encode($e->getMessage()));
        }
    }

    private function getDataBet($dataBet)
    {
        $dataBetting = [];
        if (($dataBet->mc ?? 0) > 0) {
            $dataBetting[] = 'mc';
        }
        if (($dataBet->head_mc ?? 0) > 0) {
            $dataBetting[] = 'head_mc';
        }
        if (($dataBet->body_mc ?? 0) > 0) {
            $dataBetting[] = 'body_mc';
        }
        if (($dataBet->leg_mc ?? 0) > 0) {
            $dataBetting[] = 'leg_mc';
        }
        if (($dataBet->bm ?? 0) > 0) {
            $dataBetting[] = 'bm';
        }
        if (($dataBet->head_bm ?? 0) > 0) {
            $dataBetting[] = 'head_bm';
        }
        if (($dataBet->body_bm ?? 0) > 0) {
            $dataBetting[] = 'body_bm';
        }
        if (($dataBet->leg_bm ?? 0) > 0) {
            $dataBetting[] = 'leg_bm';
        }

        return $dataBetting;
    }
}
