<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenawaranRincianSize extends Model
{
    use HasFactory;

    protected $table = 'penawaran_rincian_size';

    protected $fillable = [
        'penawaran_id',
        'komoditi_size_id',
        'harga',
        'kuantiti',
    ];

    public function penawaran(): BelongsTo
    {
        return $this->belongsTo(Penawaran::class);
    }

    public function komoditiSize(): BelongsTo
    {
        return $this->belongsTo(KomoditiSize::class, 'komoditi_size_id');
    }

    // Harga Jual = harga beli (field 'harga', bahan baku murni per size ini)
    // + total biaya tambahan dari penawaran induknya (proses, packing, dll, sama utk semua size).
    public function getHargaJualAttribute(): float
    {
        return $this->harga + ($this->penawaran->total_biaya_tambahan ?? 0);
    }
}
