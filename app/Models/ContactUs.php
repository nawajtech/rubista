<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'hero_title',
        'hero_subtitle',
        'hero_description',
        'address',
        'phone',
        'email',
        'working_hours',
        'map_embed_code',
        'contact_info',
        'form_title',
        'form_description',
        'meta_title',
        'meta_description',
        'is_active',
    ];

    protected $casts = [
        'contact_info' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
