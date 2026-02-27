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
        Schema::create('temptation_requirements', function (Blueprint $table) {
        $table->id();
        $table->foreignId('temptation_section_id')
            ->constrained('temptation_sections')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
        $table->string('text', 1024);
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
        Schema::dropIfExists('temptation_requirements');
    }
};
