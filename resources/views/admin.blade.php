@extends('layouts.app')


@section('content')
    @if(Auth::user()->enabled == 'enabled')
        @if(Auth::user()->rol=='ROLE_ADMIN')


        <div class="container">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Validacion de usuarios</div>
                    <div class="panel-body">

                        <select class="form-control" onchange='mostrarJugadores(event)'>
                            <option>Habilitar Usuarios</option>
                            <option>Inhabilitar Usuarios</option>
                        </select>

                        <!-- Table-to-load-the-data Part -->
                        <table id="cellPlayer" class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>email</th>
                                <th>Telefono</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>

                        </table>

                    </div>
                </div>
            </div>
        </div>



        <script src="{{asset('js/admin.js')}}"></script>
        @else
            no eres un administrador.
        @endif
    @else
        no estas habilitado.
    @endif
@endsection