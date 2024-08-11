<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'customer_name',
        'total_amount',
        'status'
    ];

    protected $enum = [
        'status' => ['pending', 'processing', 'completed', 'canceled'],
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->order_id = (string) Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pizzas()
    {
        return $this->hasMany(Pizza::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
