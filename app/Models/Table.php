<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'tables';

    protected $fillable = [
        'status',
        'seats_taken'
    ];

    use HasFactory;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
