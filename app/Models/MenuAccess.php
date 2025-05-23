<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class MenuAccess extends Model
{
    use HasFactory, HasApiTokens;
    
    protected $fillable = ['useraccess_id', 'menu_id', 'is_view', 'is_create', 'is_update', 'is_delete'];
    protected $table = 'menu_access';

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function userAccess()
    {
        return $this->belongsTo(UserAccess::class, 'useraccess_id');
    }
}
