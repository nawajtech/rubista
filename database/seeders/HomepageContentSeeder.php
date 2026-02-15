<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomepageContent;

class HomepageContentSeeder extends Seeder
{
    /**
     * Seed homepage content so the home page is fully dynamic.
     * Matches sections used in resources/views/frontend/home.blade.php.
     */
    public function run(): void
    {
        $contents = [
            
            // Categories section heading
            [
                'section_type' => 'categories',
                'title' => 'CATEGORIES',
                'subtitle' => null,
                'description' => null,
                'image_url' => null,
                'button_text' => null,
                'button_url' => null,
                'sort_order' => 0,
                'is_active' => true,
                'extra_data' => null,
            ],
            // Smart Watches section
            [
                'section_type' => 'smart_watches',
                'title' => 'SMART WATCHES',
                'subtitle' => null,
                'description' => null,
                'image_url' => null,
                'button_text' => null,
                'button_url' => null,
                'sort_order' => 0,
                'is_active' => true,
                'extra_data' => null,
            ],
            [
                'section_type' => 'watch_banner',
                'title' => 'Resistance',
                'subtitle' => 'Zinc Alloy body',
                'description' => null,
                'image_url' => null,
                'button_text' => null,
                'button_url' => null,
                'sort_order' => 0,
                'is_active' => true,
                'extra_data' => null,
            ],
            // Power Banks section
            [
                'section_type' => 'powerbank',
                'title' => 'POWER BANKS',
                'subtitle' => null,
                'description' => null,
                'image_url' => null,
                'button_text' => null,
                'button_url' => null,
                'sort_order' => 0,
                'is_active' => true,
                'extra_data' => [
                    'banner_title' => '20000mAh',
                    'banner_subtitle' => 'Lithium Polymer Battery',
                ],
            ],
            // Discounts For You heading
            [
                'section_type' => 'discounts_heading',
                'title' => 'DISCOUNTS FOR YOU',
                'subtitle' => null,
                'description' => null,
                'image_url' => null,
                'button_text' => null,
                'button_url' => null,
                'sort_order' => 0,
                'is_active' => true,
                'extra_data' => null,
            ],
            // Shop By Discounts section
            [
                'section_type' => 'discounts_section',
                'title' => 'Shop By <span>Discounts</span>!',
                'subtitle' => 'HURRY UP! SALE ENDS IN',
                'description' => null,
                'image_url' => null,
                'button_text' => null,
                'button_url' => null,
                'sort_order' => 0,
                'is_active' => true,
                'extra_data' => [
                    'countdown' => [21, 50, 12, 2],
                ],
            ],
        ];

        foreach ($contents as $content) {
            HomepageContent::updateOrCreate(
                [
                    'section_type' => $content['section_type'],
                    'sort_order' => $content['sort_order'],
                    'title' => $content['title'],
                ],
                $content
            );
        }
    }
}
