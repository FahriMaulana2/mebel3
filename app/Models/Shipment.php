<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'recipient_name', 'phone', 'address', 'city', 'postal_code',
        'courier', 'tracking_number', 'status', 'shipped_at', 'delivered_at'
    ];

    protected $casts = [
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Courier labels
    public static function getCouriers()
    {
        return [
            'jne' => 'JNE',
            'jnt' => 'J&T Express',
            'sicepat' => 'SiCepat',
            'pos' => 'POS Indonesia',
        ];
    }

    public function getCourierNameAttribute()
    {
        return self::getCouriers()[$this->courier] ?? ucfirst($this->courier);
    }

    // Mark as shipped
    public function markAsShipped($trackingNumber = null)
    {
        if ($trackingNumber) {
            $this->tracking_number = $trackingNumber;
        }
        $this->status = 'shipped';
        $this->shipped_at = now();
        $this->save();
    }

    // Mark as delivered
    public function markAsDelivered()
    {
        $this->status = 'delivered';
        $this->delivered_at = now();
        $this->save();
    }
}