<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Menambahkan kolom QRIS di tabel Users (Toko)
        Schema::table('users', function (Blueprint $table) {
            $table->string('qris_image')->nullable()->after('store_logo');
        });

        // 2. Menambahkan kolom Bukti Transfer di tabel Transactions
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('proof_of_payment')->nullable()->after('status');
        });

        // 3. Mengubah nilai ENUM payment_method agar mendukung 'qris'
        // Karena SQLite/MySQL kadang rewel soal ubah ENUM langsung, 
        // cara paling aman di Laravel adalah menggunakan DB statement
        DB::statement("ALTER TABLE transactions MODIFY COLUMN payment_method ENUM('cash', 'midtrans', 'qris') NOT NULL");
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('qris_image');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('proof_of_payment');
        });
        
        DB::statement("ALTER TABLE transactions MODIFY COLUMN payment_method ENUM('cash', 'midtrans') NOT NULL");
    }
};