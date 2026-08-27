<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenawaranDetailEkspor extends Model
{
    use HasFactory;

    protected $table = 'penawaran_detail_ekspor';

    protected $fillable = [
        'penawaran_id',
        'grading',
        'sertifikasi',
        'kontinuitas_suplai',
        'negara_tujuan',
    ];

    public function penawaran(): BelongsTo
    {
        return $this->belongsTo(Penawaran::class);
    }
}
