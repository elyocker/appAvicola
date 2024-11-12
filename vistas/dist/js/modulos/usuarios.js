let unico_usuario=false;

function validaCampos(tipo) {
    if ( document.getElementById('fecha_inicio').value=='') {
        alert('la fecha inicio es obligatorio');
        return;
    }
    if ( document.getElementById('fecha_fin').value=='') {
        alert('la fecha fin es obligatorio');
        return;
    }
    accion(tipo);
}

function accion(tipo) {

    switch (tipo) {
        case 'buscar':
            buscar(tipo);
            break;

    
        default:
            break;
    }

}

function limpiarModal() {
    document.getElementById('usuario').value='';
    document.getElementById('password').value='';
    document.getElementById('usu_foto').value='';
    document.getElementById('nombre').value='';
    document.getElementById('rol').value='';
    document.getElementById('telefono').value='';
    document.getElementById('correo').value='';
    document.getElementById('apellido').value='';
}

function buscar(tipo) {

    $.ajax({
        url : 'ajax/ajax_usuarios.php',
        type : 'POST',
        async:false,
        data :  {
                    tipo:tipo                    
                },
        dataType : 'json',
        success : function(json) {
            // console.log(json.result);
            if(json.status=='success'){
                cargarTabla(json.result);  
            }
            
            if(json.status=='error'){
                               
            }
        },error:function(e){
            // console.log(e);
        }
    });
}

function cargarTabla(result) {
    $("#body_usu").empty();
  
    var table ="";
    var btn_estado_class="";
    var btn_estado="";
    // console.log(result);
    for (let i = 0; i < result.length; i++) {
        const element = result[i];

        if (element.usu_estado =='1') {
            btn_estado_class="btn btn-success";
            btn_estado="Activo";
        }else{
            btn_estado_class="btn btn-danger";
            btn_estado="Inactivo";
        }

        var ruta_foto = (element.usu_foto=='' || element.usu_foto == null) ? "img/preterm/AdminFemaleAvatar.png": element.usu_foto ;

        table +="<tr><td>"+element.usu_rol+"</td>";
        table +="<td>"+element.usu_nombre+"</td>";
        table +="<td>"+element.usu_cuenta+"</td>";
        table +="<td><img src='"+ruta_foto+"' class='img-thumbnail' width='40px'></img></td>"; 
        table +="<td>"+element.ultim_login+"</td>";         
        table +="<td><button class='"+btn_estado_class+"' onclick=\"cambioEstado('"+element.usu_codigo+"')\">"+btn_estado+"</button></td>";
        table +="<td><button class='btn btn-warning' data-toggle='modal' data-target='#modal_upd_usu' onclick=\"getUsuario('"+element.usu_codigo+"')\"><i class='fas fa-pencil-alt'></i></button>";
        table +="<button class='btn btn-danger' onclick=\"deleteUsuario('"+element.usu_codigo+"')\"><i class='fas fa-trash-alt'></i></button></td>";        
        table +="</tr>";
        
    }
    $( "#body_usu" ).append(table);
    
}

function validarImagen(id) {
    var nombre_imagen = document.getElementById(id).value;
    var extensiones_permi = /(.jpg|.jpeg|.png|.JPG|.PNG|.JPEG)$/i;
    
    if (!extensiones_permi.exec(nombre_imagen) ) {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'el archivo no cumple con la extencion',
            showConfirmButton: false,
            timer: 1500
          });        
        document.getElementById('usu_foto').value="";
        return;
    }
}

function cambioEstado(codigo) {
    $.ajax({
        url : 'ajax/ajax_usuarios.php',
        type : 'POST',
        data : {tipo:'estado',codigo:codigo},
        dataType : 'json',
        success : function(json) {
            Swal.fire({                        
                icon: `${json.status}`,
                title: `${json.msj}`,
                showConfirmButton: true,
                confirmButtonColor: '#28a745',
                confirmButtonText: 'Ok',
                closeOnConfirm: false,
                customClass: {  
                    title: 'title-alert'
                },
                }).then((result)=>{
                    if(result.value){                        
                        window.location = 'usuarios';
                    }
            });
                
        }
    });

}

function validarCampos(event) {
    event.preventDefault();
    var frm_usu= document.getElementById('frm_usu');    
    
    if (document.getElementById('usuario').value=='') {
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'El campo usuario es obligatorio',
            showConfirmButton: false,
            timer: 1500
          });
              
        return;
    }
    if (document.getElementById('password').value=='') {
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'El campo contraseña es obligatorio',
            showConfirmButton: false,
            timer: 1500
          });
       
        return;
    }
    if (document.getElementById('nombre').value=='') {
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'El campo nombre es obligatorio',
            showConfirmButton: false,
            timer: 1500
          });
        return;
    }
    if (document.getElementById('rol').value=='') {
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'El campo rol es obligatorio',
            showConfirmButton: false,
            timer: 1500
          });
        return;
    }
    if (document.getElementById('telefono').value=='') {
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'El campo telefono es obligatorio',
            showConfirmButton: false,
            timer: 1500
          });
        return;
    }
    if (document.getElementById('correo').value=='') {
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'El campo correo es obligatorio',
            showConfirmButton: false,
            timer: 1500
          });
        return;
    }
    if (document.getElementById('usu_foto').value=='') {
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'El campo foto es obligatorio',
            showConfirmButton: false,
            timer: 1500
          });
        return;
    }

    if (unico_usuario==true) {
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'El usuario ya existe',
            text: 'Prueba con otro usuario',
            showConfirmButton: false,
            timer: 1500
          });
        return;
    }
    
    frm_usu.submit();

}

$( document ).ready(function() {
    accion('buscar');
    pluginDataTable('tabla_usu');
});

function pluginDataTable(id) {
    
    $(`#${id}`).DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo(`#${id}_wrapper .col-md-6:eq(0)`);
}

function cargaDataTable(id) {
    $(`#${id}`).DataTable();
}

function getUsuario(codigo) {
    $.ajax({
        url : 'ajax/ajax_usuarios.php',
        type : 'POST',
        data : {tipo:'update',codigo:codigo},
        dataType : 'json',
        success : function(json) {
            console.log(json.result);
            if(json.status=='success'){
                document.getElementById('upd_nombre').value = json.result[0]['usu_nombre'];
                document.getElementById('upd_apellido').value = json.result[0]['usu_apellido'];
                document.getElementById('upd_telefono').value = json.result[0]['usu_telefono'];
                document.getElementById('upd_correo').value = json.result[0]['usu_email'];
                document.getElementById("upd_usuario").readOnly = true;
                document.getElementById('upd_usuario').value = json.result[0]['usu_cuenta'];
                document.getElementById('upd_tipo').value = "upd";
                document.getElementById('usu_codigo').value = codigo;
                document.getElementById("upd_rol").value = json.result[0]['usu_rol'];
            }

            if(json.status=='error'){
                
            }
        },beforeSend: function(){
            
        },
        error : function(xhr, status) {
            
        },complete : function(xhr, status) {
            
        }
    });
}

function deleteUsuario(codigo) {
    Swal.fire({
        title: 'Estas seguro?',
        text: "Deseas eliminar el usuario!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url : 'ajax/ajax_usuarios.php',
                type : 'POST',
                data : {tipo:'delete',codigo:codigo},
                dataType : 'json',
                success : function(json) {          
                    console.log(json);         
                    if(json.status=='success'){
                        Swal.fire(
                            'Eliminado!',
                            'Se elimino el usuario.',
                            'success'
                        )
                        buscar('buscar');
                        window.location = 'usuarios';
                    }        
                    if(json.status=='error'){
                        Swal.fire(
                            'Lo sentimos!',
                            'Hubo un problema al eliminarlo.',
                            'error'
                          )
                    }
                }
            });
         
        }
      })

    
}

function unicoUsuario(usuario) {
     
    $.ajax({
        url : 'ajax/ajax_usuarios.php',
        type : 'POST',
        data : {tipo:'unico_usu',usuario:usuario},
        dataType : 'json',
        success : function(json) {
           
            console.log(json);

            if (json.status=='success') {
                unico_usuario=true;
                Swal.fire({
                    position: 'top-end',
                    icon: `${json.icon}`,
                    title: `${json.title}`,
                    text: `${json.msj}`,
                    showConfirmButton: false,
                    timer: 1500
                  });
                  return;
            }

            if (json.status=='error')  unico_usuario=false;
                
        }
    });
}