<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Outstanding extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['company_id', 'username', 'periode_code', 'nominal'];
    protected $table = 'outstanding_periode';

}
