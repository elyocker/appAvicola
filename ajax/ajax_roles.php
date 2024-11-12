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

    case 'unicrol':
        unicrol();
        break;
        
    default:
        buscar();
        break;
}

function Buscar(){       
      
    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);
    $where="1=1";
   
    $sql  = "SELECT r.rol_id,
                r.rol_nombre ,
                r.rol_estado 
            FROM roles r WHERE $where ";  
    
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

function unicrol(){
    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

    $rol     = isset($_REQUEST['rol'])  ? $_REQUEST['rol']        : '';

    $where="1=1";    
    if ($rol!='' ) $where.=" AND  rol_nombre ='$rol' ";

    $sql  = "SELECT rol_nombre FROM roles
            WHERE $where ";    
    $result = $detalle->getDatos($sql);

    $detalle->close();

    if ($result) {
        $respues= array(
            "status"=>"success",
            "msj"=>"El rol ya existe, intenta con otro"
        );
    }else {
        $respues= array(
            "status"=>"error",
            "msj"=>"no hay problema "
        );
    }

    echo json_encode($respues);
}


?>