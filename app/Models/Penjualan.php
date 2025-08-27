<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesPrefixedId;

class Penjualan extends Model
{
    use HasFactory, GeneratesPrefixedId;

    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected string $idPrefix = 'PJ';

    public function marketplace()
    {
        return $this->belongsTo(Marketplace::class, 'id_marketplace');
    }

    public function ekspedisi()
    {
        return $this->belongsTo(Ekspedisi::class, 'id_ekspedisi');
    }

    public function metodePembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class, 'id_metode_pembayaran');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
