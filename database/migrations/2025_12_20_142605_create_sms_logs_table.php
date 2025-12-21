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
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->string('mobile', 20)->index();
            $table->text('message');
            $table->string('template_id', 100)->nullable();
            $table->enum('status', ['sent', 'failed', 'pending'])->default('pending');
            $table->text('response')->nullable();
            $table->text('request_data')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
            
            $table->index(['mobile', 'status']);
            $table->index('sent_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
};
