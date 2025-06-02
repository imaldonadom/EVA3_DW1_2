<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'correo',
        'clave',
    ];

    protected $hidden = [
        'clave',
        'remember_token',
    ];

    /**
     * Laravel usa "password" por defecto, este método fuerza a usar "clave"
     */
    public function getAuthPassword()
    {
        return $this->clave;
    }

    /**
     * Identificador único para el JWT
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Claims personalizados para el JWT (puede ir vacío)
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Relación con proyectos (si aplica)
     */
    public function proyectos()
    {
        return $this->hasMany(Proyecto::class, 'created_by');
    }
}
