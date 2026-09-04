<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriKomoditi extends Model
{
    use HasFactory;

    protected $table = 'kategori_komoditi';

    protected $fillable = ['nama'];

    public function komoditi(): HasMany
    {
        return $this->hasMany(Komoditi::class, 'kategori_id');
    }
}
