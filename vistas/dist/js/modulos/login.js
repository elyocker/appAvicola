$( document ).ready(function() {
    buscar('buscar');    
});

function buscar(tipo) {

    if(document.getElementById('nombre_filtro'))  var nombre= document.getElementById('nombre_filtro').value;

    $.ajax({
        url : 'ajax/ajax_login.php',
        type : 'POST',
        data : {tipo:tipo,nombre:nombre},
        dataType : 'json',
        success : function(json) {
            console.log(json);
            if(json.status=='success'){
                llenarDatos(json.result);
            }
            if(json.status=='error'){
                
            }
        }

    });
}

function llenarDatos(result) {
    $("#body_consulta").empty();

    result.forEach(element => {
        var table =`<tr>`;
        table +=`<td>${element.pro_nombre}</td>`;
        table +=`<td>${element.direccion}</td>`;
        table +=`<td><span class='badge badge-success'>${element.estado}</span></td>`;
        table +=`<td>${element.fecha}</td>`;
        table +=`<td><a href='vistas/pdf/generados/cotizacion_${element.pro_nombre}.pdf' download class='btn btn-danger'>PDF</a></td>`;
        table +=`</tr>`;
        $( "#body_consulta" ).append(table);
    });
}

function clean_consulta() {
    document.getElementById('nombre_filtro').value='';
    $("#body_consulta").empty();

}