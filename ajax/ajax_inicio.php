<?php
include_once "../modelo/conexion.php";
session_start();

$tipo = isset($_REQUEST['tipo'])? $_REQUEST['tipo']:'';

switch ($tipo) {
    case 'ganancias':
        ganancias();
        break;
    
    case 'editar':
        editar();
        break;

    case 'descripcion':
        descripcion();
        break;

    case 'getDescrip':
        getDescrip();
        break;

    case 'alerta':
        alerta();
        break;
    default:
        ganancias();
        break;
}

function ganancias(){       
      
    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

    $year= date('Y');
 
    $fecha_fin=  date("Y-m-t", strtotime(date('Y-m-d')));
    $fecha_inicio= date('Y-m-01');

    $sql  = "SELECT 
                0   AS valores,
                valor_gastos 
            FROM  valores_cotizacion
            WHERE  valor_ano ='$year' ";  
    // echo '<pre>';
    // print_r($sql);
    // echo '</pre>';
    $resp_gastos = $detalle->getDatos($sql);

    $consulta  = "SELECT 
                    sum(vlr_valor)  AS valores
                FROM vlr_company 
                WHERE vlr_fechac BETWEEN '$fecha_inicio' AND '$fecha_fin'  "; 
  
    $resp_ingresos = $detalle->getDatos($consulta);
    

    $resultado = ($resp_gastos[0]['valor_gastos'] < $resp_ingresos[0]['valores'] ) ? $resp_ingresos[0]['valores'] - $resp_gastos[0]['valor_gastos']: 0;

    $resp_gastos[0]['valores']= number_format($resultado,0) ;
    $resp_gastos[0]['valor_gastos']= number_format($resp_gastos[0]['valor_gastos'],0) ;
    

    $detalle->close();

    if ($resp_gastos!='' ) {
        $respues= array(
            "status"=>"success",
            "ingresos"=>$resp_gastos[0]['valores'],
            "gastos"=>$resp_gastos[0]['valor_gastos']
        );
    }else {
        $respues= array(
            "status"=>"error",
            "ingresos"=>"No hay registros",
            "gastos"=>"No hay registros"
        );
    }

    echo json_encode($respues);
}

function alerta(){       
      
    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

    $sql  = "SELECT CONCAT(pro_nombre,' ',pro_estimado) AS mensaje
            FROM proyecto 
            WHERE pro_estimado < CURRENT_DATE AND 
            pro_estado NOT IN ('2','3') ";  
            
    $result = $detalle->getDatos($sql);

    

    $detalle->close();

    if ($result!='' ) {
        $respues= array(
            "status"=>"success",
            "mensaje"=>$result
        );
    }else {
        $respues= array(
            "status"=>"error",
            "mensaje"=>"No hay registros"
           
        );
    }

    echo json_encode($respues);
}

?>