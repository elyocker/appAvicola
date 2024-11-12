<?php
include_once "../modelo/conexion.php";
session_start();

$tipo = isset($_REQUEST['tipo'])? $_REQUEST['tipo']:'';

switch ($tipo) {
    case 'buscar':
        buscar();
        break;
    
    case 'delete':
        delete();
        break;
    case 'estado':
        estado();
        break;

    case 'ciudad':
        ciudad();
        break;

    case 'valores':
        valores();
        break; 

    case 'cliente':
        cliente();
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
    $limite         = isset($_REQUEST['limite'])? $_REQUEST['limite']:10;

    $where ="1=1 AND cot_estado='0' ";

    if($pro_nombre!='') $where.=" AND cot_nombre LIKE '%$pro_nombre%' ";

    $where.= ($fecha_ini!='' && $fecha_fin!='') ? " AND cot_fechac BETWEEN '$fecha_ini' AND '$fecha_fin' ": ($fecha_ini!='' ? " AND cot_fechac = '$fecha_ini' ": "" ) ;
   
    $sql  = "SELECT 
                cot_id,
                cot_tipo,
                cot_metro2,
                cot_valortot,
                cot_estado,
                cot_cliente,
                c.cli_nombre,
		        cot_nombre,
                CONCAT(cot_fechac,' ',cot_horac) as fecha
            FROM cotizacion 
            LEFT JOIN cliente c ON (c.cli_cedula=cot_cliente)
            WHERE  $where 
            ORDER BY cot_fechac,cot_horac desc
            LIMIT $limite
            ";  
    
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

function delete(){
    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

    $codigo     = isset($_REQUEST['codigo'])        ?$_REQUEST['codigo']        : '';

    $where="1=1";    
    if ($codigo!='' ) $where.=" AND  rol_id ='$codigo' ";


    $sql  = "DELETE FROM roles
            WHERE $where ";    
    $resp = $detalle->insert($sql);

    $detalle->close();

    if ($resp=='ok') {
        $respues= array(
            "status"=>"success",
            "msj"=>"El rol se elimino correctamente"
        );
    }else {
        $respues= array(
            "status"=>"error",
            "msj"=>"Hubo un problema al eliminar el rol"
        );
    }

    echo json_encode($respues);
}

function estado(){
    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

    $codigo     = isset($_REQUEST['codigo'])        ?$_REQUEST['codigo']        : '';

    $where="1=1";    
    if ($codigo!='' ) $where.=" AND  rol_id ='$codigo' ";

    $sql  = "SELECT rol_estado FROM roles
            WHERE $where ";    
    $result = $detalle->getDatos($sql);

    $cambio_estado = ($result[0]['rol_estado']=='2') ? "rol_estado='1' " : "rol_estado='2' ";

    $sql  = "UPDATE  roles SET $cambio_estado
            WHERE $where ";    
    $resp = $detalle->insert($sql);

    $detalle->close();

    if ($resp=='ok') {
        $respues= array(
            "status"=>"success",
            "msj"=>"El estado del usuario se cambio"
        );
    }else {
        $respues= array(
            "status"=>"error",
            "msj"=>"Hubo un problema al cambiar el estado "
        );
    }

    echo json_encode($respues);
}

function ciudad(){
    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

    $depart     = isset($_REQUEST['depart'])  ? $_REQUEST['depart']        : '';

    $result=array(); 

    if ($depart!='' ) {
        
        $sql  = "SELECT id_municipio, municipio FROM municipios WHERE 1=1  AND  departamento_id ='$depart' ";    
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

function valores(){
    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

    $result=array(); 

    $ano=date('Y');

    $sql  = "SELECT 
                *
            FROM valores_cotizacion 
            WHERE 1=1 AND valor_ano='$ano'  "; 

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

function cliente(){
    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

    $cedula     = isset($_REQUEST['cedula'])  ? $_REQUEST['cedula']   : '';

    $result=array(); 

    if ($cedula!='' ) {
        
        $sql  = "   SELECT c.cli_nombre,
                        c.cli_telefono,
                        c.cli_email,
                        c.cli_direccion,
                        c.cli_barrio,
                        c.cli_depart,
                        c.cli_ciudad,        
                        m.municipio AS nombre_ciudad
                    FROM cliente  c
                    LEFT JOIN municipios m ON (m.id_municipio=c.cli_ciudad)
                    WHERE 1=1 AND c.cli_cedula='$cedula' ";    
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