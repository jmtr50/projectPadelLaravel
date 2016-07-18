
$(document).ready(function() {

    getusers(0); //inicializamos la tabla de usuarios con los que estan inhabilitados


    $.ajaxSetup({//metodo para la identifcacion del usuario en las peticiones ajax
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

    /**
     * método que llama a la creacion de la tabla de jugadores dada una selección
     */
    function mostrarJugadores(evento) {
        var elselect;
        elselect = evento.target;
        var tipoUser= elselect.selectedIndex;
        getusers(tipoUser);


    }

    /**
     * método que dado un parametro tipo rellena la tabla de usuarios con
     * los usuarios que estan habilitados o pendientes de ello.
     * ofrece la informacion de los usuarios asi como unas acciones para
     * el administrador, que son : borrar, habilitar o inhabilitar  el usuario
     */
    function getusers(tipo) {
        var ruta='';
        if(tipo==0){
            ruta = 'http://localhost:8888/tdw2/public/users/disabled';
        }else{
            ruta = 'http://localhost:8888/tdw2/public/users/enabled';
        }
        $.get(ruta, function(data, status){
           if(status == 'success'){
               var usuarios = data.users;
               var aux = document.getElementById('cuerpoTabla');
               if(aux != null){
                   aux.parentNode.removeChild(aux);
               }
               var cuerpo = document.createElement("tbody");
               cuerpo.setAttribute('id','cuerpoTabla');
               elDiv = document.getElementById('cellPlayer');
               for (var i = usuarios.length - 1; i >= 0; i--) {
                   var eltr = document.createElement("tr");
                   var nombre = document.createElement("td");
                   var apellido = document.createElement("td");
                   var email = document.createElement("td");
                   var telefono = document.createElement("td");
                   var acciones = document.createElement("td");
                   var borrar = document.createElement("button");
                   var habilitar = document.createElement("button");
                   var basura = document.createElement("span");
                   var enable = document.createElement("span");
                   nombre.appendChild(document.createTextNode(usuarios[i].first_name));
                   apellido.appendChild(document.createTextNode(usuarios[i].last_name));
                   email.appendChild(document.createTextNode(usuarios[i].email));
                   telefono.appendChild(document.createTextNode(usuarios[i].phone));
                   basura.setAttribute('class','glyphicon glyphicon-trash btn-xs btn-danger');
                   basura.setAttribute('data-toggle','popover');
                   basura.setAttribute('data-content','borrar');
                   basura.setAttribute('onclick','deleteUser(event)');
                   enable.setAttribute('data-toggle','popover');

                   if(tipo == 0){
                       enable.setAttribute('class','glyphicon glyphicon-ok btn-success btn-xs');
                       enable.setAttribute('data-content','habilitar');
                       enable.setAttribute('onclick','enableUser(event,"enabled")');
                   }else{
                       enable.setAttribute('class','glyphicon glyphicon-ban-circle btn-warning btn-xs');
                       enable.setAttribute('data-content','inhabilitar');
                       enable.setAttribute('onclick','enableUser(event,"disabled")');
                   }
                   acciones.appendChild(basura);
                   acciones.appendChild(enable);

                   eltr.setAttribute('id',usuarios[i].id);
                   eltr.appendChild(nombre);
                   eltr.appendChild(apellido);
                   eltr.appendChild(email);
                   eltr.appendChild(telefono);
                   eltr.appendChild(acciones);
                   cuerpo.appendChild(eltr);
               }
               elDiv.appendChild(cuerpo);
               $('.glyphicon').popover({
                   placement: 'top',
                   trigger: 'hover'
               });



           }

        });
    }


    /**
     * método que realiza una peticion ajax para borrar el usuario seleccionado
     */

    function deleteUser(evento) {
        var eltr,ruta;
        eltr = evento.target.parentNode.parentNode;
        ruta = 'http://localhost:8888/tdw2/public/users/' + eltr.id;

        $.ajax({
            type: "DELETE",
            url: ruta,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                eltr.parentNode.removeChild(eltr);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }


    /**
     * método realiza una petición put ajax para habilitar o inhabilitar el usuario seleccionado
     */
    function enableUser(evento,estado) {

        var eltr,ruta;
        eltr = evento.target.parentNode.parentNode;
        ruta = 'http://localhost:8888/tdw2/public/enable/' + eltr.id;


        $.ajax({
            url: ruta,
            method: 'PUT',
            contentType: 'application/json',
            processData: false,
            data: JSON.stringify({
                enabled: estado
            }),
            success: function (data) {
                console.log(data);
                eltr.parentNode.removeChild(eltr);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }

