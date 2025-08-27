<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesPrefixedId;

class Piutang extends Model
{
    use HasFactory, GeneratesPrefixedId;

    protected $table = 'piutang';

    protected $primaryKey = 'id_piutang';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected string $idPrefix = 'PTG';
}
