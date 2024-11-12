<?php
include_once "../modelo/conexion.php";
session_start();

$tipo = isset($_REQUEST['tipo'])? $_REQUEST['tipo']:'';

switch ($tipo) {
    case 'buscar':
        buscar();
        break;
    
    case 'actualizar':
        actualizar();
        break;

    default:
        buscar();
        break;
}

function Buscar(){       
      
    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

    $where="1=1";


    $sql  = "SELECT 
                *
            FROM valores_cotizacion
            WHERE  $where";  
    
    $resp = $detalle->getDatos($sql);

    $sql  = "SELECT 
                *
            FROM vlr_paramentos
            WHERE  $where";  
    
    $resp_paramentos = $detalle->getDatos($sql);
    
    $detalle->close();

    if ($resp!='') {

        $respues= array(
            "status"=>"success",
            "result"=>$resp,
            "vlr_paramentos"=>$resp_paramentos            
        );

    }else {

        $respues= array(
            "status"=>"error",
            "result"=>"No hay registros",
            "vlr_paramentos"=>"No hay registros"            
        );

    }

    echo json_encode($respues);
}

function actualizar(){
    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

    $codigo     = isset($_REQUEST['codigo'])  ? $_REQUEST['codigo']   : '';

    $result=array(); 

    if ($codigo!='' ) {
        
        $sql  = "   SELECT 
                        pro_codigo,
                        pro_nombre,
                        pro_cotizacion,
                        pro_estado,
                        CONCAT(u.usu_nombre, ' ', u.usu_apellido)  as nombre_usuario,
                        u.usu_codigo,
                        pro_estimado,
                        pro_fechaini,
                        pro_fechafin,
                        CASE WHEN p.pro_descripcion IS NULL THEN '' ELSE  pro_descripcion END AS pro_descripcion ,
                        CASE WHEN p.pro_autocat IS NULL THEN '' ELSE  pro_autocat END AS pro_autocat,
                        CASE WHEN p.pro_certiftradi IS NULL THEN '' ELSE pro_certiftradi END AS pro_certiftradi,
                        CASE WHEN p.pro_escritura IS NULL THEN '' ELSE pro_escritura END AS pro_escritura,
                        CASE WHEN p.pro_fotovaya IS NULL THEN '' ELSE pro_fotovaya END AS pro_fotovaya,
                        CASE WHEN p.pro_impredial IS NULL THEN '' ELSE pro_impredial END AS pro_impredial,
                        CASE WHEN p.pro_otroarch IS NULL THEN '' ELSE pro_otroarch END AS pro_otroarch,
                        CASE WHEN p.pro_foto1 IS NULL THEN '' ELSE pro_foto1 END AS pro_foto1,
                        CASE WHEN p.pro_foto2 IS NULL THEN '' ELSE pro_foto2 END AS pro_foto2,
                        CASE WHEN p.pro_foto3 IS NULL THEN '' ELSE pro_foto3 END AS pro_foto3,
                        CASE WHEN p.pro_foto4 IS NULL THEN '' ELSE pro_foto4 END AS pro_foto4,
                        CASE WHEN p.pro_foto5 IS NULL THEN '' ELSE pro_foto5 END AS pro_foto5,
                        CASE WHEN p.pro_foto6 IS NULL THEN '' ELSE pro_foto6 END AS pro_foto6
                        
                    FROM proyecto p
                    LEFT JOIN usuario u ON (u.usu_codigo=p.pro_usuario)
                    LEFT JOIN cotizacion c ON (c.cot_id=p.pro_cotizacion)
                    LEFT JOIN cliente cl ON (cl.cli_cedula=c.cot_cliente)
                    WHERE  1=1 and pro_codigo='$codigo' "; 

        $result = $detalle->getDatos($sql);

    
        $detalle->close();
    }


    if ($result) {
        $respues= array(
            "status"=>"success",
            "result"=>$result
        );
    }else {
        $respues= array(
            "status"=>"error",
            "result"=>"no hay registros"
        );
    }

    echo json_encode($respues);
}


?>