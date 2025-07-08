<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Automatically generate slug when creating
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (!$category->slug) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Relationship with products
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Scope for active categories
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
