<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | PAYMENT STATUS CONSTANT
    |--------------------------------------------------------------------------
    */
    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_REJECTED = 'rejected';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'proof_image',
        'bank_name',
        'account_name',
        'status',
        'notes',
        'paid_at'
    ];

    /*
    |--------------------------------------------------------------------------
    | CASTING
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR - PROOF IMAGE URL
    |--------------------------------------------------------------------------
    */
    public function getProofImageUrlAttribute()
    {
        return $this->proof_image
            ? asset('storage/' . $this->proof_image)
            : null;
    }

    /*
    |--------------------------------------------------------------------------
    | MARK AS PAID (AMAN - TIDAK MENGUBAH ORDER YANG SUDAH COMPLETED)
    |--------------------------------------------------------------------------
    */
    public function markAsPaid()
    {
        // Update status payment
        $this->status = self::STATUS_PAID;
        $this->paid_at = now();
        $this->save();

        // Update order terkait
        if ($this->order) {
            $updateData = ['payment_status' => 'paid'];
            
            // HANYA update status order jika masih pending atau processed
            // JANGAN ubah jika sudah completed, shipped, atau cancelled
            if (in_array($this->order->status, ['pending', 'processed'])) {
                $updateData['status'] = 'processed';
            }
            
            $this->order->update($updateData);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | MARK AS REJECTED
    |--------------------------------------------------------------------------
    */
    public function markAsRejected()
    {
        $this->status = self::STATUS_REJECTED;
        $this->paid_at = null;
        $this->save();

        // Update order juga
        if ($this->order) {
            $this->order->update([
                'payment_status' => 'rejected',
            ]);
            // JANGAN ubah status order di sini
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CHECK STATUS HELPERS
    |--------------------------------------------------------------------------
    */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isPaid()
    {
        return $this->status === self::STATUS_PAID;
    }

    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }
}