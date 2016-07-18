<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\User;
class UsuarioController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * devuelve un listado de usuarios dado un estado del usuario(enabled o disabled)
     * @param $estado
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($estado){
        $a = User::estado($estado)->rol()->get();
        return response()->json(['users' => $a],200);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexAdmin() {
        return view('admin');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexPistas() {
        return view('pistas');
    }

    /**
     * devuelve un usuario dado un id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {

        try {
            $user = User::findOrFail($id);
            return response()->json(['message' => $user->toArray()], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'no se ha encontrado el user'], 404);

        }
    }


    /**
     * elimina un usuario
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){
        try{
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['message' =>'Deletes the user identified by $id' ],204);
        }catch (ModelNotFoundException $e){
            return response()->json(['code' => 404,'message' => 'The user could not be found'],404);

        }
    }

    /**
     * cambia el estado de un usuario (enabled o disabled)
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function enable(Request $request, $id){
        $user = User::find($id);
        if(!$user){
            return response()->json(['code' => 404,'message' => 'The user could not be found'],404);
        }
        if($request->input('enabled')){
            $user->enabled = $request->input('enabled');
            $user->save();
            return response()->json($user,200);
        }else{
            return response()->json(['code' => 400,'message' => 'Bad Request enabled field not found.'],400);
        }

    }


    /**
     * actualiza la información de un usuario
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id){
        $this->validate($request, [
            'first_name' => 'max:100',
            'last_name' => 'max:100',
            'phone' =>'digits:9',
            'email' => 'email|max:255|unique:users',
            'old_password' => 'min:6',
            'password' => 'confirmed|min:6',
            'password_confirmation' => 'min:6'
        ]);

        $user = User::find($id);
        if(!$user){
            return response()->json(['code' => 404,'message' => 'The user could not be found'],404);
        }

        if($request->input('email')){
            $erroremail = User::where('email','=',$request->input('email') )
                ->first();
            if($erroremail && $erroremail->id != $id){
                return response()->json(['code' => 400,'message' => 'Bad Request Username or email already exists.'],400);
            }
        }


        if($request->input('first_name')){
            $user->first_name = $request->input('first_name');
        }
        if($request->input('last_name')){
            $user->last_name = $request->input('last_name');
        }
        if($request->input('email')){
            $user->email = $request->input('email');
        }
        if($request->input('phone')){
            $user->phone = $request->input('phone');
        }


        if ($request->input('old_password') || $request->input('old_password') || $request->input('password_confirmation')){
            if ($request->input('old_password') && $request->input('old_password') && $request->input('password_confirmation')) {
                $hashedPassword = $user->password;

                if (Hash::check($request->input('old_password'), $hashedPassword)) {
                        $user->password = bcrypt($request->input('password'));

                } else {
                    return response()->json(['code' => 400, 'old_password' => 'incorrect password'], 400);

                }

            } else {
                return response()->json(['code' => 400, 'old_password' => 'you need complete all password fields'], 400);

            }
        }


        if($request->input('enabled')){
            $user->enabled = $request->input('enabled');
        }
        if($request->input('rol')){
            $user->rol = $request->input('rol');
        }

        $user->save();
        return response()->json($user,200);
    }
}
