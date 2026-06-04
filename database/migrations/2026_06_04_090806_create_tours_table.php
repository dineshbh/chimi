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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('category');
            $table->string('duration');
            $table->text('snippet');
            $table->string('price')->nullable();
            $table->string('hero_image')->nullable();
            $table->text('departure_dates')->nullable();
            $table->text('faqs')->nullable();
            $table->text('reviews')->nullable();
            $table->longText('content_html');
            $table->longText('content_text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
