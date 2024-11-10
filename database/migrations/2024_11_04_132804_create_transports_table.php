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
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            $table->string('city', 100);
            $table->string('vin', 255);
            $table->string('phone', 45);
            $table->string('description', 500)->nullable();
            $table->string('engine', 100);
            $table->string('power', 100);
            $table->string('transmission', 100);
            $table->string('drive', 100);
            $table->string('mileage', 100);
            $table->string('color', 100);
            $table->string('steering_wheel', 100);
            $table->string('country', 100);
            $table->string('tact', 100);
            $table->string('fuel_supply_type', 100);
            $table->integer('doors');
            $table->integer('seats');
            $table->integer('price');
            $table->integer('year');

            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('model_id')->constrained('models');
            $table->foreignId('maker_id')->constrained('makers');
            $table->foreignId('fuel_type_id')->constrained('fuel_types');
            $table->foreignId('transport_type_id')->constrained('transport_types');

            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transports');
    }
};
