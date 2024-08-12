<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'order_id',
        'user_id',
        'customer_name',
        'total_amount',
        'status'
    ];

    protected $enum = [
        'status' => [self::STATUS_PENDING, self::STATUS_PROCESSING, self::STATUS_COMPLETED, self::STATUS_CANCELED, self::STATUS_FAILED],
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
