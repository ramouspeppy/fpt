<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Permintaan extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'permintaan';

    protected $fillable = [
        'user_id',
        'judul',
        'tipe',
        'jenis_ikan',
        'keterangan',
        'prioritas_warna',
        'prioritas_tag',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function detailEkspor(): HasOne
    {
        return $this->hasOne(PermintaanDetailEkspor::class);
    }

    public function rincianGrade(): HasMany
    {
        return $this->hasMany(PermintaanRincianGrade::class);
    }

    public function matchSuggestions(): HasMany
    {
        return $this->hasMany(MatchSuggestion::class);
    }

    public function isEkspor(): bool
    {
        return $this->tipe === 'Ekspor';
    }

    public function getTotalVolumeAttribute(): float
    {
        return $this->rincianGrade->sum('kuantiti');
    }

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
            ->logOnly(['judul', 'tipe', 'jenis_ikan', 'status', 'prioritas_warna', 'prioritas_tag'])
            ->logOnlyDirty()
            ->useLogName('permintaan');
    }
}
