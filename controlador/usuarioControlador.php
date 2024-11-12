<?php

class usuarioControlador
{
    static public function ctrLogin(){

        global $ipConect,$usuConect,$passConect,$proyeConect;
        
        $tipo = isset($_REQUEST['tipo'])? $_REQUEST['tipo']: '';
        
        if ($tipo=='login') {

            $_SESSION['ipConect']       =$ipConect;
            $_SESSION['usuConect']      =$usuConect;
            $_SESSION['passConect']     =$passConect;
            $_SESSION['proyeConect']    =$proyeConect;

            date_default_timezone_set('America/Bogota');

            $where="1=1";
            $log_usuario    = isset($_REQUEST['log_usuario'])   ? $_REQUEST['log_usuario']   : '';
            $log_password   = isset($_REQUEST['log_password'])  ? $_REQUEST['log_password']  : '';

            if($log_usuario!='')  $where.=" AND usu_cuenta='$log_usuario'";
            // if($log_password!='') $where.=" AND usu_pass  ='$log_password'";

            $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);
            
            $sql  = "SELECT usu_codigo,
                            usu_cuenta,
                            usu_pass,
                            usu_estado,
                            r.rol_nombre as rol_nombre,
                            CONCAT(usu_nombre, ' ', usu_apellido) AS nombre_usu,
                            usu_foto
                FROM usuario u
                LEFT JOIN roles r ON(r.rol_id=u.usu_rol)
                WHERE $where ";
           
            $result = $detalle->getDatos($sql);

            $icon="";
            $title="!";
            $text="";
            if (sizeof($result)) {
               
                    if ( (password_verify($log_password,$result[0]['usu_pass']))  && $result[0]['usu_cuenta']===$log_usuario) {

                        if ($result[0]['usu_estado']=='1') {

                            $ip_usuario= isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
                            
                            $upd_camp="";
                            if ($ip_usuario!='::1') {
                                $dataArray = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip_usuario));
                                $pais_usuario= $dataArray->geoplugin_countryName;
                                $upd_camp=",usu_ipcone='$ip_usuario',
                                            usu_paiscone='$pais_usuario'";
                            }

                            $sql="  UPDATE usuario 
                                    SET usu_ultmlog=current_timestamp
                                        $upd_camp
                                    WHERE usu_codigo='".$result[0]['usu_codigo']."'";
        
                            $res = $detalle->insert($sql);
                            
                            $_SESSION['inicio_sesion']  ="ok";
                            $_SESSION['usu_codigo']     =$result[0]['usu_codigo'];
                            $_SESSION['logo']           ="img/dashboard/logo.png";
                            $_SESSION['nombre_usu']     =$result[0]['nombre_usu'];
                            $_SESSION['usu_foto']       =$result[0]['usu_foto'];
                            $_SESSION['rol']            =$result[0]['rol_nombre'];                            
    
                            if ($res=='ok') {
                                echo '<script>
                                    window.location = "inicio";
                                </script>';
                            }
                        }else {
                            $icon="error";
                            $title="¡Lo sentimos!";
                            $text="Su estado no es ACTIVO";
                        }
                    }else {
                        $icon="error";
                        $title="¡Lo sentimos!";
                        $text="La contraseña o usuario son incorrectos";
                    }  
               
            }else {
                $icon="error";
                $title="¡Lo sentimos!";
                $text="La contraseña o usuario son incorrectos";
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
                </script>";
            }
    
            $detalle->close();
        }
        

    }

    static public function getInput($tabla="",$campos="",$where="1=1"){        

        $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);
        $sql  = "SELECT $campos
            FROM $tabla 
            WHERE $where ";        
        $resp = $detalle->getDatos($sql);

        $detalle->close();
        return $resp;
    }
    
    static public function ctrCreacionUsuario(){

        $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

        $tipo= isset($_REQUEST["tipo"]) ? $_REQUEST["tipo"]:"";

        if ($tipo=="nuevo") {
            $nombre     = isset($_REQUEST['nombre'])    ? $_REQUEST['nombre']       : '';
            $telefono   = isset($_REQUEST['telefono'])  ? $_REQUEST['telefono']     : '';
            $correo     = isset($_REQUEST['correo'])    ? $_REQUEST['correo']       : '';
            $rol        = isset($_REQUEST['rol'])       ? $_REQUEST['rol']          : '';
            $password   = isset($_REQUEST['password'])  ? $_REQUEST['password']     : '';
            $usuario    = isset($_REQUEST['usuario'])   ? $_REQUEST['usuario']      : '';
            $apellido   = isset($_REQUEST['apellido'])  ? $_REQUEST['apellido']     : '';

            $encriptado=password_hash($password, PASSWORD_DEFAULT);
            
            $ruta="";
            if (isset($_FILES["usu_foto"]["tmp_name"])) {
                
                $nuevoAncho = 500;
                $nuevoAlto = 500;

                list($ancho,$alto) =getimagesize($_FILES["usu_foto"]["tmp_name"]);//RAEMOS EL ANCHO Y ALTO DE LA IMAGEN

                $new_dire="img/usuarios/$usuario";

                if (!file_exists($new_dire)) {
                    mkdir($new_dire,0777);//CREACION DE LA CARPETA
                }
               
                /*=============================================
                GUARDARMOS LA  IMAGEN
                =============================================*/ 
                $extencion=  ($_FILES["usu_foto"]["type"] == "image/jpeg") ? "jpg" : "png";

                $ruta = "$new_dire/$usuario.$extencion";

                $origen = ($_FILES["usu_foto"]["type"] == "image/jpeg") ? imagecreatefromjpeg($_FILES["usu_foto"]["tmp_name"]) : imagecreatefrompng($_FILES["usu_foto"]["tmp_name"])  ;

                $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho,$alto);

                if ($_FILES["usu_foto"]["type"] == "image/jpeg") {
                    imagejpeg($destino,$ruta);
                }else {
                    imagepng($destino,$ruta);
                }
                
            }

            $sql="INSERT INTO usuario
            (
                usu_cuenta,
                usu_pass,
                usu_nombre,
                usu_apellido,
                usu_telefono,
                usu_email,
                usu_foto,
                usu_rol,
                usu_estado
            )
            VALUES
            (
                '$usuario',
                '$encriptado',
                '$nombre',
                '$apellido',
                '$telefono',
                '$correo',
                '$ruta',
                '$rol',
                '1'
            )";

           $resp= $detalle->insert($sql);
           
           if ($resp=='ok') {
                $icon= 'success';
                $title= '¡Felicitaciones!'; 
                $text="El usuario se ingreso correctamente";                  
            }else {
                $icon= 'error';
                $title= '¡Lo sentimos!';
                $text="Hubo problemas al momento de crear el usuario"; 
            }

           echo "<script>
                Swal.fire({                        
                    icon: '$icon',
                    title:'$title',
                    text: '$text',
                    showConfirmButton: true,
                    confirmButtonColor: '#28a745',
                    confirmButtonText: 'Ok',
                    closeOnConfirm: false,
                    customClass: {  
                        title: 'title-alert'
                    },
                    }).then((result)=>{
                        if(result.value){

                        }      
                });

            </script>";

        }

        $detalle->close();
    }

    static public function ctrUpdateUsuario(){
        $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

        $tipo= isset($_REQUEST["upd_tipo"]) ? $_REQUEST["upd_tipo"]:"";

        $camp_upd="";
        if ($tipo=="upd") {

            $camp_upd       .= isset($_REQUEST['upd_nombre'])    ? "usu_nombre='".$_REQUEST['upd_nombre']."'"        : '';
            $camp_upd       .= isset($_REQUEST['upd_telefono'])  ? ",usu_telefono='".$_REQUEST['upd_telefono']."'"    : '';
            $camp_upd       .= isset($_REQUEST['upd_correo'])    ? ",usu_email='".$_REQUEST['upd_correo'] ."'"        : '';
            $camp_upd       .= isset($_REQUEST['upd_rol'])       ? ",usu_rol='".$_REQUEST['upd_rol'] ."'"             : '';
            $camp_upd       .= isset($_REQUEST['upd_apellido'])  ? ",usu_apellido='".$_REQUEST['upd_apellido'] ."'"   : '';            
            $password       = isset($_REQUEST['upd_password'])   ? $_REQUEST['upd_password']                         : '';
            $usu_codigo     = isset($_REQUEST['usu_codigo'])     ? $_REQUEST['usu_codigo']                           : '';
            $usuario        = isset($_REQUEST['upd_usuario'])    ? $_REQUEST['upd_usuario']                          : '';

            if ($password!='') {
                $encriptado=password_hash($password, PASSWORD_DEFAULT);
                $camp_upd.=",usu_pass = '$encriptado'";
            }
            
            $ruta="";
            
            if ($_FILES["upd_usu_foto"]["tmp_name"]!='' ) {
                
                $nuevoAncho = 500;
                $nuevoAlto = 500;

                list($ancho,$alto) =getimagesize($_FILES["upd_usu_foto"]["tmp_name"]);//RAEMOS EL ANCHO Y ALTO DE LA IMAGEN

                $new_dire="img/usuarios/$usuario";
 
                if (!file_exists($new_dire)) {
                    mkdir($new_dire,0777);//CREACION DE LA CARPETA
                }
                //eliminamos la anterior imagen
                $consulta="SELECT usu_foto FROM usuario WHERE usu_codigo='$usu_codigo' ";
                $result = $detalle->getDatos($consulta);
              
                unlink($result[0]['usu_foto']);
                /*=============================================
                GUARDARMOS LA  IMAGEN
                =============================================*/ 
                $extencion=  ($_FILES["upd_usu_foto"]["type"] == "image/jpeg") ? "jpg" : "png";

                $ruta = "$new_dire/$usuario.$extencion";

                $origen = ($_FILES["upd_usu_foto"]["type"] == "image/jpeg") ? imagecreatefromjpeg($_FILES["upd_usu_foto"]["tmp_name"]) : imagecreatefrompng($_FILES["upd_usu_foto"]["tmp_name"])  ;

                $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho,$alto);

                if ($_FILES["upd_usu_foto"]["type"] == "image/jpeg") {
                    imagejpeg($destino,$ruta);
                }else {
                    imagepng($destino,$ruta);
                }

                $camp_upd.=",usu_foto='$ruta'";
                
            }
            
            if ($camp_upd!='') {

                $sql="UPDATE usuario SET $camp_upd WHERE usu_codigo='$usu_codigo'";
                $resp= $detalle->insert($sql);
 
                if ($resp=='ok') {
                    $icon= 'success';
                    $title= '¡Felicitaciones!'; 
                    $text="El usuario se actualizo correctamente";                  
                }else {
                    $icon= 'error';
                    $title= '¡Lo sentimos!';
                    $text="Hubo problemas al momento de actualizar el usuario"; 
                }

                echo "<script>
                    Swal.fire({                        
                        icon: '$icon',
                        title: '$title',
                        text:'$text',
                        showConfirmButton: true,
                        confirmButtonColor: '#28a745',
                        confirmButtonText: 'Ok',
                        closeOnConfirm: false,
                        customClass: {  
                            title: 'title-alert'
                        },
                        }).then((result)=>{
                            if(result.value){
                                
                            }      
                    });

                </script>";

            }

        }

        $detalle->close();
    }

    static public function getUsuario($where="1=1"){        

        $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);


        $where.=" AND usu_codigo='".$_SESSION['usu_codigo']."'";
        
        $sql  = "SELECT 
                    r.rol_nombre as rol_nombre,
                    CONCAT(usu_nombre, ' ', usu_apellido) AS nombre_usu,
                    usu_foto
            FROM usuario u
            LEFT JOIN roles r ON(r.rol_id=u.usu_rol) 
            WHERE $where ";        
        $result = $detalle->getDatos($sql);

        $_SESSION['nombreUsuario'] =$result[0]['nombre_usu'];
        $_SESSION['urlFoto']       =$result[0]['usu_foto'];
        $_SESSION['rol']           =$result[0]['rol_nombre'];  

        $detalle->close();
    }
    
}

