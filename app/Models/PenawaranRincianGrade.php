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
}
