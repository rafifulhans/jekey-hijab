<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesPrefixedId;

class JurnalTransaksi extends Model
{
    use HasFactory, GeneratesPrefixedId;

    protected $table = 'jurnal_transaksi';
    protected $primaryKey = 'id_jurnal_transaksi';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected string $idPrefix = 'JT';

    public function ref()
    {
        return $this->belongsTo(Ref::class, 'id_ref');
    }
}
