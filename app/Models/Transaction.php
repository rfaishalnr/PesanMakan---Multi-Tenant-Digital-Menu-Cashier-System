<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'code',
        'name',
        'phone_number',
        'table_number',
        'payment_method',
        'total_price',
        'status',
        'proof_of_payment',
        'snap_token',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // 2. PERBAIKAN: Cek dulu apakah ada user yang login (Auth::check())
            // Jika ada yang login, baru cek apakah role-nya 'store'
            if (Auth::check() && Auth::user()->role === 'store') {
                
                // 3. Pastikan user_id hanya diisi jika nilainya masih kosong
                // (Karena jika dari frontend, Controller sebenarnya sudah mengisi ini lewat $store->transactions()->create...)
                if (empty($model->user_id)) {
                    $model->user_id = Auth::id();
                }
            }
        });

        static::updating(function ($model) {
            if(Auth::user()->role == 'store') {
                $model->user_id = Auth::id();
            }

        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    protected static function booted()
    {
        static::creating(function ($transaction) {
            // Cari nomor antrian paling besar di HARI INI untuk TOKO INI
            $lastQueue = self::whereDate('created_at', today())
                ->where('user_id', $transaction->user_id)
                ->max('queue_number');

            // Jika belum ada pesanan hari ini, mulai dari 1. Jika ada, tambah 1.
            $transaction->queue_number = $lastQueue ? $lastQueue + 1 : 1;
        });
    }
}
