<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('about_us', function (Blueprint $table) {
            $table->string('hero_image_url')->nullable()->after('hero_description');
            $table->string('our_story_image_url')->nullable()->after('content');
            $table->string('mission_image_url')->nullable()->after('mission');
            $table->string('vision_image_url')->nullable()->after('vision');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_us', function (Blueprint $table) {
            $table->dropColumn(['hero_image_url', 'our_story_image_url', 'mission_image_url', 'vision_image_url']);
        });
    }
};
