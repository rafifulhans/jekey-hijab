<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesPrefixedId;

class Ekspedisi extends Model
{
    use HasFactory, GeneratesPrefixedId;

    protected $table = 'ekspedisi';
    protected $primaryKey = 'id_ekspedisi';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    public $timestamps = false;

    protected string $idPrefix = 'EXP';

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_ekspedisi');
    }
}
