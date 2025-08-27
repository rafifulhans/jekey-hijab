<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesPrefixedId;

class ArusKas extends Model
{
    use HasFactory, GeneratesPrefixedId;

    protected $table = 'arus_kas';
    protected $primaryKey = 'id_arus_kas';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected string $idPrefix = 'AK';

    public function ref()
    {
        return $this->belongsTo(Ref::class, 'id_ref');
    }
}
