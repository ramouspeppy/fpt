<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermintaanRincianGrade extends Model
{
    use HasFactory;

    protected $table = 'permintaan_rincian_grade';

    protected $fillable = [
        'permintaan_id',
        'ukuran_grade',
        'harga',
        'kuantiti',
    ];

    public function permintaan(): BelongsTo
    {
        return $this->belongsTo(Permintaan::class);
    }
}
