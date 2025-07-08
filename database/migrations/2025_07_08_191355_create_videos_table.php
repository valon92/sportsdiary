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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Title of the video
            $table->text('description')->nullable(); // Description of the video, can be null
            $table->string('video_url'); // URL path to the video file
            $table->string('thumbnail_url')->nullable(); // URL path to the video thumbnail, can be null
            $table->integer('likes')->default(0); // Number of likes, defaults to 0
            $table->string('username')->nullable(); // Username of the uploader (for initial simulation)
            // If we later implement full user authentication and profiles, we would link it here:
            // $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
