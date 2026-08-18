<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    public $timestamp = true;
    protected $fillable = [
        'descripcion',
        'fecha',
        'monto',
        'tipo_gasto'
    ];
}
