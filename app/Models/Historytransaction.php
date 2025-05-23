<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Transactions;
use App\Models\TransactionsSaldo;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;

class Historytransaction extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'game_id', 'period_id', 'username', 'periodno', 'transaction_code', 'keterangan', 'status', 'betting', 'debit', 'kredit', 'balance'];
    protected $table = 'historytransaction';

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function game()
    {
        return $this->belongsTo(Company::class, 'game_id', 'id');
    }

    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id', 'id');
    }
}
