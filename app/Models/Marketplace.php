<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesPrefixedId;

class Marketplace extends Model
{
    use HasFactory, GeneratesPrefixedId;

    protected $table = 'marketplace';
    protected $primaryKey = 'id_marketplace';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    public $timestamps = false;

    protected string $idPrefix = 'MP';

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_marketplace');
    }
}
