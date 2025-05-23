<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class GroupMenu extends Model
{
    use HasFactory, HasApiTokens;
    
    protected $fillable = ['name'];
    protected $table = 'group_menu';

}
