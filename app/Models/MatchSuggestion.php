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
