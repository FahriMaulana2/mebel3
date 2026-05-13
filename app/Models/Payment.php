<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'amount', 'payment_method', 'proof_image', 'bank_name',
        'account_name', 'status', 'notes', 'paid_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Accessor for proof image URL
    public function getProofImageUrlAttribute()
    {
        return $this->proof_image ? asset('storage/' . $this->proof_image) : null;
    }

    // Mark as paid
    public function markAsPaid()
    {
        $this->status = 'paid';
        $this->paid_at = now();
        $this->save();
    }
}