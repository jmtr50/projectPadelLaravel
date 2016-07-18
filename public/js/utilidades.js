/**
 * Created by jmtr50 on 27/6/16.
 *
 * metodo para mostrar mensajes en el sistema
 */
function showMessage(texto,prioridad) {
    switch (prioridad){
        case 1: document.getElementById("alertaHeader").setAttribute("class","modal-header alert-danger");
            $("#alertaType").text("Error: "+ texto);
            break;
        case 2: document.getElementById("alertaHeader").setAttribute("class","modal-header alert-success");
            $("#alertaType").text("Exito: "+ texto);
            break;
        case 3:
            document.getElementById("alertaHeader").setAttribute("class","modal-header alert-info");
            $("#alertaType").text("Info: "+ texto);
            break;

    }
    $("#alerta").modal();

}
