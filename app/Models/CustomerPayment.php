<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    protected $table = 'customers_payments';

    protected $fillable = [
        'payment_method',
        'amount_to_pay'
    ];

    use HasFactory;
}
