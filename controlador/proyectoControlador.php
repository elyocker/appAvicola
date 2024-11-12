<?php

class proyectoControlador
{
    static public function pasarProyecto(){

        
        $tipo = isset($_REQUEST['tipo_pro'])? $_REQUEST['tipo_pro'] :"";

        if ($tipo!='') {

            $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

            $pro_nombre             = isset($_REQUEST['pro_nombre'])        ? $_REQUEST['pro_nombre']       :"";
            $pro_estimado           = isset($_REQUEST['pro_estimado'])      ? $_REQUEST['pro_estimado']     :"";
            $pro_usuario            = isset($_REQUEST['pro_usuario'])       ? $_REQUEST['pro_usuario']      :"";
            $id_cotizacion            = isset($_REQUEST['id_cotizacion'])       ? $_REQUEST['id_cotizacion']      :"";

            $usuario_creacion=$_SESSION['usu_codigo'];
            $new_dire="vistas/proyectos/$pro_nombre";
           
            if (!file_exists($new_dire)) {
                mkdir($new_dire,0777);//CREACION DE LA CARPETA
            }

            $campoInsert="";
            $valueInsert="";
            if ($_FILES["pro_autocat"]["tmp_name"]!='' ) {
               
                $extension = pathinfo($_FILES["pro_autocat"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo= "autocat.".$extension;
                move_uploaded_file($_FILES["pro_autocat"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoInsert.=",pro_autocat";
                $valueInsert.=",'$new_dire/$nombre_archivo'";
            }

            if ($_FILES["pro_escritura"]["tmp_name"]!='' ) {
                $extension = pathinfo($_FILES["pro_escritura"]["name"], PATHINFO_EXTENSION);

                $nombre_archivo= "escritura.".$extension;
                move_uploaded_file($_FILES["pro_escritura"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoInsert.=",pro_escritura";
                $valueInsert.=",'$new_dire/$nombre_archivo'";
            }

            if ($_FILES["pro_certifitradi"]["tmp_name"]!='' ) {
                $extension = pathinfo($_FILES["pro_certifitradi"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo= "tradicion.".$extension;
                move_uploaded_file($_FILES["pro_certifitradi"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoInsert.=",pro_certiftradi";
                $valueInsert.=",'$new_dire/$nombre_archivo'";
            }

            if ($_FILES["pro_impredial"]["tmp_name"]!='' ) {
                $extension = pathinfo($_FILES["pro_impredial"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo= "predial.".$extension;
                move_uploaded_file($_FILES["pro_impredial"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoInsert.=",pro_impredial";
                $valueInsert.=",'$new_dire/$nombre_archivo'";
            }

            if ($_FILES["pro_otroarch"]["tmp_name"]!='' ) {
                $extension = pathinfo($_FILES["pro_otroarch"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo= "otroarchivo.".$extension;
                move_uploaded_file($_FILES["pro_otroarch"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoInsert.=",pro_otroarch";
                $valueInsert.=",'$new_dire/$nombre_archivo'";
            }

            if ($_FILES["pro_foto1"]["tmp_name"]!='' ) {
                $extension = pathinfo($_FILES["pro_foto1"]["name"], PATHINFO_EXTENSION);
                // $extension =   explode('.',$_FILES["pro_foto1"]["name"]);
                $nombre_archivo= "foto1.".$extension;
                move_uploaded_file($_FILES["pro_foto1"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoInsert.=",pro_foto1";
                $valueInsert.=",'$new_dire/$nombre_archivo'";
            }
            if ($_FILES["pro_foto2"]["tmp_name"]!='' ) {
                $extension = pathinfo($_FILES["pro_foto2"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo= "foto2.".$extension;
                move_uploaded_file($_FILES["pro_foto2"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoInsert.=",pro_foto2";
                $valueInsert.=",'$new_dire/$nombre_archivo'";
            }
            if ($_FILES["pro_foto3"]["tmp_name"]!='' ) {
                $extension = pathinfo($_FILES["pro_foto3"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo= "foto3.".$extension;
                move_uploaded_file($_FILES["pro_foto3"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoInsert.=",pro_foto3";
                $valueInsert.=",'$new_dire/$nombre_archivo'";
            }
            if ($_FILES["pro_foto4"]["tmp_name"]!='' ) {
                $extension = pathinfo($_FILES["pro_foto4"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo= "foto4.".$extension;
                move_uploaded_file($_FILES["pro_foto4"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoInsert.=",pro_foto4";
                $valueInsert.=",'$new_dire/$nombre_archivo'";
            }
            if ($_FILES["pro_foto5"]["tmp_name"]!='' ) {
                $extension = pathinfo($_FILES["pro_foto5"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo= "foto5.".$extension;
                move_uploaded_file($_FILES["pro_foto5"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoInsert.=",pro_foto5";
                $valueInsert.=",'$new_dire/$nombre_archivo'";
            }
            if ($_FILES["pro_foto6"]["tmp_name"]!='' ) {
                $extension = pathinfo($_FILES["pro_foto6"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo= "foto6.".$extension;
                move_uploaded_file($_FILES["pro_foto6"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoInsert.=",pro_foto6";
                $valueInsert.=",'$new_dire/$nombre_archivo'";
            }

            $sql="UPDATE cotizacion SET cot_estado='1' WHERE cot_id='$id_cotizacion' ";
            
            $detalle->insert($sql);

            $sql="INSERT INTO proyecto
                (
                    pro_nombre,
                    pro_estimado,
                    pro_cotizacion,
                    pro_estado,
                    pro_usuario,
                    pro_usuc
                    $campoInsert
                ) 
                VALUES
                (
                    '$pro_nombre',
                    '$pro_estimado',
                    '$id_cotizacion',
                    '0',
                    '$pro_usuario',
                    '$usuario_creacion'
                    $valueInsert
                )  
            ";
            
            $result = $detalle->insert($sql);

            $result_cot = getDinero($detalle,$id_cotizacion);

            $icon="";
            $title="";
            $text="";

            if ($result=='ok' ) {
                $icon="success";
                $title="Felicitaciones";
                $text="El proyecto se creo exitosamente";                

            }else {
                $icon="error";
                $title="Lo sentimos";
                $text="Hubo un problema al crear el proyecto";
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
            
            $detalle->close();
        }

    }

    static public function getProyectos(){    

        $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

        $sql="SELECT *
            FROM proyectos         
            WHERE 1=1";
        $result = $detalle->getDatos($sql);
        // echo '<pre>';
        // print_r($result);
        // echo '</pre>';
        // die("Termino");
        $detalle->close();
        return $result;
    }

    static public function actualizar(){

        $tipo = isset($_REQUEST['tipo_proyecto'])? $_REQUEST['tipo_proyecto'] :"";

        if ($tipo!='') {

            $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

            $pro_estado             = isset($_REQUEST['proyecto_estado'])       ? $_REQUEST['proyecto_estado']      :"";
            $codigo_proyecto        = isset($_REQUEST['codigo_proyecto'])       ? $_REQUEST['codigo_proyecto']      :"";
            $pro_nombre             = isset($_REQUEST['nombre_pro'])       ? $_REQUEST['nombre_pro']      :"";
            
            $usuario_creacion=$_SESSION['usu_codigo'];
            $new_dire="vistas/proyectos/$pro_nombre";
           
            if (!file_exists($new_dire)) {
                mkdir($new_dire,0777);//CREACION DE LA CARPETA
            }

            $campoUpd="";
            if ($_FILES["autocat_new"]["tmp_name"]!='' ) {                
                $extension = pathinfo($_FILES["autocat_new"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo= "autocat.".$extension;
                delete_archivo($detalle,'pro_autocat',$codigo_proyecto);
                move_uploaded_file($_FILES["autocat_new"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoUpd.=",pro_autocat='$new_dire/$nombre_archivo'";
            }

            if ($_FILES["escritura_new"]["tmp_name"]!='' ) {
                $extension = pathinfo($_FILES["escritura_new"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo= "escritura.".$extension;
                delete_archivo($detalle,'pro_escritura',$codigo_proyecto);
                move_uploaded_file($_FILES["escritura_new"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoUpd.=",pro_escritura='$new_dire/$nombre_archivo'";
            }

            if ($_FILES["certifitradi_new"]["tmp_name"]!='' ) {
                 $extension = pathinfo($_FILES["certifitradi_new"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo= "tradicion.".$extension;
                delete_archivo($detalle,'pro_certiftradi',$codigo_proyecto);
                move_uploaded_file($_FILES["certifitradi_new"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoUpd.=",pro_certiftradi='$new_dire/$nombre_archivo'";
            }

            if ($_FILES["impredial_new"]["tmp_name"]!='' ) {
                $extension = pathinfo($_FILES["impredial_new"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo= "predial.".$extension;
                delete_archivo($detalle,'pro_impredial',$codigo_proyecto);
                move_uploaded_file($_FILES["impredial_new"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoUpd.=",pro_impredial='$new_dire/$nombre_archivo'";
            }

            if ($_FILES["otroarch_new"]["tmp_name"]!='' ) {
                $extension = pathinfo($_FILES["otroarch_new"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo= "otroarchivo.".$extension;
                delete_archivo($detalle,'pro_otroarch',$codigo_proyecto);
                move_uploaded_file($_FILES["otroarch_new"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoUpd.=",pro_otroarch='$new_dire/$nombre_archivo'";
            }

            if ($_FILES["pro_foto1"]["tmp_name"]!='' ) {
                $extension = pathinfo($_FILES["pro_foto1"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo= "foto1.".$extension; 
                delete_archivo($detalle,'pro_foto1',$codigo_proyecto);
                move_uploaded_file($_FILES["pro_foto1"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoUpd.=",pro_foto1='$new_dire/$nombre_archivo'";
            }
            if ($_FILES["pro_foto2"]["tmp_name"]!='' ) {
                $extension = pathinfo($_FILES["pro_foto2"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo= "foto2.".$extension;
                delete_archivo($detalle,'pro_foto2',$codigo_proyecto);
                move_uploaded_file($_FILES["pro_foto2"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoUpd.=",pro_foto2 ='$new_dire/$nombre_archivo'";
            }
            if ($_FILES["pro_foto3"]["tmp_name"]!='' ) {
                $extension = pathinfo($_FILES["pro_foto3"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo= "foto3.".$extension;
                delete_archivo($detalle,'pro_foto3',$codigo_proyecto);
                move_uploaded_file($_FILES["pro_foto3"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoUpd.=",pro_foto3='$new_dire/$nombre_archivo'";
            }
            if ($_FILES["pro_foto4"]["tmp_name"]!='' ) {
                $extension = pathinfo($_FILES["pro_foto4"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo= "foto4.".$extension;
                delete_archivo($detalle,'pro_foto4',$codigo_proyecto);
                move_uploaded_file($_FILES["pro_foto4"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoUpd.=",pro_foto4='$new_dire/$nombre_archivo'";
            }
            if ($_FILES["pro_foto5"]["tmp_name"]!='' ) {
                $extension = pathinfo($_FILES["pro_foto5"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo= "foto5.".$extension;
                delete_archivo($detalle,'pro_foto5',$codigo_proyecto);
                move_uploaded_file($_FILES["pro_foto5"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoUpd.=",pro_foto5='$new_dire/$nombre_archivo'";
            }
            if ($_FILES["pro_foto6"]["tmp_name"]!='' ) {
                $extension = pathinfo($_FILES["pro_foto6"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo= "foto6.".$extension;
                delete_archivo($detalle,'pro_foto6',$codigo_proyecto);
                move_uploaded_file($_FILES["pro_foto6"]["tmp_name"], $new_dire."/$nombre_archivo");
                $campoUpd.=",pro_foto6='$new_dire/$nombre_archivo'";
            }

            $campoUpd.=($pro_estado=='1') ? ",pro_fechaini=current_date" : ($pro_estado=='2' ? ",pro_fechafin=current_date" : "");

            if ($pro_estado!="") {
                $sql="SELECT pro_estado FROM proyecto WHERE pro_codigo='$codigo_proyecto' ";
                $result = $detalle->getDatos($sql);

                if ($result[0]['pro_estado']!='' && $result[0]['pro_estado']!=$pro_estado ) {
                    $campoUpd.=",pro_estado='$pro_estado' ";
                }
            }

            if($pro_estado=='3'){

                $sql="SELECT pro_cotizacion FROM proyecto WHERE pro_codigo='$codigo_proyecto' ";

                $result = $detalle->getDatos($sql);

                cuadre($detalle,$result[0]['pro_cotizacion']);
            }
            
            if ($campoUpd!='') {
                $campoUpd=substr($campoUpd, 1);
                $sql="UPDATE proyecto SET         
                        $campoUpd        
                        where pro_codigo='$codigo_proyecto'           
                ";
                // echo '<pre>';
                // print_r($sql);
                // echo '</pre>';
                // die("Termino");
                $result = $detalle->insert($sql);

                $icon="";
                $title="";
                $text="";
                if ($result=='ok' ) {
                    $icon="success";
                    $title="Felicitaciones";
                    $text="Se actualizo el proyecto";                
    
                }else {
                    $icon="error";
                    $title="Lo sentimos";
                    $text="Hubo un problema con el proyecto";
                }
                
                if ($icon!='') {
                    echo"<script>
                            Swal.fire({
                                icon: '$icon',
                                title: '$title',
                                text: '$text'
                            }).then((result) => {                            
                                if (result.isConfirmed) {
                                    window.location = 'proyectos';
                                } 
                            })
                                               
                    </script>";
                }
            }

            
            $detalle->close();
        }

    }
}


function delete_archivo($detalle,$tipo='',$pro_codigo='') {

   $sql="SELECT $tipo FROM proyecto WHERE pro_codigo='$pro_codigo' ";   
   $result = $detalle->getDatos($sql);

   if (file_exists($result[0][$tipo])) {
        unlink($result[0][$tipo]);
   }
}

function getDinero($detalle=array(),$id=''){

    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);
    
    $sql="  SELECT 
                    c.cot_id,
                    (c.cot_pisos * cot_metro2) AS metros2,
                    c.cot_pisos,
                    c.cot_prophori,
                    c.cot_arquit,
                    c.cot_suelos,
                    c.cot_arquitectonico,
                    c.cot_estructural,
                    c.cot_tipocot,
                    c.cot_valortot,
                    p.pro_codigo
            FROM cotizacion c
            left join proyecto p ON (p.pro_cotizacion=c.cot_id)
            WHERE cot_id = '$id' ";    

    // echo '<pre>';
    // print_r($sql);
    // echo '</pre>';
    // die("Termino");  

    $resp = $detalle->getDatos($sql);

    $sql="  SELECT  *
            FROM valores_cotizacion 
            WHERE 1 = 1 ";      

    $result_vlr = $detalle->getDatos($sql);

    foreach ($resp as $row) {

        $cot_id                 = $row['cot_id'];
        $metros2                = $row['metros2'];
        $cot_prophori           = $row['cot_prophori'];
        $cot_arquit             = $row['cot_arquit'];
        $cot_suelos             = $row['cot_suelos'];
        $cot_arquitectonico     = $row['cot_arquitectonico'];
        $cot_estructural        = $row['cot_estructural'];
        $cot_tipocot            = $row['cot_tipocot'];
        $cot_valortot           = $row['cot_valortot'];
        $pro_codigo           = $row['pro_codigo'];

        $vlr_sesenta=($cot_valortot * 0.6);
        $vlr_cuarenta=($cot_valortot * 0.4);

        if (
            (($cot_arquitectonico =='' || $cot_arquitectonico !='') && $cot_prophori =='false' && $cot_arquit =='true' && $cot_suelos =='false' && $cot_tipocot =='') ||
            ($cot_arquitectonico !='' && $cot_prophori =='false' && $cot_arquit =='false' && $cot_suelos =='false' && $cot_tipocot =='') 
            ) {
                
            $total_deuda=0;
            $resultado=($cot_valortot * 0.6) -(($cot_valortot * 0.6) * 0.52);
            $total_proveedor=(($cot_valortot * 0.6) * 0.52);
            // echo "un solo item <BR> \n";

        }  elseif (
            ($cot_arquitectonico =='' && $cot_prophori =='true' && $cot_arquit =='false' && $cot_suelos =='false' && $cot_tipocot =='') ||
            
            ($cot_arquitectonico =='' && $cot_prophori =='false' && $cot_arquit =='false' && $cot_suelos =='true' && $cot_tipocot =='') ||
            ($cot_arquitectonico =='' && $cot_prophori =='false' && $cot_arquit =='false' && $cot_suelos =='false' && $cot_tipocot !='')
        ) {

            $total_deuda=0;
            $resultado=0;
            $total_proveedor=($cot_valortot * 0.6);

         }   else {

            //INICIO::valores del 60 %
                $vlr_propHori = ($cot_prophori =='true') ? (($result_vlr[0]['valor_prohori'] * $metros2) * 0.52) : 0;
                $vlr_levantArqui = ($cot_arquit =='true') ? (($result_vlr[0]['valor_levant'] * $metros2) * 0.52) : 0;
                $vlr_estuSuelo = ($cot_suelos =='true') ? ($result_vlr[0]['valor_suelos']  * 0.52) : 0;
    
                $vlr_arquitectonico = ($cot_arquitectonico !='') ? (($result_vlr[0]['valor_arquite'] * $metros2) * 0.52) : 0;
                $vlr_aporticado = ($cot_tipocot =='aporticado') ? (($result_vlr[0]['valor_aporticado'] * $metros2) * 0.52) : 0;
                $vlr_confinado = ($cot_tipocot =='confinado') ? (($result_vlr[0]['valor_confinado'] * $metros2) * 0.52) : 0;
            //FIN::valores del 60 %
    
            //INICIO::valores de lo que se debe a proveedores
                $vlr_propHori_deuda = ($cot_prophori =='true') ? (($result_vlr[0]['valor_prohori'] * $metros2) * 0.48) : 0;
                $vlr_levantArqui_deuda = ($cot_arquit =='true') ? (($result_vlr[0]['valor_levant'] * $metros2) * 0.48) : 0;
                $vlr_estuSuelo_deuda = ($cot_suelos =='true') ? ($result_vlr[0]['valor_suelos']  * 0.48) : 0;
    
                $vlr_aporticado_deuda = ($cot_tipocot =='aporticado') ? (($result_vlr[0]['valor_aporticado'] * $metros2) * 0.48) : 0;
                $vlr_confinado_deuda = ($cot_tipocot =='confinado') ? (($result_vlr[0]['valor_confinado'] * $metros2) * 0.48) : 0;

            //FIN::valores de lo que se debe a proveedores

            $total_deuda=($vlr_propHori_deuda +$vlr_levantArqui_deuda+$vlr_estuSuelo_deuda  + $vlr_confinado_deuda + $vlr_aporticado_deuda);
            // die("Termino");
    
            $resultado = ($vlr_sesenta -$vlr_propHori -$vlr_levantArqui - $vlr_estuSuelo - $vlr_arquitectonico - $vlr_aporticado -$vlr_confinado);
    
            $total_proveedor=($vlr_propHori +$vlr_levantArqui + $vlr_estuSuelo + $vlr_arquitectonico  + $vlr_aporticado +$vlr_confinado);
        }


        // echo "vlr_propHori_deuda:: $vlr_propHori_deuda <BR>\r\n";
        // echo "vlr_levantArqui_deuda:: $vlr_levantArqui_deuda <BR>\r\n";
        // echo "vlr_estuSuelo_deuda:: $vlr_estuSuelo_deuda <BR>\r\n";
        // echo "vlr_aporticado_deuda:: $vlr_aporticado_deuda <BR>\r\n";
        // echo "vlr_confinado_deuda:: $vlr_confinado_deuda <BR>\r\n";
        // echo "---------------------------------------------------------------------------------<BR> \n";
        // echo "total_deuda:: $total_deuda <BR>\r\n";
        // echo "resultado:: $resultado <BR>\r\n";
        // die("Termino");
        


        $usuario_creacion=$_SESSION['usu_codigo'];

        $sql="INSERT INTO balance 
                (
                    bal_cotizacion,
                    bal_proveedor,
                    bal_ingresos,
                    bal_usuc,
                    bal_porcentaje,
                    bal_total,
                    bal_sesenta,
                    bal_cuarenta,
                    bal_deuda,
                    bal_estado
                )
                VALUES
                (
                    '$cot_id',
                    '$total_proveedor',
                    '$resultado',
                    '$usuario_creacion',
                    '60',
                    '$cot_valortot',
                    '$vlr_sesenta',
                    '$vlr_cuarenta',
                    '$total_deuda',
                    'Abierto'
                );
            ";

        
        $res= $detalle->insert($sql);


        $sql="INSERT INTO vlr_company
            (
                vlr_valor,
                vlr_cotizacion,
                vlr_proyecto
            )
            values
            (
                '$resultado',
                '$cot_id',
                '$pro_codigo'
            );";
            
        $res= $detalle->insert($sql);


    }

    $detalle->close();

    return $resp;
}


function cuadre($detalle=array(),$id=''){


    $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);
    
    $sql="  SELECT 
                    c.cot_id,
                    (c.cot_pisos * cot_metro2) AS metros2,
                    c.cot_pisos,
                    c.cot_prophori,
                    c.cot_arquit,
                    c.cot_suelos,
                    c.cot_arquitectonico,
                    c.cot_estructural,
                    c.cot_tipocot,
                    c.cot_valortot,
                    p.pro_codigo
            FROM cotizacion c
            left join proyecto p ON (p.pro_cotizacion=c.cot_id)
            WHERE cot_id = '$id' ";    

    // echo '<pre>';
    // print_r($sql);
    // echo '</pre>';
    // die("Termino");  

    $resp = $detalle->getDatos($sql);

    $sql="  SELECT  *
            FROM valores_cotizacion 
            WHERE 1 = 1 ";      

    $result_vlr = $detalle->getDatos($sql);

    foreach ($resp as $row) {

        $cot_id                 = $row['cot_id'];
        $metros2                = $row['metros2'];
        $cot_prophori           = $row['cot_prophori'];
        $cot_arquit             = $row['cot_arquit'];
        $cot_suelos             = $row['cot_suelos'];
        $cot_arquitectonico     = $row['cot_arquitectonico'];
        $cot_tipocot            = $row['cot_tipocot'];
        $cot_valortot           = $row['cot_valortot'];
        $pro_codigo           = $row['pro_codigo'];

        $vlr_sesenta=($cot_valortot * 0.6);
        $vlr_cuarenta=($cot_valortot * 0.4);

        if (
            (($cot_arquitectonico =='' || $cot_arquitectonico !='') && $cot_prophori =='false' && $cot_arquit =='true' && $cot_suelos =='false' && $cot_tipocot =='') ||
            ($cot_arquitectonico !='' && $cot_prophori =='false' && $cot_arquit =='false' && $cot_suelos =='false' && $cot_tipocot =='')             
            ) {

            $total_deuda=0;
            $resultado=($cot_valortot * 0.4);
            $total_proveedor=0;
            // echo "un solo item <BR> \n";

        } elseif (
                ($cot_arquitectonico =='' && $cot_prophori =='true' && $cot_arquit =='false' && $cot_suelos =='false' && $cot_tipocot =='') ||
                ($cot_arquitectonico =='' && $cot_prophori =='false' && $cot_arquit =='false' && $cot_suelos =='true' && $cot_tipocot =='') ||
                ($cot_arquitectonico =='' && $cot_prophori =='false' && $cot_arquit =='false' && $cot_suelos =='false' && $cot_tipocot !='')
            ) {

            $total_deuda=0;
            $resultado=0;
            $total_proveedor=($cot_valortot * 0.4);

        } else {
            // echo "varios item <BR> \n";
            
            //INICIO::valores del 60 %
                $vlr_propHori = ($cot_prophori =='true') ? (($result_vlr[0]['valor_prohori'] * $metros2) * 0.48) : 0;
                $vlr_levantArqui = ($cot_arquit =='true') ? (($result_vlr[0]['valor_levant'] * $metros2) * 0.48) : 0;
                $vlr_estuSuelo = ($cot_suelos =='true') ? ($result_vlr[0]['valor_suelos']  * 0.48) : 0;
    
               
                $vlr_aporticado = ($cot_tipocot =='aporticado') ? (($result_vlr[0]['valor_aporticado'] * $metros2) * 0.48) : 0;
                $vlr_confinado = ($cot_tipocot =='confinado') ? (($result_vlr[0]['valor_confinado'] * $metros2) * 0.48) : 0;
            //FIN::valores del 60 %
    
            //INICIO::valores de lo que se debe a proveedores
                $vlr_propHori_deuda = ($cot_prophori =='true') ? (($result_vlr[0]['valor_prohori'] * $metros2) * 0.48) : 0;
                $vlr_levantArqui_deuda = ($cot_arquit =='true') ? (($result_vlr[0]['valor_levant'] * $metros2) * 0.48) : 0;
                $vlr_estuSuelo_deuda = ($cot_suelos =='true') ? ($result_vlr[0]['valor_suelos']  * 0.48) : 0;
    
                $vlr_aporticado_deuda = ($cot_tipocot =='aporticado') ? (($result_vlr[0]['valor_aporticado'] * $metros2) * 0.48) : 0;
                $vlr_confinado_deuda = ($cot_tipocot =='confinado') ? (($result_vlr[0]['valor_confinado'] * $metros2) * 0.48) : 0;
            //FIN::valores de lo que se debe a proveedores
            // echo "vlr_propHori_deuda:: $vlr_propHori_deuda <BR>\r\n";
            // echo "vlr_levantArqui_deuda:: $vlr_levantArqui_deuda <BR>\r\n";
            // echo "vlr_estuSuelo_deuda:: $vlr_estuSuelo_deuda <BR>\r\n";
            // echo "vlr_aporticado_deuda:: $vlr_aporticado_deuda <BR>\r\n";
            // echo "vlr_confinado_deuda:: $vlr_confinado_deuda <BR>\r\n";
            // echo "---------------------------------------------------------------------------------<BR> \n";
            //  echo " vlr_cuarenta:: $ $vlr_cuarenta <BR>\r\n";
            //  echo "vlr_propHori:: $vlr_propHori <BR>\r\n";
            // echo "vlr_levantArqui:: $vlr_levantArqui <BR>\r\n";
            // echo "vlr_estuSuelo:: $vlr_estuSuelo <BR>\r\n";
            // echo "vlr_aporticado:: $vlr_aporticado <BR>\r\n";
            // echo "vlr_confinado:: $vlr_confinado <BR>\r\n";
            $total_deuda=-($vlr_propHori_deuda +$vlr_levantArqui_deuda+$vlr_estuSuelo_deuda  + $vlr_confinado_deuda + $vlr_aporticado_deuda);
    
            
            $resultado = ($vlr_propHori +$vlr_levantArqui + $vlr_estuSuelo  + $vlr_aporticado +$vlr_confinado);

            $resultado=($resultado<0) ?$vlr_cuarenta- (($resultado ) * (-1)) :  $vlr_cuarenta - $resultado;
            $total_proveedor=($vlr_propHori +$vlr_levantArqui + $vlr_estuSuelo  + $vlr_aporticado +$vlr_confinado);
        }
        // echo "resultado:: $resultado <BR>\r\n";        

        // echo "total_proveedor:: $total_proveedor <BR>\r\n";
        // echo "total_deuda:: $total_deuda <BR>\r\n";
        
        // die("Termino");

        $usuario_creacion=$_SESSION['usu_codigo'];

        $sql="INSERT INTO balance 
                (
                    bal_cotizacion,
                    bal_proveedor,
                    bal_ingresos,
                    bal_usuc,
                    bal_porcentaje,
                    bal_total,
                    bal_sesenta,
                    bal_cuarenta,
                    bal_deuda,
                    bal_estado
                )
                VALUES
                (
                    '$cot_id',
                    '$total_proveedor',
                    '$resultado',
                    '$usuario_creacion',
                    '40',
                    '$cot_valortot',
                    '$vlr_sesenta',
                    '$vlr_cuarenta',
                    '$total_deuda',
                    'Cerrado'
                );
            ";

        
        $res= $detalle->insert($sql);


        $sql="INSERT INTO vlr_company
            (
                vlr_valor,
                vlr_cotizacion,
                vlr_proyecto
            )
            values
            (
                '$resultado',
                '$cot_id',
                '$pro_codigo'
            );";
            
        $res= $detalle->insert($sql);


    }

    $detalle->close();

    return $resp;
}

?>