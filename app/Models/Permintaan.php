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
        'volume',
        'harga_maksimal',
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

    public function matchSuggestions(): HasMany
    {
        return $this->hasMany(MatchSuggestion::class);
    }

    public function isEkspor(): bool
    {
        return $this->tipe === 'Ekspor';
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['judul', 'tipe', 'jenis_ikan', 'volume', 'harga_maksimal', 'status', 'prioritas_warna', 'prioritas_tag'])
            ->logOnlyDirty()
            ->useLogName('permintaan');
    }
}
