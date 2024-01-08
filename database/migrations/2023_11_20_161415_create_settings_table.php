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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('email');
            $table->text('search_item');
            $table->text('place_name')->nullable();
            $table->text('formatted_address')->nullable();
            $table->text('place_id')->nullable();
            $table->longText('types')->nullable();
            $table->text('rating')->nullable();
            $table->text('rating_stats')->nullable();
            $table->text('lat')->nullable();
            $table->text('lng')->nullable();
            $table->text('negative_reviews_count')->nullable();
            $table->longText('reviews')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
