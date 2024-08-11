<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'billplz_bill_id',
        'status',
        'amount'
    ];

    protected $enum = [
        'status' => ['pending', 'paid', 'cancelled', 'failed'],
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
