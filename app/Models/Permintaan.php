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
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Permintaan extends Model implements HasMedia
{
    use HasFactory, LogsActivity, InteractsWithMedia;

    protected $table = 'permintaan';

    protected $fillable = [
        'user_id',
        'komoditi_id',
        'judul',
        'tipe',
        'keterangan',
        'prioritas_warna',
        'prioritas_tag',
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
        return $this->hasOne(PermintaanDetailEkspor::class);
    }

    // CATATAN MIGRASI v9: dulu bernama rincianGrade() / model PermintaanRincianGrade.
    public function rincianSize(): HasMany
    {
        return $this->hasMany(PermintaanRincianSize::class);
    }

    public function matchSuggestions(): HasMany
    {
        return $this->hasMany(MatchSuggestion::class);
    }

    public function project(): HasOne
    {
        return $this->hasOne(Project::class);
    }

    public function isEkspor(): bool
    {
        return $this->tipe === 'Ekspor';
    }

    public function getTotalVolumeAttribute(): float
    {
        return $this->rincianSize->sum('kuantiti');
    }

    public function getRentangHargaAttribute(): string
    {
        if ($this->rincianSize->isEmpty()) {
            return '-';
        }

        $min = $this->rincianSize->min('harga');
        $max = $this->rincianSize->max('harga');

        return $min == $max
            ? 'Rp ' . number_format($min, 0)
            : 'Rp ' . number_format($min, 0) . ' - Rp ' . number_format($max, 0);
    }

    public function getSudahTerkunciAttribute(): bool
    {
        return $this->status !== 'tersedia';
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['judul', 'tipe', 'komoditi_id', 'status', 'prioritas_warna', 'prioritas_tag'])
            ->logOnlyDirty()
            ->useLogName('permintaan');
    }

    // BARU: galeri foto (bebas jumlahnya) & video (maks 2, dibatasi di controller
    // saat commit, bukan lewat MediaLibrary) untuk dokumentasi visual permintaan.
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('foto')
            ->useDisk('media')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('video')
            ->useDisk('media')
            ->acceptsMimeTypes(['video/mp4', 'video/quicktime', 'video/webm']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(400)
            ->height(400)
            ->sharpen(10)
            ->nonQueued()
            ->performOnCollections('foto');
    }
}
