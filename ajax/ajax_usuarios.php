<?php
include_once "../modelo/conexion.php";
session_start();

$tipo = isset($_REQUEST['tipo'])? $_REQUEST['tipo']:'';

switch ($tipo) {
    case 'buscar':
        buscar();
        break;
    case 'update':
        update();
        break;
    case 'delete':
        delete();
        break;
    case 'estado':
        estado();
        break;
    case 'unico_usu':
        unico_usu();
        break;
        
    default:
        buscar();
        break;
}

function Buscar(){       
      
    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

    $usu_cedula     = isset($_REQUEST['usu_cedula'])        ?$_REQUEST['usu_cedula']        : '';
    $usu_nombre     = isset($_REQUEST['usu_nombre'])        ?$_REQUEST['usu_nombre']        : '';
    $fecha_inicio   = isset($_REQUEST['fecha_inicio'])      ?$_REQUEST['fecha_inicio']      : '';
    $fecha_fin      = isset($_REQUEST['fecha_fin'])         ?$_REQUEST['fecha_fin']         : '';

    $where="1=1";
    if ($fecha_inicio!='' && $fecha_fin!='') $where.=" AND  usu_fechac BETWEEN '$fecha_inicio' AND '$fecha_fin' ";
    if ($usu_cedula!='' ) $where.=" AND  usu_cedula ='$usu_cedula' ";
    if ($usu_nombre!='' ) $where.=" AND  usu_nombre ='$usu_nombre' ";

    $sql  = "SELECT usu_codigo,
                    r.rol_nombre as usu_rol,
                    usu_nombre,
                    usu_foto,
                    usu_estado,
                    usu_cuenta,
                    usu_ultmlog AS ultim_login
            FROM usuario u
            LEFT JOIN roles r  ON (u.usu_rol=r.rol_id)
            WHERE $where ";  
    
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

function update(){
    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

    $codigo     = isset($_REQUEST['codigo'])        ?$_REQUEST['codigo']        : '';

    $where="1=1";
    
    if ($codigo!='' ) $where.=" AND  usu_codigo ='$codigo' ";

    $sql  = "SELECT usu_codigo,
                    r.rol_nombre,
                    usu_rol,
                    usu_nombre,
                    usu_foto,
                    usu_estado,
                    usu_apellido,
                    usu_telefono,
                    usu_email,
                    usu_cuenta
            FROM usuario u
            LEFT JOIN roles r  ON (u.usu_rol=r.rol_id)
            WHERE $where ";  
    
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
    if ($codigo!='' ) $where.=" AND  usu_codigo ='$codigo' ";

    $sql  = "SELECT usu_cuenta,usu_foto FROM usuario
            WHERE $where ";    
    $result = $detalle->getDatos($sql);

    $dir="C:/xampp/htdocs/Diconspro/img/usuarios/".$result[0]['usu_cuenta'];    
    delTree($dir);
   
    $sql  = "DELETE FROM usuario
            WHERE $where ";    
    $resp = $detalle->insert($sql);

    $detalle->close();

    if ($resp=='ok') {
        $respues= array(
            "status"=>"success",
            "msj"=>"El usuario se elimino correctamente"
        );
    }else {
        $respues= array(
            "status"=>"error",
            "msj"=>"Hubo un problema al eliminar el usuario"
        );
    }

    echo json_encode($respues);
}

function delTree($dir) {
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}

function estado(){
    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

    $codigo     = isset($_REQUEST['codigo'])        ?$_REQUEST['codigo']        : '';

    $where="1=1";    
    if ($codigo!='' ) $where.=" AND  usu_codigo ='$codigo' ";

    $sql  = "SELECT usu_estado FROM usuario
            WHERE $where ";    
    $result = $detalle->getDatos($sql);

    $cambio_estado = ($result[0]['usu_estado']=='2') ? "usu_estado='1' " : "usu_estado='2' ";

    $sql  = "UPDATE  usuario SET $cambio_estado
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
            "msj"=>"Hubo un problema al cambiar el estado del usuario"
        );
    }

    echo json_encode($respues);
}

function unico_usu(){
    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

    $usuario     = isset($_REQUEST['usuario']) ? $_REQUEST['usuario']  : '';

    $where="1=1";    
    if ($usuario!='' ) $where.=" AND  usu_cuenta LIKE '%$usuario%' ";

    $sql  = "SELECT usu_cuenta FROM usuario
            WHERE $where ";    
    
    $result = $detalle->getDatos($sql);

    $detalle->close();

    if (sizeof($result)>0) {
        $respues= array(
            "status"=>"success",
            "title"=>"Lo sentimos",
            "icon"=>"error",
            "msj"=>"El usuario ya existe"
        );
    }else {
        $respues= array(
            "status"=>"error",
            "msj"=>"no hay problema"
        );
    }

    echo json_encode($respues);
}

?>