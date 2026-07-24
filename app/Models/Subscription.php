<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Subscription extends Model
{
    use SoftDeletes;

    // PERBAIKAN: Gunakan end_date dengan huruf kecil
    protected $fillable = [
        'user_id',
        'end_date', 
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptionPayments()
    {
        return $this->hasOne(SubscriptionPayment::class);
    }

    /**
     * Logika otomatis (Observer) diletakkan di sini
     */
    protected static function booted()
    {
        // 1. Saat pertama kali dibuat (Form disubmit oleh Store)
        static::creating(function ($model) {
            // Otomatis isi user_id dengan ID toko yang sedang login
            if (Auth::check()) {
                $model->user_id = Auth::id(); 
            }
            
            // end_date TIDAK DIISI di sini (dibiarkan null/kosong)
        });

        // 2. Saat data di-update (Admin menekan tombol Save / mengubah status)
        static::updating(function ($model) {
            // Cek apakah Admin baru saja mengubah 'is_active' menjadi 1 (Aktif)
            if ($model->isDirty('is_active') && $model->is_active == 1) {
                // Tambahkan 30 hari dari detik persetujuan ini
                $model->end_date = now()->addDays(30);
            }
        });
    }
}