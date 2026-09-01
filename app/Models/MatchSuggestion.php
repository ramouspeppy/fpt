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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'catatan', 'approved_by'])
            ->logOnlyDirty()
            ->useLogName('match_suggestion');
    }
}
