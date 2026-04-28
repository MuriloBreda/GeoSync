<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Campos que podem ser preenchidos
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Campos ocultos (segurança)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts (tipos automáticos)
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * RELACIONAMENTO COM REMESSAS
     * 1 usuário pode ter várias remessas
     */
    public function remessas()
    {
        return $this->hasMany(Remessa::class);
    }
}