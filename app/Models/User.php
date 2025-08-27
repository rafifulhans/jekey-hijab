<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Concerns\GeneratesPrefixedId;

class User extends Authenticatable
{
    use HasFactory, Notifiable, GeneratesPrefixedId;

    /**
     * Use string primary keys.
     */
    public $incrementing = false;
    protected $keyType = 'string';

    protected string $idPrefix = 'USR';

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password'
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed'
        ];
    }
}
