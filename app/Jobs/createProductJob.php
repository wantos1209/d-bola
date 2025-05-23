<?php
namespace App\Jobs;

use App\Models\AnalyticQueue;
use App\Models\JobMonitor;
use App\Models\MonitorQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class createProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $start = microtime(true);

        $monitor = MonitorQueue::create([
            'name' => 'createProductJob',
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
            sleep(30);
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
        } catch (\Exception  $e) {
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

            throw $e;
        }
    }
}
