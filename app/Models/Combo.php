<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Combo extends Model
{
    use HasFactory;

    protected $fillable = [
        'discount',
        'total_price',
        'total_discount',
        'description'
    ];

    public $timestamps = true;

    public function comboDetails()
    {
        return $this->hasMany(ComboDetail::class);
    }
}
