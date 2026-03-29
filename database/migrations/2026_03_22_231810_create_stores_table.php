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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('whatsapp_number')->unique();
            $table->string('name')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->string('payment_gateway')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->boolean('is_subscribed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
