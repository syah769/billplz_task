<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'size',
        'pepperoni',
        'extra_cheese',
        'base_price',
        'pepperoni_price',
        'extra_cheese_price',
        'total_price'
    ];

    protected $casts = [
        'pepperoni' => 'boolean',
        'extra_cheese' => 'boolean',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
