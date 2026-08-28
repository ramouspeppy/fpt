<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenawaranBiayaHpp extends Model
{
    use HasFactory;

    protected $table = 'penawaran_biaya_hpp';

    protected $fillable = [
        'penawaran_id',
        'label',
        'jumlah',
    ];

    public function penawaran(): BelongsTo
    {
        return $this->belongsTo(Penawaran::class);
    }
}
