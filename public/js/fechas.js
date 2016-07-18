/**
 * Created by jmtr50 on 6/7/16.
 */
var fechasMes = new Array(12);
$( document ).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $.get("http://localhost:8888/tdw2/public/reservas",function (data, status) {
        if (status == 'success') {

            for(var i = 0; i < 12; i++) {
                fechasMes[i]=0;
            }
            var reservasFechas=data.reservas;
            //var d = new Date(reservasFechas[0].fecha);
            for ( var i = 0; i < reservasFechas.length; i++) {
                var d = new Date(reservasFechas[i].fecha).getMonth();
                fechasMes[parseInt(d)] =fechasMes[parseInt(d)]+1;
            }

        }
    });

});

function mostrarFechas(event) {
    var elselect;
    elselect = event.target;
    var numMes= elselect.selectedIndex;
    var cont = fechasMes[numMes];
    document.getElementById("fechaSeleccion").innerHTML = 'el mes seleccionado tiene '+cont+' reservas';

}