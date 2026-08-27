<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermintaanDetailEkspor extends Model
{
    use HasFactory;

    protected $table = 'permintaan_detail_ekspor';

    protected $fillable = [
        'permintaan_id',
        'grading',
        'sertifikasi',
        'kontinuitas_suplai',
        'negara_tujuan',
    ];

    public function permintaan(): BelongsTo
    {
        return $this->belongsTo(Permintaan::class);
    }
}
