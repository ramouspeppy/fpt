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
        'volume',
        'harga',
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

    public function matchSuggestions(): HasMany
    {
        return $this->hasMany(MatchSuggestion::class);
    }

    // Penawaran mengandung tipe ekspor jika "Ekspor" atau "Ekspor & Lokal"
    public function mengandungEkspor(): bool
    {
        return in_array($this->tipe, ['Ekspor', 'Ekspor & Lokal']);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['judul', 'tipe', 'jenis_ikan', 'volume', 'harga', 'status'])
            ->logOnlyDirty()
            ->useLogName('penawaran');
    }
}
