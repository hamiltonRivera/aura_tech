<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComboDetail extends Model
{
    protected $fillable = [
        'quantity',
        'product_id',
        'combo_id',
    ];

    public $timestamps = true;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function combo()
    {
        return $this->belongsTo(Combo::class);
    }
}
