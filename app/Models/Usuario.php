<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable implements JWTSubject
{
    protected $table = 'usuarios';

    protected $fillable = ['nombre', 'correo', 'clave'];

    protected $hidden = ['clave'];

     public function getAuthPassword(){
        // Return the password for the user
        return $this->clave;
    }


    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }
    
    public function proyectos() {
        return $this->hasMany(Proyecto::class, 'created_by');
    }
}
