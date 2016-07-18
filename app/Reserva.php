<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = ['user_id','fecha','estado','pista','uno',
        'dos', 'tres','cuatro',];


    /**
     * filtros que comparan atributos de una reserva con valores pasados por parametros
     * @param $query
     * 
     */
    
    public function scopeUsuario($query, $user_id){
        $query->where("user_id",$user_id);
    }

    public function scopePista($query,$pista){
        $query->where("pista",$pista);
    }
    public function scopeFecha($query,$fecha){
        $query->where("fecha",$fecha);
    }

    public function scopeEstado($query){
        $query->where("estado","GUARDADO");
    }

    public function scopeReservado($query){
        $query->where("estado","RESERVADO");
    }
}