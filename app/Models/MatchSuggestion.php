<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function penawaranRincian(): BelongsTo
    {
        return $this->belongsTo(PenawaranRincianGrade::class, 'penawaran_rincian_id');
    }

    public function permintaanRincian(): BelongsTo
    {
        return $this->belongsTo(PermintaanRincianGrade::class, 'permintaan_rincian_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'catatan', 'approved_by'])
            ->logOnlyDirty()
            ->useLogName('match_suggestion');
    }
}
