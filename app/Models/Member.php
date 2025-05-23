<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Member extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['company_id', 'username', 'password', 'periodno', 'statusgame', 'status', 'min_bet', 'max_bet'];
    protected $table = 'member';

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
