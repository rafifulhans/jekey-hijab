<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utang extends Model
{
    use HasFactory;

    protected $table = 'utang';
    protected $primaryKey = 'id_utang';
    protected $guarded = [];
}
