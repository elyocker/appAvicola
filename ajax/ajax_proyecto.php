<?php
include_once "../modelo/conexion.php";
session_start();

$tipo = isset($_REQUEST['tipo'])? $_REQUEST['tipo']:'';

switch ($tipo) {
    case 'buscar':
        buscar();
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
        buscar();
        break;
}

function Buscar(){       
      
    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);
    $where="1=1";

    $pro_nombre     = isset($_REQUEST['pro_nombre'])? $_REQUEST['pro_nombre']:'';
    $fecha_ini      = isset($_REQUEST['fecha_ini'])? $_REQUEST['fecha_ini']:'';
    $fecha_fin      = isset($_REQUEST['fecha_fin'])? $_REQUEST['fecha_fin']:'';
    $limite         = isset($_REQUEST['limite'])? $_REQUEST['limite']:100;
    $pro_asignado   = isset($_REQUEST['pro_asignado'])? $_REQUEST['pro_asignado']:'';
    $pro_estado   = isset($_REQUEST['pro_estado'])? $_REQUEST['pro_estado']:'';    
    $pro_codigo   = isset($_REQUEST['pro_codigo'])? $_REQUEST['pro_codigo']:'';    
    
    $where ="1=1 ";

    if($pro_nombre!='') $where.=" AND pro_nombre LIKE '%$pro_nombre%' ";

    $where.= ($fecha_ini!='' && $fecha_fin!='') ? " AND pro_fechac BETWEEN '$fecha_ini' AND '$fecha_fin' ": ($fecha_ini!='' ? " AND pro_fechac = '$fecha_ini' ": "" ) ;

    $where.=($_SESSION['rol']!='admin' && $_SESSION['rol'] !='Secretaria') ? " AND p.pro_usuario='".$_SESSION['usu_codigo']."' " :( $pro_asignado !='' ? " AND p.pro_usuario='$pro_asignado' ": "");

    $where.=($pro_estado!='') ? " AND  pro_estado='$pro_estado'" : "";
    $where.=($pro_codigo!='') ? " AND  pro_codigo='$pro_codigo'" : "";


    $sql  = "SELECT 
                pro_codigo,
                pro_nombre,
                pro_cotizacion,
                pro_estado,
                CONCAT(u.usu_nombre, ' ', u.usu_apellido)  as nombre_usuario,
                pro_estimado,
                CASE WHEN pro_fechaini is null THEN '-' ELSE pro_fechaini END AS pro_fechaini,
                CASE WHEN pro_fechafin is null THEN '-' ELSE pro_fechafin END AS pro_fechafin,
                cl.cli_barrio
            FROM proyecto p
            LEFT JOIN usuario u ON (u.usu_codigo=p.pro_usuario)
            LEFT JOIN cotizacion c ON (c.cot_id=p.pro_cotizacion)
            LEFT JOIN cliente cl ON (cl.cli_cedula=c.cot_cliente)
            WHERE  $where
            GROUP BY  pro_codigo,
                pro_nombre,
                pro_cotizacion,
                pro_estado,
                u.usu_nombre,  
			    u.usu_apellido,
                p.pro_estimado,
                p.pro_fechaini ,
                p.pro_fechafin ,
                cl.cli_barrio
            LIMIT $limite";  
            // echo '<pre>';
            // print_r($sql);
            // echo '</pre>';
    
    $resp = $detalle->getDatos($sql);
    
    $detalle->close();

    if ($resp!='') {
        $respues= array(
            "status"=>"success",
            "result"=>$resp
        );
    }else {
        $respues= array(
            "status"=>"error",
            "result"=>"No hay registros"
        );
    }

    echo json_encode($respues);
}

function editar(){
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
                        r.rol_nombre as estado_usuario,
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
                    LEFT JOIN roles r ON (r.rol_id=u.usu_rol)
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

function descripcion(){

    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

    $codigo                 = isset($_REQUEST['codigo'])            ? $_REQUEST['codigo']               : '';
    $text_descripcion       = isset($_REQUEST['text_descripcion'])  ? $_REQUEST['text_descripcion']     : '';

    $usuario = $_SESSION['usu_codigo'];

    $result=array(); 
    if ($text_descripcion!='') {
        
        $sql  = "   INSERT INTO descripcion
                    (
                        pro_codigo,
                        des_text,
                        des_usuario,
                        des_fechac,
                        des_horac
                    )
                    VALUES
                    (
                        '$codigo',
                        '$text_descripcion',
                        '$usuario',
                        current_date,
                        current_time
                    ) 
                    "; 
    
        $result = $detalle->insert($sql);
    }

    $detalle->close();
    
    if ($result) {

        $respues= array(
            "status"=>"success",
            "result"=>$result
        );

    }else {

        $respues= array(
            "status"=>"error",
            "result"=>$result
        );
    }

    echo json_encode($respues);
}

function getDescrip(){

    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

    $codigo     = isset($_REQUEST['codigo'])  ? $_REQUEST['codigo']   : '';

    $sql  = "   SELECT 
                    pro_codigo,
                    des_usuario,
                    des_text,
                    CONCAT(u.usu_nombre, ' ', u.usu_apellido)  as nombre_usuario,
                    u.usu_foto AS foto , 
                    des_fechac,
                    des_horac                        
                FROM descripcion d
                LEFT JOIN usuario u ON (u.usu_codigo=d.des_usuario)
                WHERE  1=1 and d.pro_codigo='$codigo' "; 

    $result = $detalle->getDatos($sql);

    $detalle->close();

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

function alerta(){

    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

    $codigo     = $_SESSION['usu_codigo'];

    $sql  = "SELECT 
                pro_codigo,
                pro_nombre,
                pro_cotizacion,
                CONCAT('Proyecto: ',pro_nombre, ' - Fecha: ', pro_estimado) as mensaje
            FROM proyecto 
            WHERE   pro_estimado <= current_date AND 
                    pro_estado not in ('2','3') AND 
                    pro_usuario='$codigo' 
            ORDER BY pro_estimado ASC"; 

            // echo '<pre>';
            // print_r($sql);
            // echo '</pre>';

    $result = $detalle->getDatos($sql);

    $detalle->close();

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