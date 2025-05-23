<?php

namespace App\Jobs;

use App\Models\AnalyticQueue;
use App\Models\GameBettingAnalyticDay;
use App\Models\GameBettingAnalyticMonth;
use App\Models\GameBettingAnalyticYear;
use App\Models\Historytransaction;
use App\Models\HistorytransactionOld;
use App\Models\MonitorQueue;
use App\Models\Outstanding;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class createHistoryJob
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


        $dataOutstanding = $this->data['outstanding'];
        $dataHistory = $this->data['historyTransaksi'];
        $gameId = $this->data['gameId'];

        try {
            Outstanding::create($dataOutstanding);
            Historytransaction::create($dataHistory);
            HistorytransactionOld::create($dataHistory);

            $dataAnalytics = [
                GameBettingAnalyticDay::class,
                GameBettingAnalyticMonth::class,
                GameBettingAnalyticYear::class
            ];

            foreach ($dataAnalytics as $modelAnalytic) {
                $query = $modelAnalytic::where('game_id', $gameId);

                if ($modelAnalytic === GameBettingAnalyticMonth::class) {
                    $query->where('month', date('n'))->where('year', date('Y'));
                } elseif ($modelAnalytic === GameBettingAnalyticYear::class) {
                    $query->where('year', date('Y'));
                }

                $dataBetting = $query->first();

                if ($dataBetting) {
                    $dataBetting->increment('count_bet');
                } else {
                    $attributes = [
                        'game_id' => $gameId,
                        'count_bet' => 1
                    ];

                    if ($modelAnalytic === GameBettingAnalyticMonth::class) {
                        $attributes['month'] = date('n');
                        $attributes['year'] = date('Y');
                    } elseif ($modelAnalytic === GameBettingAnalyticYear::class) {
                        $attributes['year'] = date('Y');
                    }

                    $modelAnalytic::create($attributes);
                }
            }

            $end = microtime(true);
            $duration = round($end - $start, 3); 

            $monitor->update([
                'duration' => $duration,
                'status' => 2 
            ]);

            $analytic ->update([
                'total_job_success' => $analytic->total_job_success + 1,
                'total_time_execution' => $analytic->total_time_execution + $duration,
            ]);
            
        } catch (\Throwable $e) {
            $end = microtime(true);
            $duration = round($end - $start, 3);

            $monitor->update([
                'duration' => $duration,
                'status' => 3, 
                'exception' => $e->getMessage()
            ]);

            $analytic ->update([
                'total_job_failed' => $analytic->total_job_failed + 1,
                'total_time_execution' => $analytic->total_time_execution + $duration,
            ]);

            Log::channel('error-custom-logs')->error('Gagal menyimpan data transaksi', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'outstanding' => $dataOutstanding,
                'history' => $dataHistory
            ]);
        }
    }
}
