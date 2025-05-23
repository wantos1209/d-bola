<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodBet extends Model
{
    use HasFactory;

    protected $fillable = ['period_id', 'transaction_code', 'username', 'mc', 'head_mc', 'body_mc', 'leg_mc', 'bm', 'head_bm', 'body_bm', 'leg_bm','mc_win', 'head_mc_win', 'body_mc_win', 'leg_mc_win', 'bm_win', 'head_bm_win', 'body_bm_win', 'leg_bm_win', 'amount_bet', 'amount_win'];
    protected $table = 'period_bet';

    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'username', 'username');
    }
}
