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
       Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('testimonials_section_id')
                ->constrained('testimonials_sections')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('video_media_id')->nullable()
                ->constrained('media')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->text('text');
            $table->string('name', 255);
            $table->string('position', 255);
            $table->integer('duration_seconds');
            $table->integer('sort_order')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
