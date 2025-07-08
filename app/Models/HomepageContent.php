<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_type',
        'title',
        'subtitle',
        'description',
        'image_url',
        'button_text',
        'button_url',
        'extra_data',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'extra_data' => 'array',
        'is_active' => 'boolean',
    ];

    // Scope for active content
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for specific section type
    public function scopeBySection($query, $section_type)
    {
        return $query->where('section_type', $section_type);
    }

    // Scope for ordered content
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    // Get content by section type
    public static function getBySection($section_type)
    {
        return self::active()
            ->bySection($section_type)
            ->ordered()
            ->get();
    }
}
