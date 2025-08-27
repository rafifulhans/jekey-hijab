<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesPrefixedId;

class Ref extends Model
{
    use HasFactory, GeneratesPrefixedId;

    protected $table = 'ref';
    protected $primaryKey = 'id_ref';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public $timestamps = false;

    protected string $idPrefix = 'REF';

    public function labaRugi()
    {
        return $this->hasMany(LabaRugi::class, 'id_ref');
    }

    public function neracaSaldo()
    {
        return $this->hasMany(NeracaSaldo::class, 'id_ref');
    }

    public function arusKas()
    {
        return $this->hasMany(ArusKas::class, 'id_ref');
    }

    public function jurnalTransaksi()
    {
        return $this->hasMany(JurnalTransaksi::class, 'id_ref');
    }

    public function jurnalUmum()
    {
        return $this->hasMany(JurnalUmum::class, 'id_ref');
    }

    public function jurnalPenyesuaian()
    {
        return $this->hasMany(JurnalPenyesuaian::class, 'id_ref');
    }

    public function bukuBesar()
    {
        return $this->hasMany(BukuBesar::class, 'id_ref');
    }
}
