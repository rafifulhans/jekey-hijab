<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesPrefixedId;

class MetodePembayaran extends Model
{
    use HasFactory, GeneratesPrefixedId;

    protected $table = 'metode_pembayaran';
    protected $primaryKey = 'id_metode_pembayaran';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public $timestamps = false;

    protected string $idPrefix = 'PAY';

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_metode_pembayaran');
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class, 'id_metode_pembayaran');
    }
}
