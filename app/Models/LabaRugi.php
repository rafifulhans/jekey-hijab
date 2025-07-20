<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabaRugi extends Model
{
    use HasFactory;

    protected $table = 'laba_rugi';
    protected $guarded = [];
    public $timestamps = false;

    public function ref()
    {
        return $this->belongsTo(Ref::class, 'id_ref');
    }
}
