<?php

namespace App\Models;

// Ini adalah pengganti app/Models/User.php bawaan Breeze.
// Tabel `users` di sini berfungsi sebagai USER_AKUN pada skema yang sudah didiskusikan.

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cabang_id',
        'no_whatsapp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cabang(): BelongsTo
    {
        return $this->belongsTo(Cabang::class);
    }

    public function penawaran(): HasMany
    {
        return $this->hasMany(Penawaran::class);
    }

    public function permintaan(): HasMany
    {
        return $this->hasMany(Permintaan::class);
    }

    // Link wa.me yang bisa langsung diklik, dipakai di tampilan penawaran/permintaan
    public function getWhatsappLinkAttribute(): ?string
    {
        if (! $this->no_whatsapp) {
            return null;
        }

        $nomor = preg_replace('/[^0-9]/', '', $this->no_whatsapp);
        // ubah awalan 0 jadi kode negara 62 (Indonesia)
        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        }

        return "https://wa.me/{$nomor}";
    }
}
