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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('slug')->unique();
            $table->text('content')->nullable();
            $table->string('excerpt')->nullable();
            $table->json('image')->nullable();
            $table->string('video')->nullable();
            $table->json('gallery')->nullable();

            $table->json('challenges')->nullable();
            //systems

            $table->string('system_title')->nullable();
            $table->string('system_description')->nullable();
            $table->json('system_desktop')->nullable();
            $table->json('system_mobile')->nullable();

            //Colors
            $table->json('colors')->nullable();
            $table->json('colorscheme')->nullable();
            //Typography
            $table->json('typography')->nullable();
            //website
            $table->json('call_to_action')->nullable();

            $table->json('approaches')->nullable();
            $table->enum('status', ['draft', 'reviewing', 'published', 'rejected'])->default('published');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('og_title')->nullable();
            $table->string('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('twitter_card')->nullable();
            $table->string('twitter_title')->nullable();
            $table->string('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();
            $table->json('schema_json')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
