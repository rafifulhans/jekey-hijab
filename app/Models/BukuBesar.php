<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuBesar extends Model
{
    use HasFactory;

    protected $table = 'buku_besar';
    protected $guarded = [];

    public function ref()
    {
        return $this->belongsTo(Ref::class, 'id_ref');
    }
}
