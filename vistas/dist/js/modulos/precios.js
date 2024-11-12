$( document ).ready(function() {
    buscar('buscar');    
    
});


function buscar(tipo) {
    
    $.ajax({
        url : 'ajax/ajax_precios.php',
        type : 'POST',
        data : {tipo:tipo},
        dataType : 'json',
        success : function(json) {

            // console.log(json);
            if(json.status=='success'){

                document.getElementById('vlr_arquitectonico').value= json.result[0]['valor_arquite'];
                document.getElementById('vlr_proyecto').value= json.result[0]['valor_proyecto'];
                document.getElementById('vlr_prohori').value= json.result[0]['valor_prohori'];
                document.getElementById('vlr_levanarqui').value= json.result[0]['valor_levant'];
                document.getElementById('vlr_suelos').value= json.result[0]['valor_suelos'];
                document.getElementById('vlr_gastos').value= json.result[0]['valor_gastos'];
                document.getElementById('vlr_tradicion').value= json.result[0]['valor_tradicion'];
                document.getElementById('vlr_vecinos').value= json.result[0]['valor_vecinos'];
                document.getElementById('vlr_confinado').value= json.result[0]['valor_aporticado'];
                document.getElementById('vlr_aporticado').value= json.result[0]['valor_confinado'];
                document.getElementById('id').value= json.result[0]['valor_id'];


                $("#body_precios").empty();
                var i =0;
                json.vlr_paramentos.forEach(element => {
                    var table = `<tr>`;
                    table += `<td><input type="text" class="form-control" id="vlr_rangoini_${i}" name="vlr_rangoini_${i}" value="${element.vlr_rangoini}"> </td>`;
                    table += `<td><input type="text" class="form-control" id="vlr_rangofin_${i}" name="vlr_rangofin_${i}" value="${element.vlr_rangofin}"> </td>`;
                    table += `<td><input type="text" class="form-control" id="vlr_valor_${i}" name="vlr_valor_${i}" value="${element.vlr_valor}"> </td>`;
                    table += `<td><input type="text" class="form-control" id="vlr_estampilla_${i}" name="vlr_estampilla_${i}" value="${element.vlr_estampilla}"> </td>`;
                    table += `</tr>`;
                    $( "#body_precios" ).append(table);
                    i++;
                });
            }
            if(json.status=='error'){
                
            }
        }
    });

}