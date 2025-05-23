<?php

namespace App\Console\Commands;

use App\Models\Period;
use App\Models\PeriodBet;
use App\Models\PeriodBetOld;
use App\Models\PeriodOld;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MigrationPeriodToOldDataCommand extends Command
{
    protected $signature = 'migration-period-to-old-data-command';
    protected $description = 'Command description';

    public function handle()
    {
        $this->backupPeriodData();
    }

    private function backupPeriodData()
    {
        DB::beginTransaction();
        try {
            $dataPeriod = Period::latest()->limit(3)->get();
            
            if ($dataPeriod->count() < 3) {
                Log::channel('error-custom-logs')->error('Not enough data in Period table.');
                return;
            }
            
            $created_at = $dataPeriod[2]->created_at;
            
            $data = Period::where('created_at', '<', $created_at)->get();
            
            $periodOldData = [];
            
            foreach ($data as $item) {
                $periodOldData[] = [
                    'id' => $item->id,
                    'game_id' => $item->game_id,
                    'periodno' => $item->periodno,
                    'win_state' => $item->win_state,
                    'statusgame' => $item->statusgame,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            }
            
            if (!empty($periodOldData)) {
                PeriodOld::insert($periodOldData);
                
                $IdPeriod = $data->pluck('id')->toArray(); 

                $this->backupPeriodBetData($created_at);
                
                try {
                    Period::whereIn('id', $IdPeriod)->delete(); 
                } catch (\Exception $e) {
                    Log::channel('error-custom-logs')->error('Error deleteing period: ' . $e->getMessage());
                }
                
            }

            DB::commit(); 
        } catch (\Exception $e) {
            DB::rollBack(); 
            Log::channel('error-custom-logs')->error('Error during migration Period: ' . $e->getMessage());
        }
    }

private function backupPeriodBetData($created_at)
{
    DB::beginTransaction();
    try {
        $dataPeriod = Period::where('created_at', '>=', $created_at)->get();
       
        if ($dataPeriod->count() <= 0) {
            Log::channel('error-custom-logs')->error('Not enough data in Period table.');
            return;
        }
       
        $dataPeriodId = $dataPeriod->pluck('id')->toArray();

        $data = PeriodBet::whereNotIn('period_id', $dataPeriodId)->get();

        $periodBetOldData = [];
        
        foreach ($data as $item) {
           
            $periodBetOldData[] = [
                'id' => $item->id,
                'company_id' => $item->company_id,
                'period_old_id' => $item->period_id,
                'transaction_code' => $item->transaction_code,
                'username' => $item->username,
                'mc' => $item->mc,
                'head_mc' => $item->head_mc,
                'body_mc' => $item->body_mc,
                'leg_mc' => $item->leg_mc,
                'bm' => $item->bm,
                'head_bm' => $item->head_bm,
                'body_bm' => $item->body_bm,
                'leg_bm' => $item->leg_bm,
                'mc_win' => $item->mc_win,
                'head_mc_win' => $item->head_mc_win,
                'body_mc_win' => $item->body_mc_win,
                'leg_mc_win' => $item->leg_mc_win,
                'bm_win' => $item->bm_win,
                'head_bm_win' => $item->head_bm_win,
                'body_bm_win' => $item->body_bm_win,
                'leg_bm_win' => $item->leg_bm_win,
                'amount_bet' => $item->amount_bet,
                'amount_win' => $item->amount_win,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        }
        // dd($periodBetOldData);
        if (!empty($periodBetOldData)) {
            PeriodBetOld::insert($periodBetOldData);
            PeriodBet::whereNotIn('period_id', $dataPeriodId)->delete();
        }

        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();
        Log::channel('error-custom-logs')->error('Error during migration PeriodBet data: ' . $e->getMessage());
    }
}
}
