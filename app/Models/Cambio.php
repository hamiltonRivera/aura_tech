<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cambio extends Model
{
    public $timestamp = true;
    protected $fillable = [
        'fecha',
        'valor'
    ];
}
