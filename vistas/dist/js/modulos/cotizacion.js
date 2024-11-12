function valida_medidas(tipo) {
    if (tipo === 'ancho - fondo') {
        document.getElementById('ancho_fondo').style.display='';
        document.getElementById('medida_m2').style.display='none';
        document.getElementById('metros_m2').value='';
        return;
    }

    if (tipo === 'm2') {
        document.getElementById('medida_m2').style.display='';
        document.getElementById('ancho_fondo').style.display='none';
        document.getElementById('ancho').value='';
        document.getElementById('fondo').value='';
        return;
    }

    document.getElementById('ancho_fondo').style.display='none';
    document.getElementById('medida_m2').style.display='none';
    document.getElementById('metros_m2').value='';
    document.getElementById('ancho').value='';
    document.getElementById('fondo').value='';

}

function validaCamposCoti(valor) {

    if (valor==='confinado') {        
        document.getElementById('div_estud_suelos').style.display='none';
        document.getElementById('estu_suelos').checked=false;
        calcula_cotizacion();
        return;
    }

    if (valor==='aporticado') {
        document.getElementById('div_estud_suelos').style.display='';
        document.getElementById('estu_suelos').checked=true;
        calcula_cotizacion();
        return;
    }
}

function validaDato() {

    var arquitectonico  = document.getElementById('arquitectonico').checked;
    var estructural     = document.getElementById('estructural').checked;

    if (estructural==true && arquitectonico==true) {
        document.getElementById('div_estud_suelos').style.display='';
        document.getElementById('aport_confinado').style.display='';
        calcula_cotizacion();
        return;
    }

    if (arquitectonico==true ) {        
        document.getElementById('aport_confinado').style.display='none';
        document.getElementById('div_estud_suelos').style.display='';
        document.getElementById('tot_confinado').value="";
        document.getElementById('tot_aporticado').value="";       
        document.getElementById('confinado').checked=false;
        document.getElementById('aporticado').checked=false;
        document.getElementById('estu_suelos').checked=false;
        calcula_cotizacion();
        return;
    }

    if (estructural==true) {
        document.getElementById('aport_confinado').style.display='';
        document.getElementById('div_estud_suelos').style.display='';
        // document.getElementById('tot_confinado').value="";
        // document.getElementById('tot_aporticado').value="";
        calcula_cotizacion();     
        return;
    }

    document.getElementById('div_estud_suelos').style.display='none';
    document.getElementById('aport_confinado').style.display='none';
    document.getElementById('tot_confinado').value="";
    document.getElementById('tot_aporticado').value="";
    document.getElementById('confinado').checked=false;
    document.getElementById('aporticado').checked=false;
    document.getElementById('estu_suelos').checked=false;
    calcula_cotizacion();

}

function evento(event='',accion='') {

    if (event.keyCode==13) {

        (accion=='cliente') ? getCliente(): calcula_cotizacion();          

    }
}

function getValores() {

    $.ajax({
        url : 'ajax/ajax_cotizacion.php',
        type : 'POST',
        data : {tipo:'valores'},
        dataType : 'json',
        success : function(json) {
            // console.log(json);
            if(json.status=='success'){
                document.getElementById('tot_confinado').value=json.result[0]['valor_confinado'];                
                document.getElementById('tot_aporticado').value=json.result[0]['valor_aporticado'];                
                document.getElementById('tot_proyecto').value=json.result[0]['valor_arquite'];
                document.getElementById('vlr_proyecto').value=json.result[0]['valor_proyecto'];

                document.getElementById('valor_phorizontal').value=json.result[0]['valor_prohori'];
                document.getElementById('valor_levanarqui').value=json.result[0]['valor_levant'];
                document.getElementById('valor_suelos').value=json.result[0]['valor_suelos'];  

                document.getElementById('valor_tradicion').value=json.result[0]['valor_tradicion'];                
                document.getElementById('valor_curaduria').value=json.result[0]['valor_curaduria'];                
                document.getElementById('valor_carta_vecino').value=json.result[0]['valor_vecinos'];      

            }
            if(json.status=='error'){
                
                document.getElementById('tot_confinado').value=0;                
                document.getElementById('tot_aporticado').value=0;
                document.getElementById('tot_proyecto').value=0;
                document.getElementById('vlr_proyecto').value=0;

                document.getElementById('valor_phorizontal').value=0;
                document.getElementById('valor_levanarqui').value=0;
                document.getElementById('valor_suelos').value=0; 

                document.getElementById('valor_tradicion').value=0;                
                document.getElementById('valor_curaduria').value=0;                
                document.getElementById('valor_carta_vecino').value=0;

            }
        }
    });
    
}

function getCliente() {
    let cedula = document.getElementById('cli_cedula').value;
    $.ajax({
        url : 'ajax/ajax_cotizacion.php',
        type : 'POST',
        data : {tipo:'cliente',cedula:cedula},
        dataType : 'json',
        success : function(json) {

            if(json.status=='success'){
                document.getElementById('cli_nombre').value             =json.result[0]['cli_nombre'];                
                document.getElementById('cli_telefono').value           =json.result[0]['cli_telefono'];                
                document.getElementById('cli_email').value              =json.result[0]['cli_email'];
                document.getElementById('cli_direccion').value          =json.result[0]['cli_direccion'];
                document.getElementById('cli_barrio').value             =json.result[0]['cli_barrio'];
                document.getElementById('departamento').value           =json.result[0]['cli_depart'];
                document.getElementById('ciudad').innerHTML             =`<option value="${json.result[0]['ciudad']}">${json.result[0]['nombre_ciudad']}</option>`;  
                document.getElementById('cliente_existe').value         ="true";
            }

            if(json.status=='error'){    
                document.getElementById('ciudad').innerHTML                 ="";            
                document.getElementById('cli_nombre').value                 ='';
                document.getElementById('cli_telefono').value               ='';
                document.getElementById('cli_email').value                  ='';
                document.getElementById('cli_direccion').value              ='';
                document.getElementById('cli_barrio').value                 ='';
                document.getElementById('departamento').value               ='';
                document.getElementById('ciudad').value                     ='';
                document.getElementById('cliente_existe').value             ="false";
            }
        }
    });
    
}

function calcula_cotizacion() {
    getValores();    

    let reconocimiento  = document.getElementById('reconocimiento').checked;
    let obra_nueva      = document.getElementById('obra_nueva').checked;
    let numero_pisos    = document.getElementById('numero_pisos').value;
    let pro_horizon     = document.getElementById('pro_horizon').checked;
    let leva_arqui      = document.getElementById('leva_arqui').checked;
    let estu_suelos     = document.getElementById('estu_suelos').checked;
    let medidas         = document.getElementById('medidas').value;
    let metros_m2       = document.getElementById('metros_m2').value;
    let ancho           = document.getElementById('ancho').value;
    let fondo           = document.getElementById('fondo').value;
    let descuento       = document.getElementById('descuento').value;
    
    let valor_phorizontal   = document.getElementById('valor_phorizontal').value;
    let valor_levanarqui    = document.getElementById('valor_levanarqui').value;
    let valor_suelos        = document.getElementById('valor_suelos').value;
  
    let tot_confinado       = document.getElementById('tot_confinado').value;                
    let tot_aporticado      = document.getElementById('tot_aporticado').value;
    let tot_proyecto        = document.getElementById('tot_proyecto').value;
    let vlr_proyecto        = document.getElementById('vlr_proyecto').value;
    let arquitectonico      = document.getElementById('arquitectonico').checked;
    let estructural      = document.getElementById('estructural').checked;
    let confinado           = document.getElementById('confinado').checked;
    let aporticado          = document.getElementById('aporticado').checked;
    
    let metros_cuadrados=0;
    let sub_valor=0;
    let valor_total=0;
    let valor_confinado=0;
    let valor_aporticado=0;

    var valido_check=validaCheck(reconocimiento,obra_nueva);
    let proyecto_basico     = 0;
    let proyecto_compuesto =0;
    let valor_arqui=0;
    let valor_phori=0;

    if (valido_check) {    

        metros_cuadrados= (medidas == 'ancho - fondo') ? ancho * fondo : metros_m2;
        
        proyecto_basico     =((arquitectonico==true  && numero_pisos==1 ) || (estructural==true  && numero_pisos==1) || (estructural==true  && numero_pisos==1 && arquitectonico==true) ) ? parseInt(vlr_proyecto) : 0;
        proyecto_compuesto  = (arquitectonico==true && numero_pisos>1) ? parseInt(tot_proyecto) : 0;
        
        // console.log('confinado '+confinado);
        valor_confinado  =(confinado)        ? parseInt(tot_confinado)           : 0;
        valor_aporticado =(aporticado)       ? parseInt(tot_aporticado)          : 0;

        // valor_confinado  =(isNaN(valor_confinado.NaN))        ? 0              : valor_confinado;
        // valor_aporticado =(isNaN(valor_aporticado.NaN) )       ? 0              : valor_aporticado;
        valor_phori     =(pro_horizon)      ? parseInt(valor_phorizontal)   : 0;
        valor_arqui     =(leva_arqui)       ? parseInt(valor_levanarqui)    : 0;
        valor_suelos    =(estu_suelos)      ? parseInt(valor_suelos)        : 0;
    
        sub_valor = (numero_pisos>0 && reconocimiento==true) ? (metros_cuadrados * numero_pisos):0;
        sub_valor += (numero_pisos>0 && obra_nueva==true) ? (metros_cuadrados * numero_pisos) :0;
        sub_valor += (sub_valor==0 ) ? (metros_cuadrados * numero_pisos) :0;

        console.log(`(${sub_valor} * (${proyecto_compuesto}+  ${valor_confinado} +  ${valor_phori}+  ${valor_arqui}+  ${valor_aporticado})) + ${valor_suelos} +${proyecto_basico}`);
               
        valor_total= (sub_valor * (proyecto_compuesto+valor_confinado+valor_phori+valor_arqui+valor_aporticado))+valor_suelos +proyecto_basico;        
        
        if (descuento !='')  { valor_total= (valor_total - (valor_total* (parseInt(descuento) /100) ) ) ;}
        // console.log(`descuento  ${(valor_total* (parseInt(descuento) /100) )} valor total ${valor_total}`);
    }
    
    document.getElementById('tot_proyecto').value=proyecto_basico+proyecto_compuesto;

    document.getElementById('label_valortot').innerHTML= new Intl.NumberFormat().format(valor_total);

    document.getElementById('valor_total').value=valor_total;

    document.getElementById('total_medidas').value=metros_cuadrados;
}

function validaCheck(reconocimiento,obra_nueva) {
    
    if (obra_nueva===true && reconocimiento===true) {
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'Lo sentimos',
            text:'solo puedes escoger reconocimiento o obras nuevas',
            showConfirmButton: false,
            timer: 1500
          }); 
        document.getElementById('obra_nueva').checked=false;
        document.getElementById('reconocimiento').checked=false;
        document.getElementById('numero_pisos').value='';
        calcula_cotizacion();
        return false;
    }

    if (reconocimiento===true ) {       
        document.getElementById('obra_nueva').checked=false;
        return true;
    }
    
    
    if (obra_nueva===true ) {       
        document.getElementById('reconocimiento').checked=false;
        return true;
    }

    return true;
}

function getMunicipio(depart) {
    $.ajax({
        url : 'ajax/ajax_cotizacion.php',
        type : 'POST',
        data : {tipo:'ciudad',depart:depart},
        dataType : 'json',
        success : function(json) {
            // console.log(json);
            if(json.status=='success'){
                $("#ciudad").empty();
                var option="<option value=''>-</option>"
                json.result.forEach(element => {
                    option+=`<option value='${element.id_municipio}'>${element.municipio}</option>`;
                });
                $( "#ciudad" ).append(option);
            }
            if(json.status=='error'){
                $("#ciudad").empty();
                option="<option value=''>Seleccion invalida</option>"
                $( "#ciudad" ).append(option);
            }
        },beforeSend: function(){
            $("#ciudad").val('Validando...')
        }
    });
}

function validaForma(event) {
    event.preventDefault();
    let result=false;
    var forma_cotiza= document.getElementById('forma_cotiza');    

    result=valida_tipo();
    if (!result) return;    
    result= valida_campos('total_medidas','Debes llenar los metro cuadrados');
    if (!result) return;
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

    if  ( document.getElementById('arquitectonico').checked==false &&  document.getElementById('estructural').checked==false && document.getElementById('pro_horizon').checked==false ) {
        
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: `Debes seleccionar arquitectonico o estructural`,
            showConfirmButton: false,
            timer: 1500
            });
                
        return;
        
    }
 
    if (result) forma_cotiza.submit();

}

function valida_proyecto(event) {
    event.preventDefault();

    let result=false;
    var forma_proyecto= document.getElementById('forma_proyecto');  

    if (document.getElementById('pro_foto1').value!='') {        
        result=valida_archivo('pro_foto1');
        if (!result) return;
    }
    if (document.getElementById('pro_foto2').value!='') {        
        result=valida_archivo('pro_foto2');
        if (!result) return;
    }
    if (document.getElementById('pro_foto3').value!='') {        
        result=valida_archivo('pro_foto3');
        if (!result) return;
    }
    if (document.getElementById('pro_foto4').value!='') {        
        result=valida_archivo('pro_foto4');
        if (!result) return;
    }
    if (document.getElementById('pro_foto5').value!='') {        
        result=valida_archivo('pro_foto5');
        if (!result) return;
    }
    if (document.getElementById('pro_foto6').value!='') {        
        result=valida_archivo('pro_foto6');
        if (!result) return;
    }

    result= valida_campos('pro_usuario','El campo de asignado no puede estar vacio');
    if (!result) return;

    result= valida_campos('pro_estimado','La fecha de estmación no puede estar vacio');
    if (!result) return;
    
 
    if (result) forma_proyecto.submit();
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

function valida_tipo() {

    let reconocimiento = document.getElementById('reconocimiento').checked;
    let obra_nueva = document.getElementById('obra_nueva').checked;
    let confinado = document.getElementById('confinado').checked;
    let aporticado = document.getElementById('aporticado').checked;
    let estructural = document.getElementById('estructural').checked;
    let pro_horizon = document.getElementById('pro_horizon').checked;

    let entro = true;
    if (pro_horizon===false) {        
        if (!reconocimiento && !obra_nueva) { 
            Swal.fire({
                position: 'top-end',
                icon: 'info',
                title: `Los campos de reconocimiento o obra nueva son obligatorios`,
                showConfirmButton: false,
                timer: 1500
              });
            return entro=false;
        }
    
        if (estructural) {        
            if ( !confinado && !aporticado) { 
                Swal.fire({
                    position: 'top-end',
                    icon: 'info',
                    title: `Los campos de confinado o aporticado son obligatorios`,
                    showConfirmButton: false,
                    timer: 1500
                  });
                return entro=false;
            }
        }
    }
    

    return entro;
}

function buscar(tipo) {

    if( document.getElementById('nombre_pro')) var pro_nombre  = document.getElementById('nombre_pro').value;
    if( document.getElementById('fecha_ini')) var fecha_ini   = document.getElementById('fecha_ini').value;
    if( document.getElementById('fecha_fin')) var fecha_fin   = document.getElementById('fecha_fin').value;
    if( document.getElementById('limite')) var limite      = document.getElementById('limite').value;

    $.ajax({
        url : 'ajax/ajax_cotizacion.php',
        type : 'POST',
        data : {tipo:tipo,pro_nombre:pro_nombre,fecha_ini:fecha_ini,fecha_fin:fecha_fin,limite:limite},
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

function pluginDataTable(id) {
    
    $(`#${id}`).DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo(`#${id}_wrapper .col-md-6:eq(0)`);
}

function llenarTabla(result) {

    $("#body_cotiza").empty();

    var btn_delete="danger";
    var name_delete="Inactivo";

    result.forEach(element => {

        btn_delete=(element.cot_estado==0)? "danger" : "success"; 
        name_delete=(element.cot_estado==0)? "Inactivo" : "Activo"; 

        var tab ="<tr>";
        tab +="<td>"+element.cot_nombre+"</td>";
        tab +="<td>"+element.cot_tipo+"</td>";
        tab +="<td>"+element.cot_metro2+" m2 </td>";
        tab +="<td>"+element.cot_cliente +" - "+ element.cli_nombre +"</td>";
        tab +="<td>"+element.fecha +"</td>";
        tab +="<td><a href='vistas/pdf/generados/cotizacion_"+element.cot_nombre+".pdf' download class='btn btn-"+btn_delete+"'>PDF</a></td>";
        tab +="<td><button type='button' class='btn btn-warning' data-toggle='modal' data-target='#modal_proyecto' onclick='pasarProyecto("+element.cot_id+",\""+element.cot_nombre+"\",\""+element.cot_cliente+"\");' >Ejecutar</button></td>";
        tab +="</tr>";
    
        $( "#body_cotiza" ).append(tab);
    });

}

function pasarProyecto(codigo,nombre,cedula) {
    // alert(nombre);
    document.getElementById('nombre_archivo').value=cedula;
    document.getElementById('id_cotizacion').value=codigo;    
    document.getElementById('pro_nombre').value=nombre;
    document.getElementById('pro_nombre').readOnly=true;
}

function valida_archivo(id) {

    var fileInput = document.getElementById(id);
    var filePath = fileInput.value;
    var allowedExtensions = /(.jpg|.jpeg|.png|.gif)$/i;

    if(!allowedExtensions.exec(filePath)){

        Swal.fire({
            icon: 'info',
            title: `Por favor, los campos con foto cargar con alguna de las extensiones .jpeg/.jpg/.png/`,
            showConfirmButton: true
          });

        fileInput.value = '';
        return false;
    }
    return true;
    
}

function cleanBusqueda() {
    document.getElementById('nombre_pro').value='';
    document.getElementById('fecha_ini').value='';
    document.getElementById('fecha_fin').value='';
}
