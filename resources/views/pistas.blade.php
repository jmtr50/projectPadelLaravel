@extends('layouts.app')



@section('navbarTDW')
    <div id="idUser" style="display: none" >{{Auth::user()->id}}</div>

    @if(Auth::user()->enabled == 'enabled')
        <li><a href="{{ url('/home') }}">Inicio</a></li>
        @if(Auth::user()->rol=='ROLE_ADMIN')
            <li><a href="{{ url('/admin') }}">Validar</a></li>
        @endif
        <li><a id="reservar" href="#">Reservar</a></li>
        <li><a id="guardar" href="#">Guardar</a></li>
        <li><a id="restaurar" href="#">Restaurar</a></li>
    @endif
@endsection



@section('content')
    @if(Auth::user()->enabled == 'enabled')
    <link rel="stylesheet" href="{{asset('css/reserva.css')}}">

    <div class="container-fluid">
        <div class="row content">
            <div class="col-sm-4  player">
                <h4> <span class="label label-success btn-success" data-toggle="modal" id="add"
                           data-target="#modalPlayer">Añadir jugador
                        <span class="glyphicon glyphicon-plus " aria-hidden="true"></span>
                    </span>
                </h4>
                <table id="cellPlayer" class="table-bordered table-hover">
                    <tr class="bg-success">
                        <th>Nombre</th>
                        <th>Acciones jugadores</th>
                    </tr>
                </table>
            </div>
            <div class="col-sm-8 ">


                <div class="col-sm-6 courts">
                    <table class="pista" id="pista1">
                        <caption id="caption1" title=""><strong>Pista 1</strong>

                        </caption>
                        <tr>
                            <td><img src="Imagenes/player.png" id="1pos1" title="" onclick="sacardePista2(event)"></td>
                            <td><img src="Imagenes/player.png" id="1pos2" title="" onclick="sacardePista2(event)"></td>
                        </tr>
                        <tr>
                            <td><img src="Imagenes/player.png" id="1pos3" title="" onclick="sacardePista2(event)"></td>
                            <td><img src="Imagenes/player.png" id="1pos4" title="" onclick="sacardePista2(event)"></td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-6 courts">

                    <table class="pista" id="pista2">
                        <caption id="caption2" title=""><strong>Pista 2</strong>

                        </caption>
                        <tr>
                            <td><img src="Imagenes/player.png" id="2pos1" title="" onclick="sacardePista2(event)"></td>
                            <td><img src="Imagenes/player.png" id="2pos2" title="" onclick="sacardePista2(event)"></td>
                        </tr>
                        <tr>
                            <td><img src="Imagenes/player.png" id="2pos3" title="" onclick="sacardePista2(event)"></td>
                            <td><img src="Imagenes/player.png" id="2pos4" title="" onclick="sacardePista2(event)"></td>
                        </tr>
                    </table>

                </div>
                <div class="col-sm-6 courts">
                    <table class="pista" id="pista1">
                        <caption id="caption3" title=""><strong>Pista 3</strong>

                        </caption>
                        <tr>
                            <td><img src="Imagenes/player.png" id="3pos1" title="" onclick="sacardePista2(event)"></td>
                            <td><img src="Imagenes/player.png" id="3pos2" title="" onclick="sacardePista2(event)"></td>
                        </tr>
                        <tr>
                            <td><img src="Imagenes/player.png" id="3pos3" title="" onclick="sacardePista2(event)"></td>
                            <td><img src="Imagenes/player.png" id="3pos4" title="" onclick="sacardePista2(event)"></td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-6 courts">

                    <table class="pista" id="pista2">
                        <caption id="caption4" title=""><strong>Pista 4</strong>

                        </caption>
                        <tr>
                            <td><img src="Imagenes/player.png" id="4pos1" title="" onclick="sacardePista2(event)"></td>
                            <td><img src="Imagenes/player.png" id="4pos2" title="" onclick="sacardePista2(event)"></td>
                        </tr>
                        <tr>
                            <td><img src="Imagenes/player.png" id="4pos3" title="" onclick="sacardePista2(event)"></td>
                            <td><img src="Imagenes/player.png" id="4pos4" title="" onclick="sacardePista2(event)"></td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-6 courts">
                    <table class="pista" id="pista5">
                        <caption id="caption5" title=""><strong>Pista 5</strong>

                        </caption>
                        <tr>
                            <td><img src="Imagenes/player.png" id="5pos1" title="" onclick="sacardePista2(event)"></td>
                            <td><img src="Imagenes/player.png" id="5pos2" title="" onclick="sacardePista2(event)"></td>
                        </tr>
                        <tr>
                            <td><img src="Imagenes/player.png" id="5pos3" title="" onclick="sacardePista2(event)"></td>
                            <td><img src="Imagenes/player.png" id="5pos4" title="" onclick="sacardePista2(event)"></td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-6 courts">

                    <table class="pista" id="pista6">
                        <caption id="caption6" title=""><strong>Pista 6</strong>

                        </caption>
                        <tr>
                            <td><img src="Imagenes/player.png" id="6pos1" title="" onclick="sacardePista2(event)"></td>
                            <td><img src="Imagenes/player.png" id="6pos2" title="" onclick="sacardePista2(event)"></td>
                        </tr>
                        <tr>
                            <td><img src="Imagenes/player.png" id="6pos3" title="" onclick="sacardePista2(event)"></td>
                            <td><img src="Imagenes/player.png" id="6pos4" title="" onclick="sacardePista2(event)"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Jugadores -->
    <div class="modal fade" id="modalPlayer" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Usuario</h4>
                </div>
                <div class="modal-body">
                    <!-- Formulario AñadirJugador -->
                    <form class="form-horizontal" id="addPlayerForm" role="form">


                        <div class="form-group">
                            <label for="first_name" class="col-md-4 control-label">Nombre</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name">
                                    <span class="help-block error">
                                        <strong id="errorfirst_name"></strong>
                                    </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-md-4 control-label">Apellido</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name">
                                    <span class="help-block error">
                                        <strong d="errorlast_name"></strong>
                                    </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">

                                <button id="aniadir" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Create Player
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal Reservas-->
    <div class="modal fade" id="modalReserva" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Realizar Reserva:</h4>
                </div>
                <div class="modal-body">
                    <!-- Formulario De Reservas -->
                    <form class="form-horizontal" id="addPlayerForm" role="form">

                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                                <div class="well well-sm">
                                    <div class='input-group date' id='divMiCalendario'>
                                        <input type='text' id="txtFecha" class="form-control"
                                               placeholder="Seleccione la fecha y hora " readonly/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1" id="errorReservas">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="realizaReserva" class="btn btn-primary">Reservar
                    </button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="test_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal">&times;</a>
                    <h4>Descartar selección</h4>
                </div>
                <div class="modal-body">
                    <p>Actualmente tiene una selección de jugadores guardada ¿desea descartar esta selección?</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-primary" data-dismiss="modal">Cerrar</a>
                    <a href="#" id='sobrescribirSeleccion' class="btn btn-primary">Aceptar</a>
                </div>
            </div>
        </div>
    </div>


    <script src="{{asset('js/funciones.js')}}"></script>
    @else
        no estas habilitado
    @endif
@endsection

