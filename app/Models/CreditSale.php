<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditSale extends Model
{
    protected $fillable = [
        'client_id',
        'date',
        'voucher_number',
        'total_debt',
        'user_id',
        'outstanding_balance',
        'status',
        'due_date',
        'days_overdue'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creditPayments()
    {
        return $this->hasMany(CreditPayment::class);
    }

    public function creditDetails()
    {
        return $this->hasMany(CreditDetail::class);
    }
}
