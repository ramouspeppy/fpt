<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenawaranRincianGrade extends Model
{
    use HasFactory;

    protected $table = 'penawaran_rincian_grade';

    protected $fillable = [
        'penawaran_id',
        'ukuran_grade',
        'harga',
        'kuantiti',
    ];

    public function penawaran(): BelongsTo
    {
        return $this->belongsTo(Penawaran::class);
    }

    // Harga Jual = harga beli (field 'harga', bahan baku murni per grade ini)
    // + total biaya tambahan dari penawaran induknya (proses, packing, dll, sama utk semua grade).
    public function getHargaJualAttribute(): float
    {
        return $this->harga + ($this->penawaran->total_biaya_tambahan ?? 0);
    }
}
