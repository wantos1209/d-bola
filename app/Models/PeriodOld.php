<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodOld extends Model
{
    use HasFactory;

    protected $fillable = ['game_id', 'periodno', 'win_state', 'statusgame'];
    protected $table = 'period_old';
}
