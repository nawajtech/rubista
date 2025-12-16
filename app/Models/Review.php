<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'comment',
        'status',
        'photos',
        'videos',
    ];

    protected $casts = [
        'status' => 'boolean',
        'rating' => 'integer',
        'photos' => 'array',
        'videos' => 'array',
    ];

    // Relationship with product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relationship with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope for approved reviews
    public function scopeApproved($query)
    {
        return $query->where('status', true);
    }

    // Scope for pending reviews
    public function scopePending($query)
    {
        return $query->where('status', false);
    }
}
