<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersetujuanPengeluaranGrosir extends Model
{
    use HasFactory;

    protected $table = 'persetujuan_pengeluaran_grosir';
    protected $primaryKey = 'id_persetujuan_pengeluaran_grosir';
    protected $guarded = [];
}
