<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Peli;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'poblacion',
        'cp',
        'fechanacimiento',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // recupera todas las películas relacionadas con el usuario
    // relación 1 a N con hasMany()
    public function pelis() {
        return $this->hasMany('\App\Models\Peli');
    }

    // indica si un usuario tiene un rol concreto
    // a partir del nombre del rol o array de roles (se aplica una OR)
    public function hasRole($roleNames):bool {

        // si sólo viene un rol, lo guarda en un array
        if(!is_array($roleNames)) {
            $roleNames = [$roleNames];
        }

        // recorre la lista de roles buscando...
        foreach($this->roles as $role) {
            if(in_array($role->role, $roleNames)) {
                return true; // si lo encuentra
            }
        }

        return false; // si no lo encuentra
    }

    // para saber si un usuario es creador del registro de una película
    public function isOwner(Peli $peli):bool {
        return $this->id == $peli->user_id;
    }

    // recupera los roles del usuario
    public function roles() {
        return $this->belongsToMany('App\Models\Role');
    }

    // recupera los roles que no tienen usuario
    public function remainingRoles() {
        // roles de usuario
        $actualRoles = $this->roles;

        // roles todos
        $allRoles = Role::all();

        // retorna todos los roles excepto los que ya tiene el usuario
        return $allRoles->diff($actualRoles);
    }
}
