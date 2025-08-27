<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesPrefixedId;

class InvoiceBarang extends Model
{
    use GeneratesPrefixedId;

    protected $table = 'invoice_barang';
    protected $primaryKey = 'id_invoice_barang';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected string $idPrefix = 'INVB';
}
