<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesPrefixedId;

class Invoice extends Model
{
    use HasFactory, GeneratesPrefixedId;

    protected $table = 'invoice';
    protected $primaryKey = 'id_invoice';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected string $idPrefix = 'INV';

    public function metodePembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class, 'id_metode_pembayaran');
    }
}
