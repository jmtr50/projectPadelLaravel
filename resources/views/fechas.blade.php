@extends('layouts.app')


@section('content')



            <div class="container">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">ver reservas fechas</div>
                        <div class="panel-body">
                            <select class="form-control" onchange='mostrarFechas(event)'>
                                <option>enero</option>
                                <option>febrero</option>
                                <option>marzo</option>
                                <option>abril</option>
                                <option>mayo</option>
                                <option>junio</option>
                                <option>julio</option>
                                <option>agosto</option>
                                <option>septiembre</option>
                                <option>octubre</option>
                                <option>noviembre</option>
                                <option>diciembre</option>
                            </select>
                            <div class="col-md-6 col-md-offset-3">
                                <p id="fechaSeleccion"></p>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <script src="{{asset('js/fechas.js')}}"></script>
@endsection