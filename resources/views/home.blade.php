@extends('layouts.app')

@section('navbarTDW')
    <div id="idUser" style="display: none" >{{Auth::user()->id}}</div>
    @if(Auth::user()->enabled == 'enabled')
        <li><a id="personal" href="#" >Personal</a></li>
        <li><a id="reservas" href="#" >Reservas</a></li>

        @if(Auth::user()->rol=='ROLE_ADMIN')
            <li><a href="{{ url('/admin') }}">Validar</a></li>
        @endif
        <li><a href="{{ url('/pistas') }}">pistas</a></li>
    @endif
@endsection

@section('content')
    @if(Auth::user()->enabled == 'enabled')


    <div class="container " id="vistaPersonal">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Area Personal:
                        <button type="button" id="editWindow" class="btn btn-primary btn-xs pull-right" data-toggle="modal"
                                data-target="#myModal">
                            <span class="glyphicon glyphicon-pencil " aria-hidden="true"></span>
                        </button>
                    </div>
                    <div class="panel-body ">

                        <form class="form-horizontal col-sm-6 col-sm-offset-3" id="showUser" role="form">


                            <div class="form-group">
                                <label class="col-md-6 control-label">Nombre:</label>
                                <label class=" control-label">{{Auth::user()->first_name}}</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6 control-label">Apellidos:</label>
                                <label class=" control-label">{{Auth::user()->last_name}}</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6 control-label">Correo Electrónico:</label>
                                <label class=" control-label">{{Auth::user()->email}}</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6 control-label">Teléfono:</label>
                                <label class=" control-label">{{Auth::user()->phone}}</label>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container collapse" id="vistaReservas">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Reservas:
                    </div>
                    <div class="panel-body " id="fechasReservas">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Usuario</h4>
                </div>
                <div class="modal-body">

                    <!-- Formulario EditarUsario -->
                    <form class="form-horizontal" id="edit" role="form">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="first_name" class="col-md-4 control-label">Nombre</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name"
                                       value="{{ old('first_name') }}">
                                    <span class="help-block error">
                                        <strong id="errorfirst_name"></strong>
                                    </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-md-4 control-label">Apellido</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name"
                                       value="{{ old('last_name') }}">
                                    <span class="help-block error">
                                        <strong d="errorlast_name"></strong>
                                    </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Correo electrónico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email"
                                       value="{{ old('email') }}">
                                    <span class="help-block error">
                                        <strong id="erroremail"></strong>
                                    </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-md-4 control-label">Teléfono</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone"
                                       value="{{ old('phone') }}">
                                    <span class="help-block error">
                                         <strong id="errorphone"></strong>
                                    </span>

                            </div>
                        </div>

                        <a class="btn btn-link" data-toggle="collapse" data-target="#resetpass">¿Actualizar tu
                            contraseña?</a>
                        <div id="resetpass" class="collapse">

                            <div class="form-group">
                                <label for="old_password" class="col-md-4 control-label">Contraseña Actual</label>

                                <div class="col-md-6">
                                    <input id="old_password" type="password" class="form-control" name="old_password">
                                        <span class="help-block error">
                                             <strong id="errorold_password"></strong>
                                        </span>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label">Contraseña nueva</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">

                                        <span class="help-block error">
                                             <strong id="errorpassword"></strong>
                                        </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirmation" class="col-md-4 control-label">Repite la
                                    contraseña</label>

                                <div class="col-md-6">
                                    <input id="password_confirmation" type="password" class="form-control"
                                           name="password_confirmation">

                                        <span class="help-block error">
                                             <strong id="errorpassword_confirmation"></strong>
                                        </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button id="updateButton" class="btn btn-primary" value="{{Auth::user()->id}}}">
                                    <i class="fa fa-btn fa-user"></i> Actualizar
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


    <!-- Modal -->
    <div class="modal fade" id="modalPistas" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">PISTAS</h4>
                </div>
                <div class="modal-body" id="bodyPistas">

                </div>
            </div>

        </div>

    </div>




    <script src="{{asset('js/home.js')}}"></script>
    @else
        no estas habilitado
    @endif
@endsection