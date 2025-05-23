<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $fillable = ['game_id', 'periodno', 'win_state', 'statusgame'];
    protected $table = 'period';

    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($period) {
            $period->periodno = $period->generatePreiodBetNo();
        });
    }

    public function generatePreiodBetNo()
    {
        $year = now()->format('y');
        $month = now()->format('m');

        $lastPeriodBet = Period::where('periodno', 'like', "P{$year}{$month}%")
            ->orderBy('periodno', 'desc')
            ->first();

        if ($lastPeriodBet) {
            $lastNumber = (int)substr($lastPeriodBet->periodno, -6);
            $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '000001';
        }

        return "P{$year}{$month}{$newNumber}";
    }
}
