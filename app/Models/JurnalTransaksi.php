<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalTransaksi extends Model
{
    use HasFactory;

    protected $table = 'jurnal_transaksi';
    protected $guarded = [];

    public function ref()
    {
        return $this->belongsTo(Ref::class, 'id_ref');
    }
}
