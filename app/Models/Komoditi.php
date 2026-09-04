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
        'kategori_id',
        'status',
        'diusulkan_oleh',
        'approved_by',
    ];

    public function kategoriKomoditi(): BelongsTo
    {
        return $this->belongsTo(KategoriKomoditi::class, 'kategori_id');
    }

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

    public function sizes(): HasMany
    {
        return $this->hasMany(KomoditiSize::class);
    }

    // BARU: nama daerah/alias komoditi ini (mis. Giant Trevally (GT) juga dikenal
    // sebagai "Ikan Gabui", "Ikan Kuwe" di daerah tertentu). Bisa ditambah siapa saja
    // yang login, tanpa approval - membantu pencarian.
    public function tags(): HasMany
    {
        return $this->hasMany(KomoditiTag::class);
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }
}
