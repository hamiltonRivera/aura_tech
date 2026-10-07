<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{


    protected $fillable = [
        'client_id',
        'fecha',
        'numFactura',
        'descuento',
        'totalPagado',
        'cambio',
        'totalRecibido',
        'totalDescuento',
        'totalPagadoDescuento',
        'user_id',
        'metodoPago',
        'status'
    ];

    protected $casts = [
        'fecha' => 'date',
        'descuento' => 'decimal:2',
        'totalPagado' => 'decimal:2',
        'cambio' => 'decimal:2',
        'totalRecibido' => 'decimal:2',
        'totalDescuento' => 'decimal:2',
        'totalPagadoDescuento' => 'decimal:2',
    ];

    public function detailSales()
    {
      return $this->hasMany(DetailSale::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cashRegister()
    {
        return $this->belongsTo(CashRegister::class);
    }
}
