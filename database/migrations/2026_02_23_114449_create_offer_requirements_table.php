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
        Schema::create('offer_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_section_id')
                ->constrained('offer_sections')
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
        Schema::dropIfExists('offer_requirements');
    }
};
