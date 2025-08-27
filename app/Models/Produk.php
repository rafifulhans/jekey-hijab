<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesPrefixedId;

class Produk extends Model
{
    use HasFactory, GeneratesPrefixedId;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected string $idPrefix = 'PRD';

    protected $casts = [
        'harga' => 'float',
    ];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_produk');
    }
}
