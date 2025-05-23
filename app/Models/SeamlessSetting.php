<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeamlessSetting extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'type', 'domain', 'endpoint', 'is_enable'];
    protected $table = 'seamless_settings';

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

}
