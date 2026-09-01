<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'project';

    protected $fillable = [
        'match_suggestion_id',
        'penawaran_id',
        'permintaan_id',
        'status',
        'dipilih_oleh',
    ];

    public function matchSuggestion(): BelongsTo
    {
        return $this->belongsTo(MatchSuggestion::class);
    }

    public function penawaran(): BelongsTo
    {
        return $this->belongsTo(Penawaran::class);
    }

    public function permintaan(): BelongsTo
    {
        return $this->belongsTo(Permintaan::class);
    }

    public function pemilih(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dipilih_oleh');
    }

    public function catatan(): HasMany
    {
        return $this->hasMany(ProjectCatatan::class)->latest();
    }

    // Cabang yang boleh terlibat di project ini: pemilik Penawaran & pemilik Permintaan.
    public function userTerlibat(): array
    {
        return array_unique(array_filter([
            $this->penawaran->user_id ?? null,
            $this->permintaan->user_id ?? null,
        ]));
    }

    public function bolehDiaksesOleh(User $user): bool
    {
        if ($user->hasAnyRole(['Pusat', 'Admin'])) {
            return true;
        }

        return in_array($user->id, $this->userTerlibat());
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'dipilih_oleh'])
            ->logOnlyDirty()
            ->useLogName('project');
    }
}
