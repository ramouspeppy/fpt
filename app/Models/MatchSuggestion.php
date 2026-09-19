<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MatchSuggestion extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'match_suggestion';

    protected $fillable = [
        'penawaran_id',
        'permintaan_id',
        'penawaran_rincian_id',
        'permintaan_rincian_id',
        'skor_matching',
        'status',
        'approved_by',
        'catatan',
    ];

    public function penawaran(): BelongsTo
    {
        return $this->belongsTo(Penawaran::class);
    }

    public function permintaan(): BelongsTo
    {
        return $this->belongsTo(Permintaan::class);
    }

    // CATATAN MIGRASI v9: dulu return type PenawaranRincianGrade, sekarang PenawaranRincianSize.
    // Nama method relasi (penawaranRincian) SENGAJA tidak diubah supaya query lama tetap jalan.
    public function penawaranRincian(): BelongsTo
    {
        return $this->belongsTo(PenawaranRincianSize::class, 'penawaran_rincian_id');
    }

    public function permintaanRincian(): BelongsTo
    {
        return $this->belongsTo(PermintaanRincianSize::class, 'permintaan_rincian_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Match yang statusnya 'dipilih' akan punya tepat 1 Project terkait.
    public function project(): HasOne
    {
        return $this->hasOne(Project::class);
    }

    // === Estimasi Profit (logika mengikuti contoh excel gap_margin.xlsx - "Tabel Hitung Margin") ===
    // Per baris match (1 size), kuantiti yang dipakai adalah KG Permintaan (bukan KG Penawaran),
    // dikalikan Harga HPP Penawaran (harga beli + biaya tambahan proses/packing dari penawaran induk).

    public function getKgPermintaanAttribute(): float
    {
        return (float) ($this->permintaanRincian->kuantiti ?? 0);
    }

    public function getHargaJualPermintaanAttribute(): float
    {
        return (float) ($this->permintaanRincian->harga ?? 0);
    }

    // "Total Permintaan" di excel = nilai jual kalau Permintaan ini terpenuhi (KG x Harga Permintaan).
    public function getTotalNilaiPermintaanAttribute(): float
    {
        return $this->kg_permintaan * $this->harga_jual_permintaan;
    }

    public function getHargaHppPenawaranAttribute(): float
    {
        return (float) ($this->penawaranRincian->harga_jual ?? 0);
    }

    // "TOTAL MARGIN" di excel = sebenarnya nilai modal/HPP untuk kuantiti Permintaan (KG Permintaan x HPP Penawaran).
    public function getTotalHppAttribute(): float
    {
        return $this->kg_permintaan * $this->harga_hpp_penawaran;
    }

    // "Gap" di excel = Total Permintaan - Total HPP -> ini estimasi profit sesungguhnya.
    public function getEstimasiProfitAttribute(): float
    {
        return $this->total_nilai_permintaan - $this->total_hpp;
    }

    // "Gap %" di excel = Gap / Total Permintaan.
    public function getPersenProfitAttribute(): float
    {
        return $this->total_nilai_permintaan > 0
            ? $this->estimasi_profit / $this->total_nilai_permintaan
            : 0.0;
    }

    // Warna badge/pill: <10% merah (danger), <20% oren (warning), >=20% hijau (emerald - custom, bukan success bawaan).
    public function getWarnaProfitAttribute(): string
    {
        $persen = $this->persen_profit * 100;

        if ($persen < 10) {
            return 'danger';
        }

        if ($persen < 20) {
            return 'warning';
        }

        return 'emerald';
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'catatan', 'approved_by'])
            ->logOnlyDirty()
            ->useLogName('match_suggestion');
    }
}
