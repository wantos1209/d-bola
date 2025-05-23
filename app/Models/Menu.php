<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Menu extends Model
{
    use HasFactory, HasApiTokens;
    
    protected $fillable = ['group_id', 'name', 'route', 'icon'];
    protected $table = 'menu';

    public function groupMenu()
    {
        return $this->belongsTo(GroupMenu::class, 'group_id');
    }

    public function menuAccesses()
    {
        return $this->hasMany(MenuAccess::class, 'menu_id');
    }

}
