<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesPrefixedId;

class LabaRugi extends Model
{
    use HasFactory, GeneratesPrefixedId;

    protected $table = 'laba_rugi';
    protected $primaryKey = 'id_laba_rugi';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    public $timestamps = false;

    protected string $idPrefix = 'LR';

    public function ref()
    {
        return $this->belongsTo(Ref::class, 'id_ref');
    }
}
