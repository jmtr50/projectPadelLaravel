/**
 * Created by jmtr50 on 19/6/16.
 */


/**
 * objeto que guarda las fechas de las reservas, id del usuario,pistas reservadas dada una fecha y hora
 *
 * */
var reservas={};
var user_id = document.getElementById('idUser').innerHTML;
var pistasReservadas;


$( document ).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //consulta de las reservas de un usuario
    $.get("http://localhost:8888/tdw2/public/historico/" + user_id, function (data, status) {
        if (status == 'success') {
            pistasReservadas = data.reservas;
            if (pistasReservadas.length == 0) {
                var vacioDiv = document.createElement('div');
                vacioDiv.setAttribute('class', 'alert alert-danger');
                vacioDiv.appendChild(document.createTextNode('En este momento no tienes ninguna reserva'));
                document.getElementById('fechasReservas').appendChild(vacioDiv);

            } else {
                for ( var i = 0; i < pistasReservadas.length; i++) {
                    if(reservas[pistasReservadas[i].fecha]==null){
                        reservas[pistasReservadas[i].fecha] = pistasReservadas[i].fecha;
                        var fechasDiv = document.createElement('div');
                        var consulta = document.createElement('span');
                        var basura = document.createElement("span");

                        basura.setAttribute('class','glyphicon glyphicon-trash btn-xs btn-danger pull-right');
                        consulta.setAttribute('class','glyphicon glyphicon-eye-open btn-primary btn-xs pull-right');

                        consulta.setAttribute('data-toggle',"modal");
                        consulta.setAttribute('data-target','#modalPistas');
                        consulta.setAttribute('onclick','crearPistas(event)');
                        basura.setAttribute('onclick','borrarReserva(event)');

                        
                        fechasDiv.setAttribute('id',pistasReservadas[i].fecha);
                        fechasDiv.setAttribute('class', 'alert alert-info');
                        fechasDiv.appendChild(document.createTextNode('reserva realizada en la fecha :  ' +
                            pistasReservadas[i].fecha ));
                        fechasDiv.appendChild(consulta);
                        fechasDiv.appendChild(basura);
                        document.getElementById('fechasReservas').appendChild(fechasDiv);


                    }
                }
                console.log(data);
            }
        }else{
            console.log(data);
        }
    });




        

    /**
     * método que inicializa el formulario de edicion del area personal
     *
     * */
    $('#editWindow').click(function() {
        $('#errorphone').text('');
        $('#erroremail').text('');
        document.getElementById('edit').reset();
    });

    /**
     * métodos que ocultan y muestran las secciones de home (area personal y consulta).
     *
     * */
    $('#personal').click(function () {
        document.getElementById('vistaReservas').setAttribute('class','container collapse');
        document.getElementById('vistaPersonal').setAttribute('class','container');
    });

    $('#reservas').click(function () {
        document.getElementById('vistaReservas').setAttribute('class','container ');
        document.getElementById('vistaPersonal').setAttribute('class','container collapse');
    });


    /**
     * método que actualiza la informacion de un usuario
     *
     * */
    $('#updateButton').click(function (event) {
        event.preventDefault();
        var id = event.target.value;
        var ruta = 'http://localhost:8888/tdw2/public/update/' + id;
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var old_password =$('#old_password').val();
        var password =$('#password').val();
        var password_confirmation =$('#password_confirmation').val();
        var error;
        
        $('#errorphone').text('');
        $('#erroremail').text('');


        $.ajax({
            url: ruta,
            method: 'PUT',
            contentType: 'application/json',
            processData: false,
            data: JSON.stringify({
                first_name: first_name,
                last_name: last_name,
                email: email,
                phone: phone,
                old_password:old_password,
                password:password,
                password_confirmation:password_confirmation
            }),
            success: function (data) {
                console.log(data);
                showMessage('se han modificado tus datos con exito',2);
                location.reload();


            },
            error: function (data) {
                console.log(data);
                error = JSON.parse(data.responseText);
                if (error.email != null){
                    $('#erroremail').text(error.email);
                }
                if (error.phone != null){
                    $('#errorphone').text(error.phone);
                }
                if (error.old_password != null){
                    $('#errorold_password').text(error.old_password);
                }
                if (error.password != null){
                    $('#errorpassword').text(error.password);
                }
                if (error.password_confirmation != null){
                    $('#errorpassword_confirmation').text(error.password_confirmation);
                }
            }
        });

    });



});

/**
 * método que crea las pistas de la reserva
 *
 * */
function crearPistas(event){
    var fecha = event.target.parentNode.id;
    var eldiv = document.getElementById('bodyPistas');
    var aux = document.getElementById('contenedorPistas');
    if(aux != null){
        aux.parentNode.removeChild(aux);
    }
    
    var contenedor = document.createElement('div');
    



    contenedor.setAttribute('id','contenedorPistas');


    for ( var i = 0; i < pistasReservadas.length; i++) {

        if(pistasReservadas[i].fecha == fecha){
            var reservaFecha = document.createElement('div');
            reservaFecha.setAttribute('class','alert alert-success');
            reservaFecha.appendChild(document.createTextNode('pista: '+pistasReservadas[i].pista));
            reservaFecha.appendChild(document.createElement('br'));
            if(pistasReservadas[i].uno != ""){
                reservaFecha.appendChild(document.createTextNode('jugador 1: '+pistasReservadas[i].uno));
                reservaFecha.appendChild(document.createElement('br'));
            }
            if(pistasReservadas[i].dos != "") {
                reservaFecha.appendChild(document.createTextNode('jugador 2: ' + pistasReservadas[i].dos));
                reservaFecha.appendChild(document.createElement('br'));
            }if(pistasReservadas[i].tres != "") {
                reservaFecha.appendChild(document.createTextNode('jugador 3: ' + pistasReservadas[i].tres));
                reservaFecha.appendChild(document.createElement('br'));
            }if(pistasReservadas[i].cuatro != "") {
                reservaFecha.appendChild(document.createTextNode('jugador 4: ' + pistasReservadas[i].cuatro));
            }
            contenedor.appendChild(reservaFecha);
        }


    }
    eldiv.appendChild(contenedor);

}

/**
 * método que borra las pistas de la reserva
 *
 * */



function borrarReserva(event) {

    var eldiv = event.target.parentNode;
    var fecha = eldiv.id;
    //alert (fecha);

    var user_id = document.getElementById('idUser').innerHTML;
    
    
    var ruta = 'http://localhost:8888/tdw2/public/reserva/'+user_id+'/'+fecha;
    $.ajax({

        type: "DELETE",
        url: ruta,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            eldiv.parentNode.removeChild(eldiv);
            showMessage(data.message,2);
            delete reservas[fecha];
            if(Object.keys(reservas).length === 0){
                var vacioDiv = document.createElement('div');
                vacioDiv.setAttribute('class', 'alert alert-danger');
                vacioDiv.appendChild(document.createTextNode('En este momento no tienes ninguna reserva'));
                document.getElementById('fechasReservas').appendChild(vacioDiv);
            }


        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
}

