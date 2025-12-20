<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'hero_title',
        'hero_subtitle',
        'hero_description',
        'hero_image_url',
        'content',
        'our_story_image_url',
        'mission',
        'mission_image_url',
        'vision',
        'vision_image_url',
        'values',
        'features',
        'stats',
        'team',
        'meta_title',
        'meta_description',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'stats' => 'array',
        'team' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
