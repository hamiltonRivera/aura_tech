<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombreApellido',
        'ciudad',
        'direccion',
        'telefono'
    ];

    public function historial()
    {
        return $this->hasMany(HistorialFactura::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function creditSales()
    {
        return $this->hasMany(CreditSale::class);
    }


}
