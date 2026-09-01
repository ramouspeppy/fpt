<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Komoditi extends Model
{
    use HasFactory;

    protected $table = 'komoditi';

    protected $fillable = [
        'nama',
        'kategori',
        'status',
        'diusulkan_oleh',
        'approved_by',
    ];

    public function pengusul(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diusulkan_oleh');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function penawaran(): HasMany
    {
        return $this->hasMany(Penawaran::class);
    }

    public function permintaan(): HasMany
    {
        return $this->hasMany(Permintaan::class);
    }

    // BARU di v9: setiap komoditi punya daftar size-nya sendiri (mis. gurita:
    // 1000UP, 500-1000, 300-500, 200-300 - beda komoditi beda daftar size).
    public function sizes(): HasMany
    {
        return $this->hasMany(KomoditiSize::class);
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }
}
