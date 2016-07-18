/**
 * variables globales que identifican las pistas y los jugadores que hay en ellas
 */

var modelpista6 = {pos1: '', pos2: '', pos3: '', pos4: '', cont: 0};
var modelpista1 = {pos1: '', pos2: '', pos3: '', pos4: '', cont: 0};
var modelpista2 = {pos1: '', pos2: '', pos3: '', pos4: '', cont: 0};
var modelpista3 = {pos1: '', pos2: '', pos3: '', pos4: '', cont: 0};
var modelpista4 = {pos1: '', pos2: '', pos3: '', pos4: '', cont: 0};
var modelpista5 = {pos1: '', pos2: '', pos3: '', pos4: '', cont: 0};
var pistas = {1: modelpista1, 2: modelpista2, 3: modelpista3, 4: modelpista4, 5: modelpista5, 6: modelpista6};
var players = {};

$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /**
     * método que inicializa el formulario de añadir jugadores
     */
    $('#add').click(function () {
        $('#errorphone').text('');
        $('#erroremail').text('');
        document.getElementById('addPlayerForm').reset();
    });

    /**
     * método que toma los datos de jugador y llama a la funcion de añadir un jugador
     */
    $('#aniadir').click(function (event) {
        event.preventDefault();
        var texto = document.getElementById("first_name").value;
        texto += " " + document.getElementById("last_name").value;
        texto = texto.trim();
        escribir(texto);


    });

    /**
     * método para inicializar el componente selector de fecha con el formato adecuado
     */
    $('#divMiCalendario').datetimepicker({
        format: 'YYYY-MM-DD HH:00'
    });

    /**
     * método que realiza una peticion ajax de la selección guardada por el usuario, para ello
     * elimina todos los jugadores de las pistas y añade los de la selección
     */
    $('#restaurar').click(function () {
        var user_id = document.getElementById('idUser').innerHTML;
        var pistasReservadas, jugadores;
        $.get("http://localhost:8888/tdw2/public/reserva/" + user_id, function (data, status) {
            if (status == 'success') {
                pistasReservadas = data.reservas;
                if (pistasReservadas.length == 0) {
                    showMessage("no ha guardado ninguna reserva", 1);

                } else {
                    jugadores = document.getElementsByClassName("rowPlayer");

                    for (var i = 0; i < jugadores.length; i++) {
                        if (players[jugadores[i].id] != "pista-") {
                            sacardePista(jugadores[i].id);
                        }
                        delete players[jugadores[i].id];
                        jugadores[i].parentNode.removeChild(jugadores[i]);
                        i--;
                    }

                    for ( i = 0; i < pistasReservadas.length; i++) {
                        if (pistasReservadas[i].uno != "") {
                            escribir(pistasReservadas[i].uno);
                            asignarPista2(pistasReservadas[i].uno, parseInt(pistasReservadas[i].pista));
                        }
                        if (pistasReservadas[i].dos != "") {
                            escribir(pistasReservadas[i].dos);
                            asignarPista2(pistasReservadas[i].dos, parseInt(pistasReservadas[i].pista));
                        }
                        if (pistasReservadas[i].tres != "") {
                            escribir(pistasReservadas[i].tres);
                            asignarPista2(pistasReservadas[i].tres, parseInt(pistasReservadas[i].pista));
                        }
                        if (pistasReservadas[i].cuatro != "") {
                            escribir(pistasReservadas[i].cuatro);
                            asignarPista2(pistasReservadas[i].cuatro, parseInt(pistasReservadas[i].pista));
                        }

                    }

                    console.log(data);
                }
            } else {
                showMessage('no se ha podido comprobar si existe una seleccion guardada', 1);
                console.log(data);
            }
        });


    });


    /**
     * método que se encarga de mostrar el formulario de reservas
     */
    $('#reservar').click(function () {
        if (pistasVacias()) {
            showMessage('no se realizó nada porque las pistas estan vacias', 3);
        }else{
            var alertas = document.getElementsByClassName("alertReserva");
            for (var i = 0; i < alertas.length; i++) {
                alertas[i].parentNode.removeChild(alertas[i]);
                i--;
            }

            $('#modalReserva').modal('show');
        }


        //realizarReserva(fecha, estado, exito, error);
    });


    /**
     * método que se encarga de realizar pedir las reservas de pistas dada una fecha
     * y hora determinadas para poder realizar o no la creacion de la nueva reserva
     */
    $('#realizaReserva').click(function(){
        var alertas = document.getElementsByClassName("alertReserva");
        var fecha = document.getElementById('txtFecha').value;
       // showMessage(fecha,2);
        var estado = 'RESERVADO';
        var error = 'no se ha podido realizar la reserva';
        var exito = 'se ha realizado la reserva';
        var continuar = false;

        for (var i = 0; i < alertas.length; i++) {
            alertas[i].parentNode.removeChild(alertas[i]);
            i--;
        }


        if (fecha=='') {
            showMessage('debe seleccionar una fecha', 1);
        } else {

            $.get("http://localhost:8888/tdw2/public/pistasLibres/" + fecha, function (data, status) {
                if (status == 'success') {
                    var pistasReservadas = data.reservas;
                    if (pistasReservadas.length != 0) {
                        if(pistasReservadas.length !=6) {
                            console.log(data);
                            for (var i = 0; i < pistasReservadas.length; i++) {
                                var errorDiv = document.createElement('div');
                                if (pistas[parseInt(pistasReservadas[i].pista)].cont != 0) {
                                    continuar = true;
                                    errorDiv.setAttribute('class', 'alert alert-danger alertReserva');
                                    errorDiv.appendChild(document.createTextNode('Error: la pista ' +
                                        pistasReservadas[i].pista + ' se encuentra reservada'));
                                    document.getElementById('errorReservas').appendChild(errorDiv);
                                } else {
                                    errorDiv.setAttribute('class', 'alert alert-info alertReserva');
                                    errorDiv.appendChild(document.createTextNode('Info: la pista ' +
                                        pistasReservadas[i].pista + ' esta reservada'));
                                    document.getElementById('errorReservas').appendChild(errorDiv);
                                }
                            }
                            var errorDiv2 = document.createElement('div');
                            errorDiv2.setAttribute('class', 'alert alert-success alertReserva');
                            errorDiv2.appendChild(document.createTextNode('las demás pistas están libres'));
                            document.getElementById('errorReservas').appendChild(errorDiv2);
                            if (!continuar) {
                                realizarReserva(fecha, estado, exito, error);
                                $('#modalReserva').modal('hide');
                            }
                        }else{
                            var errorDiv2 = document.createElement('div');
                            errorDiv2.setAttribute('class', 'alert alert-danger alertReserva');
                            errorDiv2.appendChild(document.createTextNode('Para esta fecha y hora se encuentran todas las pistas reservadas, podrias cambiar de hora o si lo prefieres de fecha y hora'));
                            document.getElementById('errorReservas').appendChild(errorDiv2);

                        }


                    } else {
                        console.log(data);
                        realizarReserva(fecha, estado, exito, error);
                        $('#modalReserva').modal('hide');
                    }
                } else {

                    console.log(data);
                    showMessage('no se ha podido guardar la sesion', 1);
                }
            });
        }

    });


    /**
     * método que se encarga de almacenar la selección de jugadores realizada por el jugador
     * para poder asi retomarla en otra ocasión que entre al sistema
     */

    $('#guardar').click(function () {
        var user_id = document.getElementById('idUser').innerHTML;
        var fecha = 'es una seleccion';
        var estado = 'GUARDADO';
        var error = 'no se ha podido guardar la seleccion';
        var exito = 'se ha guardado la seleccion';
        if (pistasVacias()) {
            showMessage('no se realizó nada porque las pistas están vacias', 3);
        } else {

            $.get("http://localhost:8888/tdw2/public/reserva/" + user_id, function (data, status) {
                if (status == 'success') {
                    var pistasReservadas = data.reservas;
                    if (pistasReservadas.length != 0) {
                        console.log(data);
                        $('#test_modal').modal('show');

                    } else {
                        console.log(data);
                        realizarReserva(fecha, estado, exito, error);
                    }
                } else {
                    console.log(data);
                    showMessage('no se ha podido guardar la selección', 1);
                }
            });
        }

    });


    /**
     * método que se encarga de eliminar la seleccion de jugadores realizada anteriormente
     * para poder meter la nueva.
     */
    
    $('#sobrescribirSeleccion').click(function () {
        var user_id = document.getElementById('idUser').innerHTML;
        var fecha = 'es una seleccion';
        var estado = 'GUARDADO';
        var error = 'no se ha podido guardar la seleccion';
        var exito = 'se ha guardado la seleccion';
        var ruta = 'http://localhost:8888/tdw2/public/reserva/' + user_id;
        $.ajax({
            type: "DELETE",
            url: ruta,
            dataType: 'json',
            success: function (data) {
                console.log(data);

                realizarReserva(fecha, estado, exito, error);
                $('#test_modal').modal('hide');

            },
            error: function (data) {
                showMessage('no se ha podido guardar la selección', 1);
                console.log('Error:', data);
            }
        });

    });


});

/**
 * método que comprueba si las pistas estan vacias
 * 
 * */

 function pistasVacias() {
    var vacias = true;
    for (var i = 1; i <= 6; i++) {
        if (pistas[i].cont > 0) {
            vacias = false;
            break;
        }
    }
    return vacias;
}


/**
 * método que realiza las reservas de las pistas
 *
 * */
function realizarReserva(fecha, estado, exito, error) {
    var ruta = 'http://localhost:8888/tdw2/public/reserva';

    //var fecha = '2016-06-30 00:00:00';
    var user_id = document.getElementById('idUser').innerHTML;
    $.ajax({
        url: ruta,
        method: 'POST',
        contentType: 'application/json',
        processData: false,
        data: JSON.stringify({
            fecha: fecha,
            user_id: user_id,
            estado: estado,
            pistas: pistas
        }),
        success: function (data) {
            showMessage(exito, 2);
            console.log(data);
            return true;


        },
        error: function (data) {
            showMessage(error, 1);
            console.log(data);
            return false;
        }
    });

}


/**
 * método que añade los nombres de los jugadores al caption de la pista
 *
 * */
function setCaption(idpista) {
    "use strict";
    var nombres = "", i, elcaption;
    elcaption = document.getElementById("caption" + idpista);
    if (pistas[idpista].cont == 0) {
        elcaption.title = "";
        elcaption.style.color = "limegreen";
    } else {
        for (i = 1; i < 5; i = i + 1) {
            if (pistas[idpista]["pos" + i] != "") {
                nombres = nombres + pistas[idpista]["pos" + i] + ", ";
            }

        }
        document.getElementById("caption" + idpista).title = nombres;
        if (pistas[idpista].cont < 4) {
            elcaption.style.color = "orange";
        } else {
            elcaption.style.color = "red";
        }
    }

}

/**
 * método que saca de la pista a los jugadores
 *
 * */
function sacardePista(nombre) {
    "use strict";
    var idpista, cont;
    idpista = players[nombre];
    cont = 1;

    while (cont < 5) {
        //alert("w");
        if (pistas[idpista]["pos" + cont] == nombre) {
            //alert("e");
            document.getElementById(idpista + "pos" + cont).setAttribute("title", "");
            document.getElementById(idpista + "pos" + cont).style.display = "none";
            document.getElementById("s" + nombre).selectedIndex = "0";
            document.getElementById(nombre).style.color = "black";

            players[nombre] = "pista-";
            pistas[idpista]["pos" + cont] = "";
            pistas[idpista].cont = pistas[idpista].cont - 1;
            setCaption(idpista);
            return;
        }
        cont = cont + 1;

    }
    //alert("ya termine");
}

function sacardePista2(evento) {
    "use strict";
    var elevento = evento || window.Event;
    sacardePista(elevento.target.title);
}

/**
 * método que elimina a un jugador de la pista y del objeto players
 *
 * */
function deletePlayer(evento) {
    "use strict";
    var eltr;
    eltr = evento.target.parentNode.parentNode;
    if (players[eltr.id] != "pista-") {
        sacardePista(eltr.id);
    }
    delete players[eltr.id];
    eltr.parentNode.removeChild(eltr);
}


/**
 * método que realiza la insercion de los jugadores en el div asignado a ello
 *
 * */
function escribir(texto) {
    "use strict";
    //CONTROL SI ESTA VACIO
    var elDiv, eltr, eltd1, eltd2, imagen, elselect, opcion, i, nombre;


    if (players[texto] == null && texto != "") {

        elDiv = document.getElementById('cellPlayer');
        eltr = document.createElement("tr");
        eltd1 = document.createElement("td");
        eltd2 = document.createElement("td");
        imagen = document.createElement("span");
        elselect = document.createElement("select");
        players[texto] = "pista-";
        opcion = document.createElement("option");
        opcion.setAttribute("value", "pista-");
        opcion.appendChild(document.createTextNode("pista-"));
        elselect.appendChild(opcion);

        for (i = 1; i < 7; i = i + 1) {

            opcion = document.createElement("option");
            opcion.setAttribute("value", i);
            opcion.appendChild(document.createTextNode("pista" + i));
            elselect.appendChild(opcion);
        }
        elselect.setAttribute("id", "s" + texto);
        elselect.setAttribute("onchange", "asignarPista(event)");
        imagen.setAttribute('class', 'glyphicon glyphicon-trash btn-xs btn-danger');
        imagen.setAttribute("onClick", "deletePlayer(event)");
        eltr.setAttribute("id", texto);
        eltr.setAttribute("class", "rowPlayer");
        eltd1.appendChild(document.createTextNode(texto));
        eltd2.appendChild(elselect);
        eltd2.appendChild(imagen);
        eltr.appendChild(eltd1);
        eltr.appendChild(eltd2);
        elDiv.appendChild(eltr);
        $('#modalPlayer').modal('hide');
        showMessage("se ha añadido el jugador correctamente", 2);

    } else {
        showMessage("Introduzca otro nombre", 1);

    }

}


function getPos(idpista) {
    "use strict";
    if (pistas[idpista].pos1 === "") {
        return "pos1";
    }
    if (pistas[idpista].pos2 === "") {
        return "pos2";
    }
    if (pistas[idpista].pos3 === "") {
        return "pos3";
    }
    if (pistas[idpista].pos4 === "") {
        return "pos4";
    }
}


function asignarPista(evento) {
    "use strict";
    var elselect, idpista, nombre;
    elselect = evento.target;
    nombre = elselect.parentNode.parentNode.id;
    idpista = elselect.options[elselect.selectedIndex].value;

    asignarPistaAux(nombre, idpista, elselect);
}


function asignarPista2(nombre, idpista) {
    var elselect, idpista, nombre;
    elselect = document.getElementById("s" + nombre);
    asignarPistaAux(nombre, idpista, elselect);
}

function asignarPistaAux(nombre, idpista, elselect) {
    var pos;
    if (idpista != "pista-") {

        if (pistas[idpista].cont < 4) {
            if (players[nombre] != "pista-") {
                sacardePista(nombre);
            }
            pistas[idpista].cont = pistas[idpista].cont + 1;
            players[nombre] = idpista;
            pos = getPos(idpista);
            //alert(pos);
            pistas[idpista][pos] = nombre;
            document.getElementById(idpista + pos).setAttribute("title", pistas[idpista][pos]);
            document.getElementById(idpista + pos).style.display = "block";
            document.getElementById(nombre).style.color = "red";
            elselect.selectedIndex = players[nombre];
            setCaption(idpista);

        } else {
            if (players[nombre] != "pista-") {
                elselect.selectedIndex = players[nombre];
            } else {
                elselect.selectedIndex = "0";
            }
            showMessage("no se puede asignar un jugador a esa pista", 1);
        }
    } else {
        sacardePista(nombre);
    }

}