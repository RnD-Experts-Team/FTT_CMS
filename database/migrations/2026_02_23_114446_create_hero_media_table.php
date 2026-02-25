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
       Schema::create('hero_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hero_section_id')
                ->constrained('hero_sections')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('media_id')->nullable()
                ->constrained('media')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->integer('sort_order')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_media');
    }
};
