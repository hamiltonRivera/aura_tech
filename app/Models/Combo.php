<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Combo extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_price',
        'description'
    ];

    public $timestamps = true;

    public function comboDetails()
    {
        return $this->hasMany(ComboDetail::class);
    }

    public function products()
{
    return $this->belongsToMany(Product::class, 'combo_details', 'combo_id', 'product_id')
                ->withPivot('quantity');
}
}
