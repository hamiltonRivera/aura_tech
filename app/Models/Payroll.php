<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'monthly_salary',
        'quarter_salary',
        'daily_salary',
        'holly_days',
        'total_payment_holly_days',
        'total_payment_monthly',
        'total_payment_quarter',
        'apply_deductions',
        'inss_deduction',
        'ir_deduction',
        'net_payment_quarter'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
