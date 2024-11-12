$( document ).ready(function() {
    
    buscar('buscar');    
    
});


function buscar(tipo) {

    if(document.getElementById('bal_nombre')) var bal_nombre =document.getElementById('bal_nombre').value;
    if(document.getElementById('fecha_ini')) var fecha_ini =document.getElementById('fecha_ini').value;
    if(document.getElementById('fecha_fin')) var fecha_fin =document.getElementById('fecha_fin').value;
    if(document.getElementById('limite')) var limite =document.getElementById('limite').value;
    $("#body_balance").empty();

        // $(`#body_balance`).DataTable({  paging: false,searching: false });

    $.ajax({
        url : 'ajax/ajax_balance.php',
        type : 'POST',
        data : {tipo:tipo,bal_nombre:bal_nombre,fecha_ini:fecha_ini,fecha_fin:fecha_fin,limite:limite},
        dataType : 'json',
        success : function(json) {
            console.log(json);
            if(json.status=='success'){
                
                llenarTabla(json.result,json.totales);
                pluginDataTable('table_balance');
            }
            if(json.status=='error'){
                
            }
        }
    });
}

function llenarTabla(result,totales) {

    // new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 }).format(number)

    
    let tot_proveedor =totales['tot_provee'].toLocaleString('es-MX');
    let tot_ingresos =totales['tot_ingresos'].toLocaleString('es-MX');
    let tot_valor =totales['tot_valor'].toLocaleString('es-MX');
    let tot_deber =totales['tot_deber'].toLocaleString('es-MX');

    result.forEach(element => {

        var tab =`<tr>`;
        tab +=`<td>${element.bal_id}</td>`;
        tab +=`<td>${element.cot_nombre}</td>`;
        tab +=`<td>$ ${element.bal_deuda}</td>`;
        tab +=`<td><small class="text-success mr-1"><i class="fas fa-arrow-up"></i> $ </small>  ${element.bal_proveedor}</td>`;
        tab +=`<td><small class="text-success mr-1"><i class="fas fa-arrow-up"></i> $ </small>  ${element.bal_ingresos}</td>`;
        tab +=`<td><small class="text-success mr-1"><i class="fas fa-arrow-up"></i> ${element.bal_porcentaje}% </small></td>`;
        tab +=`<td><small class="text-success mr-1"><i class="fas fa-arrow-up"></i> $ </small>  ${element.bal_sesenta}</td>`;
        tab +=`<td><small class="text-success mr-1"><i class="fas fa-arrow-up"></i> $ </small>  ${element.bal_cuarenta}</td>`;
        tab +=`<td>${element.fecha}</td>`;
        tab +=`<td>${element.bal_estado}</td>`;
        tab +=`<td><small class="text-success mr-1"><i class="fas fa-arrow-up"></i> $ </small> ${element.bal_total}</td>`;
    
        tab +=`</tr>`;
    
        $( "#body_balance" ).append(tab);

    });
    
    $("#foot_balance").empty();

    var foote =`<tr>`;
    
    foote +=`<td></td>`;
    foote +=`<td><label>TOTALES</label></td>`;
    foote +=`<td><label>$ ${tot_deber}</label> </td>`;
    foote +=`<td><label>$ ${tot_proveedor}</label> </td>`;
    foote +=`<td> <label>$ ${tot_ingresos}</label></td>`;
    foote +=`<td></td>`;
    foote +=`<td></td>`;
    foote +=`<td></td>`;
    foote +=`<td></td>`;
    foote +=`<td></td>`;
    foote +=`<td><label>$ ${tot_valor}</label> </td>`;

    foote +=`</tr>`;
    $( "#foot_balance" ).append(foote);
}



function cleanBalance() {
    document.getElementById('fecha_fin').value='';
    document.getElementById('fecha_ini').value='';
    document.getElementById('bal_nombre').value='';
}

function pluginDataTable(id) {
    
    $(`#${id}`).DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo(`#${id}_wrapper .col-md-6:eq(0)`);
}