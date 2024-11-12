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

    case 'getcliente':
        getcliente();
        break;
        
    default:
        buscar();
        break;
}

function Buscar(){       
      
    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);
    
    $where="1=1";
   
    $sql="SELECT c.cli_nombre,
                c.cli_id,
                c.cli_cedula,
                c.cli_telefono,
                c.cli_depart,
                d.departamento,
                c.cli_ciudad,
                m.municipio,
                c.cli_email,
                c.cli_estado
            FROM cliente c
                LEFT JOIN departamentos d ON (d.id_departamento=c.cli_depart)
                LEFT JOIN municipios m ON (m.id_municipio=c.cli_ciudad)
            WHERE $where
            ORDER BY c.cli_nombre";
    
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
    if ($codigo!='' ) $where.=" AND  cli_id ='$codigo' ";


    $sql  = "DELETE FROM cliente
            WHERE $where ";    
    $resp = $detalle->insert($sql);

    $detalle->close();

    if ($resp=='ok') {
        $respues= array(
            "status"=>"success",
            "title"=>"Excelente",
            "msj"=>"El cliente se elimino correctamente"
        );
    }else {
        $respues= array(
            "status"=>"error",
            "title"=>"Lo sentimos",
            "msj"=>"Hubo un problema al eliminar el cliente"
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
        
        $sql  = "   SELECT c.cli_cedula              
                    FROM cliente  c
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

function getcliente(){
    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

    $codigo     = isset($_REQUEST['codigo'])  ? $_REQUEST['codigo']   : '';

    $result=array(); 

    if ($codigo!='' ) {
        
        $sql  = "   SELECT c.cli_nombre,
                        c.cli_id,
                        c.cli_cedula,
                        c.cli_telefono,
                        c.cli_depart,
                        d.departamento,
                        c.cli_ciudad,
                        m.municipio,
                        c.cli_email,
                        c.cli_estado,
                        cli_barrio,
                        cli_direccion,
                        cli_ciudad,
                        cli_depart
                    FROM cliente c
                        LEFT JOIN departamentos d ON (d.id_departamento=c.cli_depart)
                        LEFT JOIN municipios m ON (m.id_municipio=c.cli_ciudad)
                    WHERE 1=1 AND c.cli_id='$codigo'      
                     ";    
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