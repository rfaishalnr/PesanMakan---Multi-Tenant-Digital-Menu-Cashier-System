<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menambahkan 'ready' ke dalam ENUM status menggunakan DB statement
        DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('pending', 'success', 'failed', 'ready') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Mengembalikan ENUM status seperti semula jika di-rollback
        DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('pending', 'success', 'failed') NOT NULL DEFAULT 'pending'");
    }
};