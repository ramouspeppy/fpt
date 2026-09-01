<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermintaanRincianSize extends Model
{
    use HasFactory;

    protected $table = 'permintaan_rincian_size';

    protected $fillable = [
        'permintaan_id',
        'komoditi_size_id',
        'harga',
        'kuantiti',
    ];

    public function permintaan(): BelongsTo
    {
        return $this->belongsTo(Permintaan::class);
    }

    public function komoditiSize(): BelongsTo
    {
        return $this->belongsTo(KomoditiSize::class, 'komoditi_size_id');
    }
}
