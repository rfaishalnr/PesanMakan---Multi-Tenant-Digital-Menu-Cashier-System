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
        // Tambah kolom saldo dan rekening di tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('balance')->default(0)->after('role');
            $table->string('bank_name')->nullable()->after('balance');
            $table->string('bank_account')->nullable()->after('bank_name');
            $table->string('bank_account_name')->nullable()->after('bank_account');
        });
    
        // Tambah kolom token di tabel transactions
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('snap_token')->nullable()->after('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
};
