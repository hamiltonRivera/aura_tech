<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditDetail extends Model
{
    protected $fillable = [
        'credit_sale_id',
        'product_id',
        'price',
        'quantity',
        'total'
    ];

    public function creditSale()
    {
        return $this->belongsTo(CreditSale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
