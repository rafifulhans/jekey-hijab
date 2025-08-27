<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesPrefixedId;

class JurnalUmum extends Model
{
    use HasFactory, GeneratesPrefixedId;

    protected $table = 'jurnal_umum';
    protected $primaryKey = 'id_jurnal_umum';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected string $idPrefix = 'JU';

    public function ref()
    {
        return $this->belongsTo(Ref::class, 'id_ref');
    }
}
