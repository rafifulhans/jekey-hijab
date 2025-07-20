<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekspedisi extends Model
{
    use HasFactory;

    protected $table = 'ekspedisi';
    protected $guarded = [];
    public $timestamps = false;

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_ekspedisi');
    }
}
