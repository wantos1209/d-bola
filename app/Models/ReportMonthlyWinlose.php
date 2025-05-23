<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class ReportMonthlyWinlose extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['company_id', 'game_id', 'username', 'turnover', 'month', 'year', 'bet_count', 'member_win'];
    protected $table = 'report_monthly_winlose';

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function game()
    {
        return $this->belongsTo(Company::class, 'game_id', 'id');
    }
}
