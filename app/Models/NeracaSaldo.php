<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesPrefixedId;

class NeracaSaldo extends Model
{
    use HasFactory, GeneratesPrefixedId;

    protected $table = 'neraca_saldo';
    protected $primaryKey = 'id_neraca_saldo';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected string $idPrefix = 'NS';

    public function ref()
    {
        return $this->belongsTo(Ref::class, 'id_ref');
    }
}
