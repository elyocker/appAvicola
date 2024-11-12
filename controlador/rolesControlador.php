<?php

class rolesControlador 
{
    static public function getRoles(){

        $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);
        
        $sql="  SELECT r.rol_id,
                        r.rol_nombre ,
                        r.rol_estado 
        FROM roles r WHERE 1=1  ";      

        $resp = $detalle->getDatos($sql);

        $detalle->close();

        return $resp;
    }

    static public function ctrCreacionRoles(){

        $tipo       = isset($_REQUEST['tipo'])      ? $_REQUEST['tipo']         : '';
        $rol_nombre = isset($_REQUEST['rol_nombre'])? $_REQUEST['rol_nombre']   : '';

        if ($tipo=='nuevo') {
            $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);
            
            $sql= " INSERT INTO roles(rol_nombre,rol_estado)VALUES('$rol_nombre','1')"; 
    
            $resp = $detalle->insert($sql);
            
            $detalle->close();
            $icon="";
            $title="";
            $text="";
            if ($resp=='ok') {
                $icon="success";
                $title="En hora buena!";
                $text="Se guardo el rol correctamente";
            }else {
                $icon="error";
                $title="Lo sentimos";
                $text="Hubo un problmea al crear el rol";
            }

            if ($icon!='') {
                echo"<script>
                        Swal.fire({
                            position: 'top-end',
                            icon: '$icon',
                            title: '$title',
                            text:  '$text',
                            showConfirmButton: false,
                            timer: 1500
                        });  

                        // window.location = 'roles'; 

                </script>";
            }
        }
    }
}








?>