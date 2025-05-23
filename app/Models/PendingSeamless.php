<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingSeamless extends Model
{
    use HasFactory;

    protected $fillable = ['jenis_request', 'periodno', 'transaction_code', 'username'];
    protected $table = 'pending_seamless';

}
