<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class DetailOrder extends Model
{
    use HasFactory;
    public $timestamp = true;

    protected $fillable = [
        'order_id',
        'product_id',
        'precio',
        'cantidad',
        'total'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
