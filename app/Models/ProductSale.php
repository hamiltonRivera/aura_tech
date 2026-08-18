<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{

    protected $fillable =[
        'date',
        'product_id',
        'quantity_sold'
    ];

    protected $casts = [
        'date' => 'date',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}
