<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Penawaran extends Model implements HasMedia
{
    use HasFactory, LogsActivity, InteractsWithMedia;

    protected $table = 'penawaran';

    protected $fillable = [
        'user_id',
        'komoditi_id',
        'judul',
        'tipe',
        'kondisi_ikan',
        'keterangan',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function komoditi(): BelongsTo
    {
        return $this->belongsTo(Komoditi::class);
    }

    public function detailEkspor(): HasOne
    {
        return $this->hasOne(PenawaranDetailEkspor::class);
    }

    public function rincianGrade(): HasMany
    {
        return $this->hasMany(PenawaranRincianGrade::class);
    }

    public function biayaHpp(): HasMany
    {
        return $this->hasMany(PenawaranBiayaHpp::class);
    }

    public function matchSuggestions(): HasMany
    {
        return $this->hasMany(MatchSuggestion::class);
    }

    public function mengandungEkspor(): bool
    {
        return in_array($this->tipe, ['Ekspor', 'Ekspor & Lokal']);
    }

    public function getTotalVolumeAttribute(): float
    {
        return $this->rincianGrade->sum('kuantiti');
    }

    // Total biaya tambahan (proses, packing, listrik, tenaga kerja, dll) per kg,
    // SAMA untuk semua grade dalam penawaran ini (bukan per grade).
    public function getTotalBiayaTambahanAttribute(): float
    {
        return $this->biayaHpp->sum('jumlah');
    }

    // Harga Jual = Harga Beli (per grade) + Total Biaya Tambahan (per penawaran).
    // Rentang harga di kartu/daftar sekarang mencerminkan HARGA JUAL, bukan harga beli murni,
    // supaya cabang lain langsung lihat harga yang sudah realistis untuk ditawar-tawarkan.
    public function getRentangHargaAttribute(): string
    {
        if ($this->rincianGrade->isEmpty()) {
            return '-';
        }

        $totalBiaya = $this->total_biaya_tambahan;
        $hargaJualList = $this->rincianGrade->map(fn ($r) => $r->harga + $totalBiaya);

        $min = $hargaJualList->min();
        $max = $hargaJualList->max();

        return $min == $max
            ? 'Rp ' . number_format($min, 0)
            : 'Rp ' . number_format($min, 0) . ' - Rp ' . number_format($max, 0);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['judul', 'tipe', 'komoditi_id', 'status'])
            ->logOnlyDirty()
            ->useLogName('penawaran');
    }
}
