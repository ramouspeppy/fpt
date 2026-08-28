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
        'judul',
        'tipe',
        'jenis_ikan',
        'kondisi_ikan',
        'keterangan',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function detailEkspor(): HasOne
    {
        return $this->hasOne(PenawaranDetailEkspor::class);
    }

    public function rincianGrade(): HasMany
    {
        return $this->hasMany(PenawaranRincianGrade::class);
    }

    public function matchSuggestions(): HasMany
    {
        return $this->hasMany(MatchSuggestion::class);
    }

    public function mengandungEkspor(): bool
    {
        return in_array($this->tipe, ['Ekspor', 'Ekspor & Lokal']);
    }

    // total kuantiti dari semua baris rincian grade
    public function getTotalVolumeAttribute(): float
    {
        return $this->rincianGrade->sum('kuantiti');
    }

    // rentang harga (terendah - tertinggi) dari semua baris rincian grade
    public function getRentangHargaAttribute(): string
    {
        if ($this->rincianGrade->isEmpty()) {
            return '-';
        }

        $min = $this->rincianGrade->min('harga');
        $max = $this->rincianGrade->max('harga');

        return $min == $max
            ? 'Rp ' . number_format($min, 0)
            : 'Rp ' . number_format($min, 0) . ' - Rp ' . number_format($max, 0);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['judul', 'tipe', 'jenis_ikan', 'status'])
            ->logOnlyDirty()
            ->useLogName('penawaran');
    }
}
