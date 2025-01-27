<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code', 16);
            $table->integer('quantity');
            $table->string('city', 100);
            $table->string('phone', 45);
            $table->string('email');
            $table->integer('price');

            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('transport_id')->constrained('transports');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
