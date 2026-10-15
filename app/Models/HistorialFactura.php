<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class HistorialFactura extends Model
{
    use HasFactory;

    protected $fillable =[
        'numFactura',
        'fecha',
        'monto',
        'descripcion',
        'client_id',
        'user_id',
        'sale_id',
        'metodoPago'
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function sale()
{
    // Si en la tabla sales el campo es "numero_factura"
    return $this->belongsTo(Sale::class, 'numFactura', 'numFactura'); 
}
}
