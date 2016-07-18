<?php

namespace App\Http\Controllers;

use App\Reserva;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;


class ReservaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * devuelve las reservas del usuario que tengan el estado guardado
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function guardado($user_id)
    {
        $a = Reserva::usuario($user_id)->estado()->get();
        return response()->json(['reservas' => $a], 200);
    }


    public function todasReservas()
    {
        $a = Reserva::reservado()->get();
        return response()->json(['reservas' => $a], 200);
    }


    /**
     * devuelve las reservas del usuario que tengan el estado reservado
     * @param $id_user
     * @return \Illuminate\Http\JsonResponse
     */
    public function historicoFechas($id_user){
        $a = Reserva::usuario($id_user)->reservado()->get();
        return response()->json(['reservas' => $a], 200);
    }


    /**
     * borra la reserva de las pistas de un usuario en una fecha determinada
     * @param $id_user
     * @param $fecha
     * @return \Illuminate\Http\JsonResponse
     */
    public function borrarReserva($id_user, $fecha){
        $user = User::find($id_user);
        if(!$user){
            return response()->json(['code' => 404,'message' => 'The user could not be found'],404);
        }
        if( $user->enabled== 'disabled'){
            return response()->json(['code' => 403,'message' => 'The user no is enabled'],403);
        }
        Reserva::usuario($id_user)->fecha($fecha)->delete();
        return response()->json(['message' =>'Se ha borrado la reserva hecha en: '.$fecha ],200);
    }


    /**
     * borra una seleccion de jugadores de un usuario
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function borrarSesion($user_id){
        $user = User::find($user_id);
        if(!$user){
            return response()->json(['code' => 404,'message' => 'The user could not be found'],404);
        }
        if( $user->enabled == 'disabled'){
            return response()->json(['code' => 403,'message' => 'The user no is enabled'],403);
        }
        $a = Reserva::usuario($user_id)->estado()->delete();

        return response()->json(['message' =>'Se ha borrado la sesion guardada por el usuario' ],200);
    }


    /**
     * devuelve las pistas de una fecha y una hora determinadas
     * @param $fecha
     * @return \Illuminate\Http\JsonResponse
     */
    public function pistasLibres($fecha)
    {
        $a = Reserva::fecha($fecha)->get();
        return response()->json(['reservas' => $a], 200);
    }


    /**
     * almacena la reserva de pista o pistas dada una fecha y hora determinada
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reservar(Request $request)
    {
        $this->validate($request, [
            'user_id'=> 'required',
            'fecha' => 'required',
            'estado' => 'required',
        ]);

        $user = User::find($request->input('user_id'));
        if(!$user){
            return response()->json(['code' => 404,'message' => 'The user could not be found'],404);
        }
        if( $user->enabled == 'disabled'){
            return response()->json(['code' => 403,'message' => 'The user no is enabled'],403);
        }


        $pistas = $request->input('pistas');
        for($i=1;$i<=6;$i++) {

            if ($pistas[$i]['cont'] != 0) {
                $uno = "";
                $dos = "";
                $tres = "";
                $cuatro = "";
                if (!empty($pistas[$i]['pos1'])) {
                    $uno = $pistas[$i]['pos1'];
                }
                if (!empty($pistas[$i]['pos2'])) {
                    $dos = $pistas[$i]['pos2'];
                }
                if (!empty($pistas[$i]['pos3'])) {
                    $tres = $pistas[$i]['pos3'];
                }
                if (!empty($pistas[$i]['pos4'])) {
                    $cuatro = $pistas[$i]['pos4'];
                }
                $data = array(
                    'user_id' => $request->input('user_id'),
                    'fecha' => $request->input('fecha'),
                    'estado' => $request->input('estado'),
                    'pista' => $i,
                    'uno' => $uno,
                    'dos' => $dos,
                    'tres' => $tres,
                    'cuatro' => $cuatro
                );
                Reserva::create($data);
            }
        }

        return response()->json($request,201);
    }
}
