<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Subscription;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'logo',
        'name',
        'username',
        'email',
        'password',
        'role',
        'phone_number', 
        'address',      
        'store_logo',   
        'description',
        'qris_image',
        'bank_name',
        'bank_account',
        'bank_account_name',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function productCategories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            // Jika lewat register Filament, otomatis jadikan role 'store'
            if (empty($user->role)) {
                $user->role = 'store';
            }
            
            // Otomatis buatkan username unik untuk URL toko mereka
            if (empty($user->username)) {
                $user->username = Str::slug($user->name) . '-' . mt_rand(10, 99);
            }
        });

        static::created(function ($user) {
            // Setelah user tercipta, berikan Free Trial 14 Hari secara otomatis
            if ($user->role === 'store') {
                Subscription::create([
                    'user_id' => $user->id,
                    'is_active' => true, // Langsung aktif
                    'end_date' => now()->addDays(14), // Masa tenggang trial
                ]);
            }
        });
    }
}
