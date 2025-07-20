<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marketplace extends Model
{
    use HasFactory;

    protected $table = 'marketplace';
    protected $guarded = [];
    public $timestamps = false;

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_marketplace');
    }
}
