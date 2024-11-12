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

    $bal_nombre     = isset($_REQUEST['bal_nombre'])? $_REQUEST['bal_nombre']:'';
    $fecha_ini      = isset($_REQUEST['fecha_ini'])? $_REQUEST['fecha_ini']:'';
    $fecha_fin      = isset($_REQUEST['fecha_fin'])? $_REQUEST['fecha_fin']:'';
    $limite         = isset($_REQUEST['limite'])? $_REQUEST['limite']:100;
  
    if($bal_nombre!='') $where.=" AND cot_nombre LIKE '%$bal_nombre%' ";

    $where.= ($fecha_ini!='' && $fecha_fin!='') ? " AND bal_fechac BETWEEN '$fecha_ini' AND '$fecha_fin' ": ($fecha_ini!='' ? " AND bal_fechac = '$fecha_ini' ": "" ) ;

    $sql  = "SELECT 
                b.bal_id,
                c.cot_nombre,
                b.bal_proveedor,
                b.bal_ingresos,
                b.bal_total,
                b.bal_sesenta,
                b.bal_porcentaje,
                b.bal_cuarenta,
                u.usu_nombre AS usuario,
                CONCAT(b.bal_fechac,' ',b.bal_horac) AS fecha,
                b.bal_deuda ,
                b.bal_estado
            FROM balance b
            LEFT JOIN cotizacion c ON (c.cot_id=b.bal_cotizacion) 
            LEFT JOIN usuario u ON (u.usu_codigo=b.bal_usuc) 
            WHERE  $where
            LIMIT $limite";  
    
    $resp = $detalle->getDatos($sql);

    $tot_provee  =0;
    $tot_ingresos  =0;
    $tot_valor  =0;
    $tot_deber  =0;

    for ($i=0; $i < sizeof($resp) ; $i++) {  

        $tot_provee  +=$resp[$i]['bal_proveedor'];
        $tot_ingresos  +=$resp[$i]['bal_ingresos'];
        $tot_valor  +=$resp[$i]['bal_total'];
        $tot_deber  +=$resp[$i]['bal_deuda'];

        $resp[$i]['bal_proveedor']      =number_format($resp[$i]['bal_proveedor'],0);
        $resp[$i]['bal_ingresos']       =number_format($resp[$i]['bal_ingresos'],0);
        $resp[$i]['bal_total']          =number_format($resp[$i]['bal_total'],0);
        $resp[$i]['bal_sesenta']        =number_format($resp[$i]['bal_sesenta'],0);
        $resp[$i]['bal_cuarenta']       =number_format($resp[$i]['bal_cuarenta'],0);
        $resp[$i]['bal_deuda']          =number_format($resp[$i]['bal_deuda'],0);
    }
    
    $detalle->close();

    if ($resp!='') {
        $respues= array(
            "status"=>"success",
            "result"=>$resp,
            "totales"=>array(
                "tot_provee"=>$tot_provee,
                "tot_ingresos"=>$tot_ingresos,
                "tot_valor"=>$tot_valor ,
                "tot_deber"=>$tot_deber 
            )
        );
    }else {
        $respues= array(
            "status"=>"error",
            "result"=>"No hay registros",
            "totales"=>array(
                "tot_provee"=>$tot_provee,
                "tot_ingresos"=>$tot_ingresos,
                "tot_valor"=>$tot_valor,
                "tot_deber"=>$tot_deber 
            )
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
                    pro_estado <> '2' AND 
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