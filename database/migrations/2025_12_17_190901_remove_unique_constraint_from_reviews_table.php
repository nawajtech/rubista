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
        Schema::table('reviews', function (Blueprint $table) {
            // Drop the unique constraint that prevents multiple reviews from same user
            // Use the exact constraint name as it appears in the database
            $table->dropUnique('reviews_product_id_user_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Re-add the unique constraint if rolling back
            $table->unique(['product_id', 'user_id']);
        });
    }
};
