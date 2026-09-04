<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KomoditiTag extends Model
{
    use HasFactory;

    protected $table = 'komoditi_tag';

    protected $fillable = ['komoditi_id', 'nama_tag', 'ditambahkan_oleh'];

    public function komoditi(): BelongsTo
    {
        return $this->belongsTo(Komoditi::class);
    }

    public function penambah(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ditambahkan_oleh');
    }
}
