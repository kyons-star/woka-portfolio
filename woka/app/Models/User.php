<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * woka signs people in with their full name + password (no email),
     * so "name_key" holds the lower-cased name used for lookup.
     */
    protected $fillable = [
        'name',
        'name_key',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class);
    }
}