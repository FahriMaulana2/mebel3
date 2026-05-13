<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',

        'fullname',
        'phone',
        'address',
        'city',
        'postal_code',
        'courier',

        'items',

        'total_amount',
        'shipping_cost',
        'grand_total',

        'status',
        'notes'
    ];

    protected $casts = [
        'items' => 'array',

        'total_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔥 INI YANG BELUM ADA
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }

    /*
    |--------------------------------------------------------------------------
    | AUTO ORDER NUMBER
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {

            if (!$order->order_number) {
                $order->order_number =
                    'INV-' .
                    date('Ymd') .
                    '-' .
                    strtoupper(Str::random(6));
            }
        });
    }
}