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
        Schema::create('media', function (Blueprint $table) {
        $table->id();
        $table->string('path', 512);
        $table->enum('type', ['image', 'video', 'file', 'svg'])->default('image');
        $table->string('mime_type', 100);
        $table->integer('width');
        $table->integer('height');
        $table->bigInteger('size_bytes');
        $table->string('alt_text', 255);
        $table->string('title', 255);
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->useCurrent();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
