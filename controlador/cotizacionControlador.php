<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class cotizacionControlador 
{
    static public function setCotizacion(){        
        $tipo = isset($_REQUEST['tipo']) ? $_REQUEST['tipo'] : '';

        if ($tipo=='nuevo') {

            // echo '<script>
            //     window.location = "vistas/modulos/pdf_cotizacion.php?tipo=cotizacion&id=2";
            // </script>';
            
            $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);
            // echo '<pre>';
            // print_r($_REQUEST);
            // echo '</pre>';
            // die("Termino");
            //INICIO::datos de cotizacion

                $cot_arquitectonico = isset($_REQUEST['arquitectonico'])    ? $_REQUEST['arquitectonico']       : '';
                $cot_estructural    = isset($_REQUEST['estructural'])       ? $_REQUEST['estructural']          : '';
                $tipocot            = isset($_REQUEST['tipo_cotiza'])       ? $_REQUEST['tipo_cotiza']          : '';
                $total_medidas      = isset($_REQUEST['total_medidas'])     ? $_REQUEST['total_medidas']        : '';
                $tot_confinado      = isset($_REQUEST['tot_confinado'])     ? $_REQUEST['tot_confinado']        : '';
                $tot_aporticado     = isset($_REQUEST['tot_aporticado'])    ? $_REQUEST['tot_aporticado']       : '';
                $tot_proyecto       = isset($_REQUEST['tot_proyecto'])      ? $_REQUEST['tot_proyecto']         : '';
                $valor_total        = isset($_REQUEST['valor_total'])       ? $_REQUEST['valor_total']          : '';
                $tipo_vivienda      = isset($_REQUEST['tipo_vivienda'])     ? $_REQUEST['tipo_vivienda']        : '';               
                $numero_pisos       = isset($_REQUEST['numero_pisos'])      ? $_REQUEST['numero_pisos']         : '0';
                $descuento          = isset($_REQUEST['descuento'])         ? $_REQUEST['descuento']            : '0';
                $obra_nueva         = isset($_REQUEST['obra_nueva'])        ? "true"                            : 'false';
                $reconocimiento     = isset($_REQUEST['reconocimiento'])    ? "true"                            : 'false';
                $pro_horizon        = isset($_REQUEST['pro_horizon'])       ? "true"                            : 'false';
                $leva_arqui         = isset($_REQUEST['leva_arqui'])        ? "true"                            : 'false';
                $estu_suelos        = isset($_REQUEST['estu_suelos'])       ? "true"                            : 'false';

            //FIN::datos de cotizacion

            //INICIO::DOCUMENTACION
                $tradicion          = isset($_REQUEST['tradicion'])         ? "true"                            : 'false';
                $curaduria          = isset($_REQUEST['curaduria'])         ? "true"                            : 'false';
                $carta_vecino       = isset($_REQUEST['carta_vecino'])      ? "true"                            : 'false';
                $cant_vecinos       = isset($_REQUEST['cant_vecinos'])      ? $_REQUEST['cant_vecinos']         : '';
                $linea_paramentos   = isset($_REQUEST['linea_paramentos'])  ? $_REQUEST['linea_paramentos']     : '';
            //FIN::DOCUMENTACION

            //INICIO::datos del cliente
            
                $cliente_existe     = ($_REQUEST['cliente_existe']=='true') ? $_REQUEST['cliente_existe']       : 'false';
                $cli_cedula         = isset($_REQUEST['cli_cedula'])        ? $_REQUEST['cli_cedula']           : '';
                $cli_nombre         = isset($_REQUEST['cli_nombre'])        ? $_REQUEST['cli_nombre']           : '';
                $cli_telefono       = isset($_REQUEST['cli_telefono'])      ? $_REQUEST['cli_telefono']         : '';
                $cli_email          = isset($_REQUEST['cli_email'])         ? $_REQUEST['cli_email']            : '';
                $cli_direccion      = isset($_REQUEST['cli_direccion'])     ? $_REQUEST['cli_direccion']        : '';
                $cli_barrio         = isset($_REQUEST['cli_barrio'])        ? $_REQUEST['cli_barrio']           : '';
                $departamento       = isset($_REQUEST['departamento'])      ? $_REQUEST['departamento']         : '';
                $ciudad             = isset($_REQUEST['ciudad'])            ? $_REQUEST['ciudad']               : '';
            //FIN::datos del cliente
            $result_paramentos=cotizacionControlador::getVlrParamentos();
            
            foreach ($result_paramentos as $row) {
                $vlr_linea_parame= ( $linea_paramentos >= $row['vlr_rangoini'] && $linea_paramentos <= $row['vlr_rangofin'] ) ? $row['vlr_valor'] : 0;
            }
            
            $aleatorio = mt_rand(1000,9999);
            $nombre_proyecto="$aleatorio - INMUEBLE ".strtoupper($cli_nombre);
           
            $usuarioc=$_SESSION['usu_codigo'];

            $sql="INSERT INTO cotizacion 
                (
                    cot_nombre,
                    cot_tipocot,
                    cot_tipo,
                    cot_recono,
                    cot_pisos,
                    cot_obranue,
                    cot_prophori,
                    cot_arquit,
                    cot_metro2,
                    cot_valortot,
                    cot_estado,
                    cot_suelos,
                    cot_usuarioc,
                    cot_descuento,
                    cot_tradicion,
                    cot_curaduria,
                    cot_vecinos,
                    cot_cantveci,
                    cot_lineaparam,
                    cot_vlrparam,
                    cot_cliente,
                    cot_arquitectonico,
                    cot_estructural

                )
                VALUES
                (
                    '$nombre_proyecto',
                    '$tipocot',
                    '$tipo_vivienda',
                    '$reconocimiento',
                    '$numero_pisos',
                    '$obra_nueva',
                    '$pro_horizon',
                    '$leva_arqui',
                    '$total_medidas',
                    '$valor_total',
                    '0',
                    '$estu_suelos',
                    '$usuarioc',
                    '$descuento',
                    '$tradicion',
                    '$curaduria',
                    '$carta_vecino',
                    '$cant_vecinos',
                    '$linea_paramentos',
                    '$vlr_linea_parame',
                    '$cli_cedula',
                    '$cot_arquitectonico',
                    '$cot_estructural'
                )";
            
            $result_cotiza = $detalle->insert($sql);

            $result_cliente='ok';
            if ($cliente_existe=='false') {
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
               
                $result_cliente = $detalle->insert($sql_cli);
            }

            $icon="";
            $title="";
            $text="";
            if ($result_cotiza=='ok' && $result_cliente=='ok') {
                // echo "result_cotiza:: $result_cotiza <BR>\r\n";
                // echo "result_cliente:: $result_cliente <BR>\r\n";

                $sql="SELECT cot_id FROM cotizacion  ORDER BY cot_id DESC LIMIT 1";
                $result = $detalle->getDatos($sql);

                # se crea el pdf
                generarpdf($result[0]['cot_id']);

                #se envia el correo
                envioCorreo($cli_email,$nombre_proyecto);
                $icon="success";
                $title="Felicitaciones";
                $text="La cotizacion se creo exitosamente";                

            }else {
                $icon="error";
                $title="Lo sentimos";
                $text="Hubo un problema al crear la cotización";
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
                                window.location = 'cotizacion';
                            } 
                        })
                                           
                </script>";
            }

           
            // die("Termino");
        }
    }

    static public function getDepartamento(){        

        $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

        $sql="SELECT * FROM departamentos ";
        $result = $detalle->getDatos($sql);

        $detalle->close();
        return $result;
    }

    static public function getUsuario(){        

        $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

        $sql="SELECT usu_codigo,usu_nombre FROM usuario where usu_estado='1' ";
        $result = $detalle->getDatos($sql);

        $detalle->close();
        return $result;
    }

    static public function getCliente($id=''){    

        $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

        $sql="SELECT c.cli_nombre,
                    c.cli_direccion,
                    c.cli_barrio,
                    co.cot_nombre,
                    d.departamento,
                    m.municipio,
                    co.cot_metro2,
                    co.cot_recono,
                    co.cot_obranue,
                    co.cot_pisos,
                    co.cot_valortot,
                    co.cot_tradicion,
                    co.cot_curaduria,
                    co.cot_vecinos,
                    c.cli_telefono,
                    co.cot_tipo,
                    co.cot_suelos,
                    co.cot_arquit,
                    co.cot_arquitectonico,
                    co.cot_estructural,
                    co.cot_cantveci,
                    co.cot_vlrparam,
                    co.cot_tipocot,
                    co.cot_nombre,
                    co.cot_lineaparam,
                    cot_prophori,
                    cot_arquit,
                    concat_ws(' ', u.usu_nombre, u.usu_apellido) as usuario

            FROM cotizacion co 
            LEFT JOIN cliente c ON  (c.cli_cedula=co.cot_cliente)
            LEFT JOIN usuario u ON  (u.usu_codigo=co.cot_usuarioc)
            LEFT JOIN departamentos d ON  (c.cli_depart=d.id_departamento)
            LEFT JOIN municipios m ON  (m.departamento_id=d.id_departamento AND m.id_municipio=c.cli_ciudad)
            WHERE co.cot_id='$id'";
        $result = $detalle->getDatos($sql);
        // echo '<pre>';
        // print_r($result);
        // echo '</pre>';
        // die("Termino");
        $detalle->close();
        return $result;
    }

    static public function getValores(){    

        $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

        $sql="SELECT *
            FROM valores_cotizacion         
            WHERE 1=1";
        $result = $detalle->getDatos($sql);
        // echo '<pre>';
        // print_r($result);
        // echo '</pre>';
        // die("Termino");
        $detalle->close();
        return $result;
    }

    static public function getVlrParamentos(){    

        $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

        $sql="SELECT    vlr_rangoini,
                        vlr_rangofin,
                        (vlr_valor + vlr_estampilla) as vlr_valor                        
            FROM vlr_paramentos         
            WHERE 1=1";
        $result = $detalle->getDatos($sql);
        // echo '<pre>';
        // print_r($result);
        // echo '</pre>';
        // die("Termino");
        $detalle->close();
        return $result;
    }

}


function envioCorreo($correo='',$nombre_coti=''){

    if ($correo!=''&& $nombre_coti!='') {        
        $mail = new PHPMailer(true);
    
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'soportediconsprosa@gmail.com';                     //SMTP username
            $mail->Password   = 'pckgcdghyzdiinvu';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
            //Recipients
            $mail->setFrom('soportediconsprosa@gmail.com', 'Soporte Diconspro');
            $mail->addAddress($correo);  
    
            //Attachments
            
            $mail->addAttachment('vistas/pdf/generados/cotizacion_'.$nombre_coti.'.pdf');      //Optional name
    
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = utf8_decode('Envio de cotización');
            $mail->Body    = '<h3>Gracias por preferirnos</h3>
                                <p>Codigo: '.$nombre_coti.', puedes consultar en  <a href=\'#\'>Pagina</a> </p>';
    
            $mail->send();
            echo '<script>alert(\'Correo enviado\')</script> ';
        } catch (Exception $e) {
            // echo "problemas al enviar el correo Error:: {$mail->ErrorInfo}";
            die("Termino");
        }
    }
    
}
?>