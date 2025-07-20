<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    use HasFactory;

    protected $table = 'metode_pembayaran';
    protected $guarded = [];

    public $timestamps = false;

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_metode_pembayaran');
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class, 'id_metode_pembayaran');
    }
}
