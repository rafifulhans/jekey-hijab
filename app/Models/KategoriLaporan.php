<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesPrefixedId;

class KategoriLaporan extends Model
{
    use HasFactory, GeneratesPrefixedId;

    protected $table = 'kategori_laporan';
    protected $primaryKey = 'id_kategori_laporan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    public $timestamps = false;

    protected string $idPrefix = 'KL';
}
