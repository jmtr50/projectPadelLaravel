<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', function () {
    return view('welcome');
});
Route::get('/fechas', function () {
    return view('fechas');
});
//sesion Routes
Route::post('login', ['as'=>'login','uses'=>'Auth\AuthController@webLoginPost']);
Route::get('login', 'Auth\AuthController@showLoginForm');
Route::get('logout', 'Auth\AuthController@logout');

// Registration Routes
Route::get('register', 'Auth\AuthController@showRegistrationForm');
Route::post('register', 'Auth\AuthController@register');


//user Routes
Route::get('/home', 'HomeController@index');
Route::get('/users/{estado}','UsuarioController@index');
Route::get('/users/{id}','UsuarioController@show');
Route::delete('/users/{id}','UsuarioController@destroy');
Route::put('/enable/{id}','UsuarioController@enable');
Route::Put('/update/{id}','UsuarioController@update');
Route::get('/admin', 'UsuarioController@indexAdmin');
Route::get('/pistas','UsuarioController@indexPistas');

//Reserve Routes
Route::get('reservas','ReservaController@todasReservas');
Route::get('historico/{user_id}','ReservaController@historicoFechas');
Route::get('reserva/{user_id}','ReservaController@guardado');
Route::get('pistasLibres/{fecha}','ReservaController@pistasLibres');
Route::post('reserva','ReservaController@reservar');
Route::delete('reserva/{user_id}','ReservaController@borrarSesion');
Route::delete('reserva/{user_id}/{fecha}','ReservaController@borrarReserva');

Route::pattern('inexistentes','.*');
Route::any('/{inexistentes}', function () {
    return response()->json(['code' => 400,'message' => 'Bad Request'],400);
});