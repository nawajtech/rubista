<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'meta_title',
        'meta_description',
        'pdf_url',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Scope for published pages
    public function scopePublished($query)
    {
        return $query->where('status', true);
    }

    // Get page by slug
    public static function getBySlug($slug)
    {
        return self::published()->where('slug', $slug)->first();
    }
}
