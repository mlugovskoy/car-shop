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
            $table->boolean('active');
            $table->string('city', 100)->nullable();
            $table->string('vin', 255)->nullable();
            $table->string('phone', 45)->nullable();
            $table->string('description', 1000)->nullable();
            $table->string('engine', 100)->nullable();
            $table->string('power', 100)->nullable();
            $table->string('transmission', 100)->nullable();
            $table->string('drive', 100)->nullable();
            $table->string('mileage', 100)->nullable();
            $table->string('color', 100)->nullable();
            $table->string('steering_wheel', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('tact', 100)->nullable();
            $table->string('fuel_supply_type', 100)->nullable();
            $table->integer('doors')->nullable();
            $table->integer('seats')->nullable();
            $table->integer('price');
            $table->integer('year')->nullable();

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
