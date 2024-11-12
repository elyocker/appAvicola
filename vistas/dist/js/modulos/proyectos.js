function buscar(tipo) {

    if( document.getElementById('proy_nombre')) var pro_nombre  = document.getElementById('proy_nombre').value;
    if( document.getElementById('fecha_ini')) var fecha_ini   = document.getElementById('fecha_ini').value;
    if( document.getElementById('fecha_fin')) var fecha_fin   = document.getElementById('fecha_fin').value;
    if( document.getElementById('limite')) var limite      = document.getElementById('limite').value;
    if( document.getElementById('pro_asignado')) var pro_asignado      = document.getElementById('pro_asignado').value;
    if( document.getElementById('pro_estado')) var pro_estado      = document.getElementById('pro_estado').value;
    if( document.getElementById('pro_limite')) var pro_limite      = document.getElementById('pro_limite').value;
    if( document.getElementById('pro_codigo')) var pro_codigo      = document.getElementById('pro_codigo').value;
    
    $.ajax({
        url : 'ajax/ajax_proyecto.php',
        type : 'POST',
        data : {tipo:tipo,pro_nombre:pro_nombre,fecha_ini:fecha_ini,fecha_fin:fecha_fin,limite:limite,
                pro_asignado:pro_asignado,pro_estado:pro_estado,limite:pro_limite,pro_codigo:pro_codigo},
        dataType : 'json',
        success : function(json) {
            // console.log(json);
            if(json.status=='success'){
                llenarTabla(json.result); 
                               
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

$( document ).ready(function() {
    buscar('buscar');    
    
});

function llenarTabla(result) {

    $("#body_proyectos").empty();


    result.forEach(element => {

        var estado=(element.pro_estado==0) ? "Pendiente": ( element.pro_estado==1 ? "En proceso": element.pro_estado==2 ? "Curaduria" : element.pro_estado==3 ? "Entregado" : "" );            
        var class_estado=(element.pro_estado==0) ? "badge badge-secondary": ( element.pro_estado==1 ? "badge badge-warning": element.pro_estado==2 ? "badge badge-success" : element.pro_estado==3 ? "badge badge-success" : "" );            

        var tab ="<tr>";
        tab +="<td>"+element.pro_codigo+"</td>";
        tab +="<td>"+element.pro_nombre+"</td>";
        tab +="<td>"+element.nombre_usuario+"</td>";
        tab +="<td>"+element.cli_barrio +"</td>";
        tab +="<td>"+element.pro_estimado +"</td>";
        tab +="<td>"+element.pro_fechaini +"</td>";
        tab +="<td>"+element.pro_fechafin +"</td>";
        tab +="<td><span class='"+class_estado+"'>"+estado+"</span></td>";
        tab +="<td> <a href='vistas/pdf/generados/cotizacion_"+element.pro_nombre+".pdf' Target='_blank' class='btn btn-danger'  >PDF</a></td>";
        tab +="<td> <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modal_proyecto' onclick='detalle_proyecto(\""+element.pro_codigo+"\")' >Detalle</button></td>";
        tab +="</tr>";
    
        $( "#body_proyectos" ).append(tab);
    });

}

function detalle_proyecto(codigo) {
   
    $.ajax({
        url : 'ajax/ajax_proyecto.php',
        type : 'POST',
        data : {tipo:'editar',codigo:codigo},
        dataType : 'json',
        success : function(json) {
            // console.log(json);
            if(json.status=='success'){
                document.getElementById(`btn_pro_mdl`).disabled=false;                    
                
                document.getElementById('titulo_proyecto_modal').innerText='Nombre: '+json.result[0]['pro_nombre'];
                document.getElementById('title_fecha_entrega_mdl').innerText='Fecha de Entrega: '+json.result[0]['pro_estimado'];
                document.getElementById('asginado').innerText=json.result[0]['nombre_usuario'];
                document.getElementById('codigo_proyecto').value=json.result[0]['pro_codigo'];
                document.getElementById('tipo_proyecto').value="update";
                document.getElementById('nombre_pro').value=json.result[0]['pro_nombre'];
                
                div_modal(json.result[0]['pro_autocat'],'autocat');
                div_modal(json.result[0]['pro_escritura'],'escritura');
                div_modal(json.result[0]['pro_certiftradi'],'certifitradi');
                div_modal(json.result[0]['pro_impredial'],'impredial');
                div_modal(json.result[0]['pro_otroarch'],'otroarch');
                
                div_modal(json.result[0]['pro_foto1'],'foto1','foto');
                div_modal(json.result[0]['pro_foto2'],'foto2','foto');
                div_modal(json.result[0]['pro_foto3'],'foto3','foto');
                div_modal(json.result[0]['pro_foto4'],'foto4','foto');
                div_modal(json.result[0]['pro_foto5'],'foto5','foto');
                div_modal(json.result[0]['pro_foto6'],'foto6','foto');
                
                if ( json.result[0]['pro_estado']=='0' ) {
                    document.getElementById(`div_descripcion`).style.display=''; 
                    document.getElementById('input_descripcion').disabled=false;
                    document.getElementById('btnDescrip').disabled=false;
                    document.getElementById('proyecto_estado').disabled=false;
                    document.getElementById('btn_pro_mdl').disabled=false;  
                    cargar_descrip();                  
                    estado_mdl('proceso');
                }else if  ( json.result[0]['pro_estado']=='1' ) {
                    document.getElementById(`div_descripcion`).style.display='';  
                    document.getElementById('input_descripcion').disabled=false;
                    document.getElementById('btnDescrip').disabled=false;
                    document.getElementById('proyecto_estado').disabled=false;
                    document.getElementById('btn_pro_mdl').disabled=false; 
                    cargar_descrip();                  
                    estado_mdl('proceso');
                }else if  ( json.result[0]['pro_estado']=='2' ) {
                    document.getElementById(`div_descripcion`).style.display='';  
                    document.getElementById('input_descripcion').disabled=false;
                    document.getElementById('btnDescrip').disabled=false;
                    document.getElementById('proyecto_estado').disabled=false;
                    document.getElementById('btn_pro_mdl').disabled=false; 
                    cargar_descrip();                  
                    estado_mdl('proceso','curaduria');

                } else if ( json.result[0]['pro_estado']=='3' ) {

                    document.getElementById(`div_descripcion`).style.display='';  
                    document.getElementById('input_descripcion').disabled=true;
                    document.getElementById('btnDescrip').disabled=true;
                    document.getElementById('proyecto_estado').disabled=true;
                    document.getElementById('btn_pro_mdl').disabled=true;
                    cargar_descrip();                  
                    estado_mdl();

                }else {
                    estado_mdl();
                    cargar_descrip(); 
                    document.getElementById(`div_descripcion`).style.display=''; 
                    document.getElementById('input_descripcion').disabled=false;
                    document.getElementById('btnDescrip').disabled=false;
                    document.getElementById('proyecto_estado').disabled=false;
                    document.getElementById('btn_pro_mdl').disabled=false; 
                }

                document.getElementById('proyecto_estado').value=json.result[0]['pro_estado'];
               
                if ( json.result[0]['pro_estado']=='3' &&  json.result[0]['usu_codigo'] != document.getElementById('usuario_login').value &&  document.getElementById('usuario_rol').value !='admin' )  {
                    document.getElementById('input_descripcion').disabled=true;
                    document.getElementById('btnDescrip').disabled=true;
                    document.getElementById('proyecto_estado').disabled=true;
                    document.getElementById('btn_pro_mdl').disabled=true;
                    document.getElementById(`div_descripcion`).style.display='none'; 
                }
               
            }

            if(json.status=='error'){
                document.getElementById(`btn_pro_mdl`).disabled=true;                    
                
            }
        }
    });
    
}

function div_modal(dato='',id='',foto='') {

    if ( dato !=='' ) {
        document.getElementById(`div_${id}`).style.display='';
        document.getElementById(`${id}_descarga`).href=dato ;
        if(foto!='') {
            document.getElementById(`${id}_img`).src=`${dato}`   ;
            document.getElementById(`btn_${id}`).style.display='';    
        }    
        document.getElementById(`name_${id}`).value=dato;
        
    }else{
        document.getElementById(`div_${id}`).style.display='none';  
        if(foto!='') document.getElementById(`btn_${id}`).style.display='none';   
        document.getElementById(`name_${id}`).value="";

    }
}

function guardar_descrip() {

    if(document.getElementById(`input_descripcion`)) var text_descripcion= document.getElementById(`input_descripcion`).value;
    if(document.getElementById(`codigo_proyecto`)) var codigo= document.getElementById(`codigo_proyecto`).value;

    $.ajax({
        url : 'ajax/ajax_proyecto.php',
        type : 'POST',
        data : {tipo:"descripcion",codigo:codigo,text_descripcion:text_descripcion},
        dataType : 'json',
        success : function(json) {
            // console.log(json);
            if(json.status=='success'){
                cargar_descrip();
            }
            if(json.status=='error'){
                
            }
        },complete : function(xhr, status) {
            
        }
    });
    

}

function validaForma(event) {
    event.preventDefault();
    let result=false;
    var forma_proy= document.getElementById('forma_proy_upd');    

    
 
    forma_proy.submit();

}

function cargar_descrip() {

    if(document.getElementById(`codigo_proyecto`)) var codigo= document.getElementById(`codigo_proyecto`).value;

    $.ajax({
        url : 'ajax/ajax_proyecto.php',
        type : 'POST',
        data : {tipo:'getDescrip',codigo:codigo},
        dataType : 'json',
        success : function(json) {
            // console.log(json);
            if(json.status=='success'){
                $("#text_descrip").empty();
               
                json.result.forEach(element => {
                    var tab ='<div class="direct-chat-msg">';
                    tab +='<div class="direct-chat-infos clearfix">';
                    tab +='<span class="direct-chat-name float-left">'+element.nombre_usuario+'</span>';
                    tab +='<span class="direct-chat-timestamp float-right">'+element.des_fechac+' '+element.des_horac+'</span>';
                    tab +='</div>';
                    tab +='<img class="direct-chat-img" src="'+element.foto+'" alt="message user image">';
                    tab +=' <div class="direct-chat-text">';
                    tab +=element.des_text;
                    tab +='</div>';
                    tab +='</div>';

                    $( "#text_descrip" ).append(tab);
                    document.getElementById('input_descripcion').value='';
                    
                });
                
            }

            if(json.status=='error'){
                $("#text_descrip").empty();
            }
        }
    });
    
}

function estado_mdl(tipo='',cura='') {

    $("#proyecto_estado").empty();
    var table = `<option value="">-</option>`;
    table += (tipo!='')? ``: `<option value="0">Pendiente</option>`;
    table +=  (cura!='')? `` :`<option value="1">En proceso</option>`;
    table += `<option value="2">Curaduria</option>`;
    table += `<option value="3">Entregado</option>`;
    $( "#proyecto_estado" ).append(table);

}



function cleanFiltros() {
    document.getElementById('pro_codigo').value='';
    document.getElementById('proy_nombre').value='';
    if(document.getElementById('pro_asignado')) document.getElementById('pro_asignado').value='';
    document.getElementById('pro_estado').value='';
    document.getElementById('fecha_ini').value='';
    document.getElementById('fecha_fin').value='';
}

function pluginDataTable(id) {
    
    $(`#${id}`).DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo(`#${id}_wrapper .col-md-6:eq(0)`);
}