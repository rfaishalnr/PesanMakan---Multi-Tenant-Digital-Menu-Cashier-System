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
        // Changed 'product' to 'products'
        Schema::table('products', function (Blueprint $table) {
            $table->string('rating')->after('price')->nullable();
            $table->boolean('is_popular')->after('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Changed 'product' to 'products'
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['rating', 'is_popular']);
        });
    }
};