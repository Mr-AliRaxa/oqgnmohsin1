<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'bank_name',
        'account_name',
        'account_number',
        'iban',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
