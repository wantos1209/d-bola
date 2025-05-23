<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalyticQueue extends Model
{
    use HasFactory;

    protected $fillable = ['total_job_success', 'total_job_failed', 'total_time_execution'];
    protected $table = 'analytic_queue';
    
}
