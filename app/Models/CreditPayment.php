<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditPayment extends Model
{
    protected $fillable = [
        'credit_sale_id',
        'payment_date',
        'amount_paid',
        'observations',
        'payment_method',
        'change_given',
        'amount_received',
    ];

    public function creditSale()
    {
        return $this->belongsTo(CreditSale::class);
    }
}
