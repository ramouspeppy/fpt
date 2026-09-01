<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class KomoditiSize extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'komoditi_size';

    protected $fillable = [
        'komoditi_id',
        'nama_size',
        'urutan',
        'status',
        'diusulkan_oleh',
        'approved_by',
    ];

    public function komoditi(): BelongsTo
    {
        return $this->belongsTo(Komoditi::class);
    }

    public function pengusul(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diusulkan_oleh');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    // Urutan tampil: yang punya nilai 'urutan' ditampilkan dulu (kecil ke besar),
    // sisanya yang urutan-nya kosong ditaruh di akhir berdasarkan waktu dibuat.
    public function scopeUrutTampil($query)
    {
        return $query->orderByRaw('urutan IS NULL')->orderBy('urutan')->orderBy('created_at');
    }

    // Wajib pakai Spatie Activitylog: mencatat siapa yang membuat & mengubah baris size ini.
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['komoditi_id', 'nama_size', 'urutan', 'status', 'approved_by'])
            ->logOnlyDirty()
            ->useLogName('komoditi_size');
    }
}
