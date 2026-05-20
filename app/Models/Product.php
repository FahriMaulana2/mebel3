<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'images',
        'category',
        'is_featured',
        'is_active',
        'views',

        // DISKON
        'discount_percentage',
        'discount_start',
        'discount_end',
        'is_discount', // TAMBAHAN
    ];

    protected $casts = [
        'images' => 'array',

        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'is_discount' => 'boolean', // TAMBAHAN

        'price' => 'decimal:2',

        // DISKON
        'discount_percentage' => 'decimal:2',
        'discount_start' => 'datetime',
        'discount_end' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /*
    |--------------------------------------------------------------------------
    | AUTO GENERATE SLUG
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR IMAGE URL
    |--------------------------------------------------------------------------
    */

    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : null;
    }

    /*
    |--------------------------------------------------------------------------
    | FINAL PRICE AFTER DISCOUNT
    |--------------------------------------------------------------------------
    */

    public function getFinalPriceAttribute()
    {
        if (
            $this->is_discount &&
            $this->discount_percentage &&
            $this->discount_start &&
            $this->discount_end &&
            now()->between(
                $this->discount_start,
                $this->discount_end
            )
        ) {

            return $this->price -
                ($this->price * $this->discount_percentage / 100);
        }

        return $this->price;
    }

    /*
    |--------------------------------------------------------------------------
    | CHECK ACTIVE DISCOUNT
    |--------------------------------------------------------------------------
    */

    public function getHasDiscountAttribute()
    {
        return
            $this->is_discount &&
            $this->discount_percentage &&
            $this->discount_start &&
            $this->discount_end &&
            now()->between(
                $this->discount_start,
                $this->discount_end
            );
    }

    /*
    |--------------------------------------------------------------------------
    | STOCK
    |--------------------------------------------------------------------------
    */

    public function isInStock()
    {
        return $this->stock > 0;
    }

    public function decreaseStock($quantity)
    {
        $this->stock -= $quantity;
        $this->save();
    }

    public function increaseStock($quantity)
    {
        $this->stock += $quantity;
        $this->save();
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}