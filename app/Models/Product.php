<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
        'stock',
        'fecha_vencimiento',
        'precio_compra',
        'precio_venta_unidad',
        'precio_venta_mayor',
        'category_id',
        'combo_id',
        'codigo'
    ];
    public $timestamp = true;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function detailOrder()
    {
        return $this->hasMany(DetailOrder::class);
    }

    public function detailSale()
    {
        return $this->hasMany(DetailSale::class);
    }

    public function sales()
    {
        return $this->hasMany(ProductSale::class);
    }

    public function creditSales()
    {
        return $this->hasMany(CreditSale::class);
    }

    public function comboDetails()
    {
        return $this->hasMany(ComboDetail::class);
    }
}
