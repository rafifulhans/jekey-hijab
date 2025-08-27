<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesPrefixedId;

class BukuBesar extends Model
{
    use HasFactory, GeneratesPrefixedId;

    protected $table = 'buku_besar';
    protected $primaryKey = 'id_buku_besar';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected string $idPrefix = 'BB';

    public function ref()
    {
        return $this->belongsTo(Ref::class, 'id_ref');
    }
}
