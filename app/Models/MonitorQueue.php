<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitorQueue extends Model
{
    use HasFactory;

    protected $fillable = ['failed_job_id', 'name', 'attempt', 'duration', 'error', 'status'];
    protected $table = 'monitor_queue';
    
}
