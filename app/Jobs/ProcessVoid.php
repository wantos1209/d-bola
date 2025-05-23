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

class ProcessVoid implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;

    public function __construct($data)
    {
        $data['dataPeriodBet'] = $data['dataPeriodBet']->toArray();
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
            foreach($this->data['dataPeriodBet'] as $dt) {
                $this->apiCancel($dt['username'], $dt['transaction_code'], $this->data['companyKey']);
            }
            Period::where('id', $this->data['period_id'])->update([
                'statusgame' => 3
            ]);

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
            Log::channel('error-custom-logs')->error("Job ProcessVoid Error: " . $e->getMessage());
        }
    }


    function apiCancel($username, $transactionCode, $companyKey)
    {
        $url = env('URL_SEAMLESS') . '/api/Cancel';
        $data = [
            "CompanyKey" => $companyKey,
            "TransactionCode" => $transactionCode,
            'Username' => $username,
        ];
        
        $response = Http::post($url, $data);

        if ($response->successful()) {
            if($response->json()["ErrorCode"] == 0) {
                $this->apiGetBalance($username, $companyKey);
                return [
                    'message' => 'Success',
                    'data' => $response->json(),
                ];
            } else {
                PendingSeamless::create([
                    'jenis_request' => 2,
                    'periodno' => '-',
                    'transaction_code' => $transactionCode,
                    'username' => $username,
                ]);
                Log::channel('error-custom-logs')->error("['ApiController', 'apiCancel'] Failed apiCancel : ", [
                    'body' => $data,
                    'ErrorCode' => $response->json()["ErrorCode"],
                ]);
            }
        } else {
             PendingSeamless::create([
                'jenis_request' => 2,
                'periodno' => '-',
                'transaction_code' => $transactionCode,
                'username' => $username,
            ]);
            Log::channel('error-custom-logs')->error("['ApiController', 'apiCancel'] Failed apiCancel : ", [
                'body' => $data,
                'error' => $response->body(),
            ]);
        }

        return;
    }

    function apiGetBalance($username, $companyKey)
    {
        $url = env('URL_SEAMLESS') . '/api/GetBalance';

        $data = [
            'CompanyKey' => $companyKey,
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
}
