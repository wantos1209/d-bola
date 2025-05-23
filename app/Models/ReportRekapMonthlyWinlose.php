<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class ReportRekapMonthlyWinlose extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['company_id', 'turnover', 'bet_count', 'member_win', 'month', 'year'];
    protected $table = 'report_rekap_monthly_winlose';

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
