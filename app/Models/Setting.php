<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Setting extends Model
{
    use HasFactory;

    use HasFactory;
    protected $fillable = [
        'nombre',
        'direccion',
        'ruc',
        'telefono',
        'email',
        'propietario',
        'consecutivo'
    ];

    public $timestamp = true;
}
