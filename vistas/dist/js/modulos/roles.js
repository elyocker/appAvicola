let rol_rep=false;
function limpiarModal() {
    document.getElementById('rol_nombre').value='';
}

function validarCampos(event) {
    event.preventDefault();
    var frm_usu= document.getElementById('frm_usu');    
    
    if (document.getElementById('rol_nombre').value=='') {
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'El campo rol es obligatorio',
            showConfirmButton: false,
            timer: 1500
          });
              
        return;
    }

    if (rol_rep) {
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'El rol ya existe, intenta con otro',
            showConfirmButton: false,
            timer: 1500
          });
              
        return;
    }
   
    frm_usu.submit();

}

function pluginDataTable(id) {
    
    $(`#${id}`).DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo(`#${id}_wrapper .col-md-6:eq(0)`);
}

function eliminarRol(codigo) {
    Swal.fire({
        title: 'Estas seguro?',
        text: "Deseas eliminar el rol!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url : 'ajax/ajax_roles.php',
                type : 'POST',
                data : {tipo:'delete',codigo:codigo},
                dataType : 'json',
                success : function(json) {
                    if(json.status=='success'){
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
                                    window.location = 'roles';
                                }
                        });
                    }
                    if(json.status=='error'){
                        
                    }
                }
            });
        }
    })
}

function cambiarEstado(codigo) {

    $.ajax({
        url : 'ajax/ajax_roles.php',
        type : 'POST',
        data : {tipo:'estado',codigo:codigo},
        dataType : 'json',
        success : function(json) {
            // console.log(json);
            if(json.status=='success'){
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
                            window.location = 'roles';
                        }
                    });
            }
            if(json.status=='error'){
                
            }
        }
    });
}

$( document ).ready(function() {
    buscar('buscar');
    pluginDataTable('table_rol');
});

function buscar(tipo) {

    $.ajax({
        url : 'ajax/ajax_roles.php',
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
            console.log(e);
        }
    });
}

function cargarTabla(result) {
    $("#body_roles").empty();
  
    var table ="";
    var btn_estado_class="";
    var btn_estado="";
    // console.log(result);
    for (let i = 0; i < result.length; i++) {
        const element = result[i];

        if (element.rol_estado =='1') {
            btn_estado_class="btn btn-success";
            btn_estado="Activo";
        }else{
            btn_estado_class="btn btn-danger";
            btn_estado="Inactivo";
        }

        table +="<tr><td>"+element.rol_id+"</td>";
        table +="<td>"+element.rol_nombre+"</td>";
        table +="<td><button class='"+btn_estado_class+"' onclick=\"cambiarEstado('"+element.rol_id+"')\">"+btn_estado+"</button></td>";
        table +="<td>";
        table +="<button class='btn btn-danger' onclick=\"eliminarRol('"+element.rol_id+"')\"><i class='fas fa-trash-alt'></i></button></td>";        
        table +="</tr>";
        
    }

    $( "#body_roles" ).append(table);
    
}

function validaRol(rol) {
    $.ajax({
        url : 'ajax/ajax_roles.php',
        type : 'POST',
        data : {tipo:'unicrol',rol:rol},
        dataType : 'json',
        success : function(json) {
            console.log(json);
            if(json.status=='success'){
                rol_rep=true;
                Swal.fire({
                    position: 'top-end',
                    icon: 'info',
                    title:  `${json.msj}`,
                    showConfirmButton: false,
                    timer: 1500
                  });
                      
                return;
            }
            if(json.status=='error'){
                rol_rep=false;
                
            }
        }
    });
}