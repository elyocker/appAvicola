<?php
include_once "../modelo/conexion.php";
include_once "../global.inc";

$tipo = isset($_REQUEST['tipo'])? $_REQUEST['tipo']:'';

switch ($tipo) {
    case 'buscar':
        buscar();
        break;
    
   
    default:
        buscar();
        break;
}

function buscar(){       

    global  $ipConect, $usuConect,$passConect, $proyeConect;

    $detalle = new con_db( $ipConect, $usuConect,$passConect, $proyeConect);
 
    $nombre = isset($_POST['nombre'])? trim($_POST['nombre']) : "" ;

    $result=array();

    if ($nombre !='' ) {    
        
        $sql  = "SELECT  pro_nombre,
                         DATE_ADD(pro_estimado,iNTERVAL 10 DAY) AS fecha,
                    CASE 
                        WHEN pro_estado =0 THEN 'Arquitectonico'
                    WHEN pro_estado =1 THEN 'Estrutural'
                    WHEN pro_estado =2 THEN 'Radicacion'
                    WHEN pro_estado =3 THEN 'Finalizado'
                    ELSE ''
                    END AS estado,
                    
                    CONCAT(cl.cli_direccion,' ',m.municipio,', ',d.departamento) AS direccion
                    
                FROM proyecto p
                LEFT JOIN cotizacion c ON (c.cot_id=p.pro_cotizacion)
                LEFT JOIN cliente cl ON (cl.cli_cedula=c.cot_cliente)
                LEFT JOIN municipios m ON (m.id_municipio =cl.cli_ciudad)
                LEFT JOIN departamentos d ON (d.id_departamento =cl.cli_depart)
                WHERE 1=1 and p.pro_nombre LIKE '%$nombre%' and pro_estado<>'3'";  
                
        $result = $detalle->getDatos($sql);
    }

    

    $detalle->close();

    if ($result!='' ) {
        $respues= array(
            "status"=>"success",
            "result"=>$result
        );
    }else {
        $respues= array(
            "status"=>"error",
            "result"=>"No hay registros"
        );
    }

    echo json_encode($respues);
}

?>