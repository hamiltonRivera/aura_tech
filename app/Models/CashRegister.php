<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashRegister extends Model
{
    protected $fillable = [
        'date',
        'opening_amount',
        'last_closing_amount',
        'closing_amount',
        'user_id',
    ];

    // Relación con el usuario que registró el cierre
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con las ventas de ese turno/arqueo
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
