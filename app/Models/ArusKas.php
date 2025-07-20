<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArusKas extends Model
{
    use HasFactory;

    protected $table = 'arus_kas';
    protected $guarded = [];

    public function ref()
    {
        return $this->belongsTo(Ref::class, 'id_ref');
    }
}
