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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->float('grade', 1);
            $table->string('engine', 100);
            $table->string('power', 100);
            $table->string('transmission', 100);
            $table->string('drive', 100);
            $table->string('mileage', 100);
            $table->string('tact', 100);
            $table->string('description', 1000)->nullable();

            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('model_id')->constrained('models');
            $table->foreignId('maker_id')->constrained('makers');

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
        Schema::dropIfExists('reviews');
    }
};
