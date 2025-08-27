<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesPrefixedId;

class PersetujuanPengeluaranGrosir extends Model
{
    use HasFactory, GeneratesPrefixedId;

    protected $table = 'persetujuan_pengeluaran_grosir';
    protected $primaryKey = 'id_persetujuan_pengeluaran_grosir';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected string $idPrefix = 'PPG';
}
