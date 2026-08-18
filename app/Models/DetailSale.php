<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailSale extends Model
{
    public $timestamp = true;

    protected $fillable =[
        'product_id',
        'sale_id',
        'precio',
        'cantidad',
        'total'
    ];
    
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
