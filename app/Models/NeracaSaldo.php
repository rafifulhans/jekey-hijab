<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NeracaSaldo extends Model
{
    use HasFactory;

    protected $table = 'neraca_saldo';
    protected $guarded = [];

    public function ref()
    {
        return $this->belongsTo(Ref::class, 'id_ref');
    }
}
