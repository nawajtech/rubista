<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'sale_price',
        'sku',
        'stock_quantity',
        'image',
        'gallery',
        'status',
        'featured',
        'category_id',
        'sort_order',
        'brand',
        'color',
        'dimension',
        'model',
        'warranty_period',
        'return_policy'
    ];

    protected $casts = [
        'status' => 'boolean',
        'featured' => 'boolean',
        'gallery' => 'array',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    // Automatically generate slug and SKU when creating
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (!$product->slug) {
                $product->slug = Str::slug($product->name);
            }
            if (!$product->sku) {
                $product->sku = 'PRD-' . strtoupper(Str::random(8));
            }
        });
    }

    // Relationship with category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Scope for active products
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Scope for featured products
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    // Get the display price (sale price if available, otherwise regular price)
    public function getDisplayPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    // Check if product is on sale
    public function getIsOnSaleAttribute()
    {
        return !is_null($this->sale_price) && $this->sale_price < $this->price;
    }

    // Relationship with reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Get approved reviews
    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('status', true);
    }

    // Get average rating
    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    // Get total reviews count
    public function getTotalReviewsAttribute()
    {
        return $this->approvedReviews()->count();
    }
}
