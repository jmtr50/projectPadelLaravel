<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','phone','email', 'enabled', 'rol','password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * filtros que comparan atributos de un usuario con valores pasados por parametros
     * @param $query
     *
     */
    public function scopeEstado($query,$estado){
        $query->where("enabled",$estado);
    }

    public function scopeRol($query){
        $query->where("rol",'ROLE_USER');
    }

    /**
     * devuelve los atributos firstname y lastname juntos
     * @return string
     */
    public function getNameAttribute(){
        return $this-> first_name.' '. $this->last_name;
    }
}