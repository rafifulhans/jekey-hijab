<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalUmum extends Model
{
    use HasFactory;

    protected $table = 'jurnal_umum';
    protected $guarded = [];

    public function ref()
    {
        return $this->belongsTo(Ref::class, 'id_ref');
    }
}
