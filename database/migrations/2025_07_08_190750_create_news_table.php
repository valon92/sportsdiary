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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Column for news title
            $table->text('content'); // Column for news content (longer text)
            $table->string('image_url')->nullable(); // URL for the news image, can be null
            $table->string('author')->nullable(); // Author of the news, can be null
            $table->string('category')->nullable(); // Category of the news (e.g., 'Football', 'Basketball'), can be null
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
