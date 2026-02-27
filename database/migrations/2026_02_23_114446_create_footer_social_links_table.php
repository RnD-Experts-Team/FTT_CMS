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
       Schema::create('footer_social_links', function (Blueprint $table) {
        $table->id();
        $table->enum('platform', ['facebook','instagram','linkedin','whatsapp','fountain','indeed']);
        $table->string('url', 1024);
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
        Schema::dropIfExists('footer_social_links');
    }
};
