<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesPrefixedId;

class JurnalPenyesuaian extends Model
{
    use HasFactory, GeneratesPrefixedId;

    protected $table = 'jurnal_penyesuaian';
    protected $primaryKey = 'id_jurnal_penyesuaian';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected string $idPrefix = 'JP';

    public function ref()
    {
        return $this->belongsTo(Ref::class, 'id_ref');
    }
}
