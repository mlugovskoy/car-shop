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
        Schema::create('comment_news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_id')->constrained('news')->onDelete('cascade');
            $table->foreignId('comment_id')->constrained('comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_news');
    }
};
