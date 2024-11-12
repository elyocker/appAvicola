<?php

class clientesControlador
{
    static public function getclientes(){        

        $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

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
            WHERE 1=1
            ORDER BY c.cli_nombre";
        $result = $detalle->getDatos($sql);

        $detalle->close();
        return $result;
    }

    static public function setclientes(){        
        $tipo = isset($_REQUEST['tipo']) ? $_REQUEST['tipo'] : '';
        
        if ($tipo=='nuevo') {
            
            $cli_cedula         = isset($_REQUEST['cli_cedula'])        ? $_REQUEST['cli_cedula']           : '';
            $cli_nombre         = isset($_REQUEST['cli_nombre'])        ? $_REQUEST['cli_nombre']           : '';
            $cli_telefono       = isset($_REQUEST['cli_telefono'])      ? $_REQUEST['cli_telefono']         : '';
            $cli_email          = isset($_REQUEST['cli_email'])         ? $_REQUEST['cli_email']            : '';
            $cli_direccion      = isset($_REQUEST['cli_direccion'])     ? $_REQUEST['cli_direccion']        : '';
            $cli_barrio         = isset($_REQUEST['cli_barrio'])        ? $_REQUEST['cli_barrio']           : '';
            $departamento       = isset($_REQUEST['departamento'])      ? $_REQUEST['departamento']         : '';
            $ciudad             = isset($_REQUEST['ciudad'])            ? $_REQUEST['ciudad']               : '';
            $usuarioc=$_SESSION['usu_codigo'];

            $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);
            

            $sql_cli="INSERT INTO cliente 
                    (
                        cli_nombre,
                        cli_cedula,
                        cli_telefono,
                        cli_email,
                        cli_direccion,
                        cli_barrio,
                        cli_depart,
                        cli_ciudad,
                        cli_estado,
                        cli_usuac
                    )
                    VALUES
                    (
                        '$cli_nombre',
                        '$cli_cedula',
                        '$cli_telefono',
                        '$cli_email',
                        '$cli_direccion',
                        '$cli_barrio',
                        '$departamento',
                        '$ciudad',
                        '1',
                        '$usuarioc'
                    )";
            // echo '<pre>';
            // print_r($sql_cli);
            // echo '</pre>';
            // die("Termino");
            $result_cliente = $detalle->insert($sql_cli);

            if($result_cliente==='ok'){
                $icon="success";
                $title="Felicitaciones";
                $text="El cliente se creo exitosamente";                

            }else {
                $icon="error";
                $title="Lo sentimos";
                $text="Hubo un problema al crear el cliente";
            }

            $detalle->close();

            if ($icon!='') {
                echo"<script>
                        Swal.fire({
                            icon: '$icon',
                            title: '$title',
                            text: '$text'
                        }).then((result) => {                            
                            if (result.isConfirmed) {
                                window.location = 'clientes';
                            } 
                        })
                                           
                </script>";
            }

            $detalle->close();
        }
    }

    static public function updclientes(){        
        $tipo = isset($_REQUEST['tipo']) ? $_REQUEST['tipo'] : '';
        
        if ($tipo=='upd') {
            
            $cli_cedula         = isset($_REQUEST['cli_cedula_upd'])        ? $_REQUEST['cli_cedula_upd']           : '';
            $cli_nombre         = isset($_REQUEST['cli_nombre_upd'])        ? $_REQUEST['cli_nombre_upd']           : '';
            $cli_telefono       = isset($_REQUEST['cli_telefono_upd'])      ? $_REQUEST['cli_telefono_upd']         : '';
            $cli_email          = isset($_REQUEST['cli_email_upd'])         ? $_REQUEST['cli_email_upd']            : '';
            $cli_direccion      = isset($_REQUEST['cli_direccion_upd'])     ? $_REQUEST['cli_direccion_upd']        : '';
            $cli_barrio         = isset($_REQUEST['cli_barrio_upd'])        ? $_REQUEST['cli_barrio_upd']           : '';
            $departamento       = isset($_REQUEST['departamento_upd'])      ? $_REQUEST['departamento_upd']         : '';
            $ciudad             = isset($_REQUEST['ciudad_upd'])            ? $_REQUEST['ciudad_upd']               : '';
            $usuarioc=$_SESSION['usu_codigo'];

            $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);
            

            $sql_cli="UPDATE cliente SET 
                   
                        cli_nombre='$cli_nombre',                        
                        cli_telefono='$cli_telefono',
                        cli_email='$cli_email',
                        cli_direccion='$cli_direccion',
                        cli_barrio='$cli_barrio',
                        cli_depart='$departamento',
                        cli_ciudad='$ciudad',
                        cli_estado='1',
                        cli_usuam= '$usuarioc',
                        cli_fecham=current_date,
                        cli_horam=current_time

                    where cli_cedula='$cli_cedula'
                        
                    ";
            // echo '<pre>';
            // print_r($sql_cli);
            // echo '</pre>';
            // die("Termino");
            
            $result_cliente = $detalle->insert($sql_cli);

            if($result_cliente==='ok'){
                $icon="success";
                $title="Felicitaciones";
                $text="El cliente se actualizo exitosamente";                

            }else {
                $icon="error";
                $title="Lo sentimos";
                $text="Hubo un problema al actualizar el cliente";
            }

            $detalle->close();

            if ($icon!='') {
                echo"<script>
                        Swal.fire({
                            icon: '$icon',
                            title: '$title',
                            text: '$text'
                        }).then((result) => {                            
                            if (result.isConfirmed) {
                                window.location = 'clientes';
                            } 
                        })
                                           
                </script>";
            }

            $detalle->close();
        }
    }
}








?>