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
       Schema::create('hero_sections', function (Blueprint $table) {
        $table->id();
        $table->string('subheader', 255);
        $table->string('title', 255);
        $table->longText('description_html');
        $table->string('button1_text', 100);
        $table->string('button1_link', 1024);
        $table->string('button2_text', 100);
        $table->string('button2_link', 1024);
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->useCurrent();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_sections');
    }
};
