function getMunicipio(depart,municipio) {

    $.ajax({
        url : 'ajax/ajax_cotizacion.php',
        type : 'POST',
        data : {tipo:'ciudad',depart:depart},
        dataType : 'json',
        success : function(json) {
            // console.log(json);
            if(json.status=='success'){
                $(`#${municipio}`).empty();
                var option="<option value=''>-</option>"
                json.result.forEach(element => {
                    option+=`<option value='${element.id_municipio}'>${element.municipio}</option>`;
                });
                $( `#${municipio}` ).append(option);
            }
            if(json.status=='error'){
                $(`#${municipio}`).empty();
                option="<option value=''>Seleccion invalida</option>"
                $( `#${municipio}` ).append(option);
            }
        },beforeSend: function(){
            $(`#${municipio}`).val('Validando...')
        }
    });
}

$( document ).ready(function() {
    
    buscar('buscar');
    
})

function pluginDataTable(id) {
    
    $(`#${id}`).DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo(`#${id}_wrapper .col-md-6:eq(0)`);
}

function buscar(tipo) {

    $.ajax({
        url : 'ajax/ajax_cliente.php',
        type : 'POST',
        data : {tipo:tipo},
        dataType : 'json',
        success : function(json) {

            if(json.status=='success'){
                llenarTabla(json.result);
                pluginDataTable('tabla_cliente');
            }

            if(json.status=='error'){
                Swal.fire({
                    position: 'top-end',
                    icon: 'info',
                    title: `No hay registro de cotización`,
                    showConfirmButton: false,
                    timer: 1500
                  });
                      
                return false ;
            }
        }
    });
}

function llenarTabla(result) {

    $("#body_cliente").empty();


    var rol_login= document.getElementById('rol_login').value;


    result.forEach(element => {

        var tab ="<tr>";
        tab +="<td>"+element.cli_cedula+"</td>";
        tab +="<td>"+element.cli_nombre+"</td>";
        tab +="<td>"+element.cli_telefono+"</td>";
        tab +="<td>"+element.cli_email+"</td>";
        tab +="<td>"+element.municipio +", "+ element.departamento +"</td>";        
        tab +="<td><button type='button' class='btn btn-warning' data-toggle='modal' data-target='#modal_clientes_upd'  onclick='datoCliente("+element.cli_id+")' ><i class='fas fa-pencil-alt'></i></button>";
        if (rol_login=='admin') tab +="<button type='button' class='btn btn-danger' onclick='delete_cliente("+element.cli_id+");' ><i class='fas fa-trash-alt'></i></button>";
        
        tab +="</td></tr>";
    
        $( "#body_cliente" ).append(tab);
    });

}

function delete_cliente(codigo) {

    Swal.fire({
        title: 'Estas seguro?',
        text: "Deseas eliminar el cliente!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url : 'ajax/ajax_cliente.php',
                type : 'POST',
                data : {tipo:'delete',codigo:codigo},
                dataType : 'json',
                success : function(json) {

                    if(json.status=='success'){
                    
                        Swal.fire({                    
                                icon: `${json.status}`,
                                title: `${json.title}`,
                                text: `${json.msj}`,
                                showConfirmButton: true
                        
                            }).then((result) => {                            
                                if (result.isConfirmed) {
                                    window.location = 'clientes';
                                } 
                            });              
                        
                    }

                    if(json.status=='error'){   

                        Swal.fire({
                                icon: `${json.status}`,
                                title: `${json.title}`,
                                text: `${json.msj}`,
                                showConfirmButton: true
                            }).then((result) => {                            
                                if (result.isConfirmed) {
                                    window.location = 'clientes';
                                } 
                            });

                    }
                }
            });
        }
    })
}

function datoCliente(codigo) {
    $.ajax({
        url : 'ajax/ajax_cliente.php',
        type : 'POST',
        data : {tipo:'getcliente',codigo:codigo},
        dataType : 'json',
        success : function(json) {
            if(json.status=='success'){
               
                document.getElementById('cli_cedula_upd').value         =json.result[0]['cli_cedula'];
                document.getElementById('cli_cedula_upd').readOnly =true;
                document.getElementById('cli_nombre_upd').value         =json.result[0]['cli_nombre'];
                document.getElementById('cli_telefono_upd').value       =json.result[0]['cli_telefono'];
                document.getElementById('cli_email_upd').value          =json.result[0]['cli_email'];
                document.getElementById('cli_direccion_upd').value      =json.result[0]['cli_direccion'];
                document.getElementById('cli_barrio_upd').value         =json.result[0]['cli_barrio'];
                document.getElementById('departamento_upd').value       =json.result[0]['cli_depart'];
                document.getElementById('ciudad_upd').innerHTML         ="<option value='"+json.result[0]['cli_ciudad']+"' >"+json.result[0]['municipio']+"</option>";

            }

            if(json.status=='error'){    
              
            }
        },
        error : function(xhr, status) {
            // console.log(xhr);
        }
    });
    
}

function evento(event='',accion='') {

    if (event.keyCode==13) {

        if(accion=='cliente')  getCliente()   ;       

    }
}

var entro =false;
function getCliente() {

    let cedula = document.getElementById('cli_cedula').value;

    $.ajax({
        url : 'ajax/ajax_cliente.php',
        type : 'POST',
        data : {tipo:'cliente',cedula:cedula},
        dataType : 'json',
        success : function(json) {

            if(json.status=='success'){
                entro=true;
                Swal.fire({
                    position: 'top-end',
                    icon: 'info',
                    title: `Lo sentimos`,
                    text:'la cedula del Cliente ya existe',
                    showConfirmButton: false,
                    timer: 1500
                  });
              
               return;
            }

            if(json.status=='error'){    
               entro=false;
            }
        }
    });
    
}

function validaForma(event) {
    event.preventDefault();
    let result=false;
    var forma_cotiza= document.getElementById('forma_cliente');    

    getCliente();
    if (entro) return;
      
    result= valida_campos('cli_cedula','El campo cedula es obligatorio');
    if (!result)return;
    result= valida_campos('cli_nombre','El campo nombre es obligatorio');
    if (!result)return;
    result= valida_campos('cli_telefono','El campo telefono es obligatorio');
    if (!result)return;
    result= valida_campos('cli_email','El campo email es obligatorio');
    if (!result)return;
    result= valida_campos('departamento','El campo departamento es obligatorio');
    if (!result)return;
    result= valida_campos('cli_direccion','El campo dirección es obligatorio');
    if (!result)return;
    result= valida_campos('cli_barrio','El campo barrio es obligatorio');
    if (!result)return;
    result= valida_campos('ciudad','El campo municipios es obligatorio');
    if (!result)return;
 
    if (result) forma_cotiza.submit();

}

function validaFormaUpd(event) {

    event.preventDefault();

    let result=false;

    var forma_cotiza= document.getElementById('forma_cliente_upd');    
   
    result= valida_campos('cli_nombre_upd','El campo nombre es obligatorio');
    if (!result)return;
    result= valida_campos('cli_telefono_upd','El campo telefono es obligatorio');
    if (!result)return;
    result= valida_campos('cli_email_upd','El campo email es obligatorio');
    if (!result)return;
    result= valida_campos('departamento_upd','El campo departamento es obligatorio');
    if (!result)return;
    result= valida_campos('cli_direccion_upd','El campo dirección es obligatorio');
    if (!result)return;
    result= valida_campos('cli_barrio_upd','El campo barrio es obligatorio');
    if (!result)return;
    result= valida_campos('ciudad_upd','El campo municipios es obligatorio');
    if (!result)return;
 
    if (result) forma_cotiza.submit();

}

function valida_campos(id,msj) {

    if (document.getElementById(id).value=='') {
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: `${msj}`,
            showConfirmButton: false,
            timer: 1500
          });
              
        return false ;
    }

    return true;
}

