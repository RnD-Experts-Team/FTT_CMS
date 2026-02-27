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
        Schema::create('why_us_items', function (Blueprint $table) {
        $table->id();
        $table->string('name', 255);
        $table->foreignId('icon_media_id')->nullable()
            ->constrained('media')
            ->cascadeOnUpdate()
            ->nullOnDelete();
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
        Schema::dropIfExists('why_us_items');
    }
};
