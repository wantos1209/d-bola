<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    protected $table = 'user_access';

    public function menuAccesses()
    {
        return $this->hasMany(MenuAccess::class, 'useraccess_id');
    }
    
}
