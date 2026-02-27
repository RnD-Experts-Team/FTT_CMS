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
     Schema::create('founder_sections', function (Blueprint $table) {
        $table->id();
        $table->string('hook_text', 255);
        $table->string('title', 255);
        $table->longText('description');
        $table->foreignId('video_media_id')->nullable()
            ->constrained('media')
            ->cascadeOnUpdate()
            ->nullOnDelete();
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->useCurrent();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('founder_sections');
    }
};
