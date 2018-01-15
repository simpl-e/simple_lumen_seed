<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Model implements JWTSubject, AuthenticatableContract, AuthorizableContract {

    use Authenticatable,
        Authorizable;

    /* tabla e id para uso de Eloquent */
    protected $table = "Usuarios";
    protected $primaryKey = "Id";
    
    /* cols editables */
    protected $fillable = [
        "Nombre", "User", "Pass", "Id_pais", "Rol", "Pass", "Intentos"
    ];
    
    /* cols ocultas por defecto */
    protected $hidden = [
        'Pass', 'Intentos'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

}
