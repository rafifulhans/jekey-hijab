<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesPrefixedId;

class Utang extends Model
{
    use HasFactory, GeneratesPrefixedId;

    protected $table = 'utang';
    protected $primaryKey = 'id_utang';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected string $idPrefix = 'UTG';
}
