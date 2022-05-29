<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    use HasFactory;

    protected $fillable = [
        'total_price'
    ];

    public function customers()
    {
        return $this->hasMany(CustomerPayment::class);
    }
}
