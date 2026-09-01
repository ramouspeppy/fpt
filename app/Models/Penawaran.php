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
        'jenis_penawaran',
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

    // CATATAN MIGRASI v9: dulu bernama rincianGrade() / model PenawaranRincianGrade.
    // Kalau ada view/controller lain yang masih memanggil rincianGrade(), ganti ke rincianSize().
    public function rincianSize(): HasMany
    {
        return $this->hasMany(PenawaranRincianSize::class);
    }

    public function biayaHpp(): HasMany
    {
        return $this->hasMany(PenawaranBiayaHpp::class);
    }

    public function matchSuggestions(): HasMany
    {
        return $this->hasMany(MatchSuggestion::class);
    }

    // Sebuah Penawaran dianggap "punya project" begitu salah satu match-nya dipilih.
    public function project(): HasOne
    {
        return $this->hasOne(Project::class);
    }

    public function mengandungEkspor(): bool
    {
        return in_array($this->tipe, ['Ekspor', 'Ekspor & Lokal']);
    }

    public function isTrading(): bool
    {
        return $this->jenis_penawaran === 'Trading';
    }

    public function getTotalVolumeAttribute(): float
    {
        return $this->rincianSize->sum('kuantiti');
    }

    // Total biaya tambahan (proses, packing, listrik, tenaga kerja, dll) per kg,
    // SAMA untuk semua size dalam penawaran ini (bukan per size).
    public function getTotalBiayaTambahanAttribute(): float
    {
        return $this->biayaHpp->sum('jumlah');
    }

    // Harga Jual = Harga Beli (per size) + Total Biaya Tambahan (per penawaran).
    public function getRentangHargaAttribute(): string
    {
        if ($this->rincianSize->isEmpty()) {
            return '-';
        }

        $totalBiaya = $this->total_biaya_tambahan;
        $hargaJualList = $this->rincianSize->map(fn ($r) => $r->harga + $totalBiaya);

        $min = $hargaJualList->min();
        $max = $hargaJualList->max();

        return $min == $max
            ? 'Rp ' . number_format($min, 0)
            : 'Rp ' . number_format($min, 0) . ' - Rp ' . number_format($max, 0);
    }

    // status 'tersedia' = masih bisa dipakai bikin match baru / dipilih jadi project.
    // Begitu jadi project, statusnya berubah manual jadi 'sedang_diproses' dan
    // SELURUH penawaran (termasuk size lain yang belum laku) ikut terkunci.
    public function getSudahTerkunciAttribute(): bool
    {
        return $this->status !== 'tersedia';
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['judul', 'tipe', 'komoditi_id', 'status'])
            ->logOnlyDirty()
            ->useLogName('penawaran');
    }
}
