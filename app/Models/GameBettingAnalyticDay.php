<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class GameBettingAnalyticDay extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['game_id', 'count_bet'];
    protected $table = 'game_betting_analytic_day';
}
