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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            
            // Content Fields
            $table->string('title', 255);
            $table->string('slug', 255)->unique()->index();
            $table->longText('description');
            $table->string('featured_image', 500)->nullable();
            $table->string('video_path', 500)->nullable();
            $table->string('bridge_text', 500)->nullable();
            $table->string('scroll_text', 500)->nullable();
            
            // Arbitrage Loop
            $table->foreignId('next_post_id')->nullable()->constrained('posts')->nullOnDelete();
            $table->integer('sort_order')->default(0)->index();
            
            // Analytics
            $table->unsignedBigInteger('views')->default(0);
            
            // Status
            $table->boolean('is_active')->default(true)->index();
            
            // SEO Overrides
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->string('focus_keyword', 100)->nullable();
            
            // Dates
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
