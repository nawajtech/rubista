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
        Schema::table('products', function (Blueprint $table) {
            $table->string('brand')->nullable()->after('category_id');
            $table->string('color')->nullable()->after('brand');
            $table->string('dimension')->nullable()->after('color');
            $table->string('model')->nullable()->after('dimension');
            $table->string('warranty_period')->nullable()->after('model');
            $table->text('return_policy')->nullable()->after('warranty_period');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['brand', 'color', 'dimension', 'model', 'warranty_period', 'return_policy']);
        });
    }
};
