<?php

class preciosControlador 
{
    

    static public function ctrUpdaPrecios(){                  

        $tipo       = isset($_REQUEST['tipo'])      ? $_REQUEST['tipo']         : '';
        $valor_arquite = isset($_REQUEST['vlr_arquitectonico'])? $_REQUEST['vlr_arquitectonico']   : '';
        $vlr_prohori = isset($_REQUEST['vlr_prohori'])? $_REQUEST['vlr_prohori']   : '';
        $vlr_proyecto = isset($_REQUEST['vlr_proyecto'])? $_REQUEST['vlr_proyecto']   : '';
        $valor_levant = isset($_REQUEST['vlr_levanarqui'])? $_REQUEST['vlr_levanarqui']   : '';
        $vlr_suelos = isset($_REQUEST['vlr_suelos'])? $_REQUEST['vlr_suelos']   : '';
        $valor_gastos = isset($_REQUEST['vlr_gastos'])? $_REQUEST['vlr_gastos']   : '';
        $valor_tradicion = isset($_REQUEST['vlr_tradicion'])? $_REQUEST['vlr_tradicion']   : '';
        $valor_vecinos = isset($_REQUEST['vlr_vecinos'])? $_REQUEST['vlr_vecinos']   : '';
        $valor_aporticado = isset($_REQUEST['vlr_aporticado'])? $_REQUEST['vlr_aporticado']   : '';
        $valor_confinado = isset($_REQUEST['vlr_confinado'])? $_REQUEST['vlr_confinado']   : '';
        $id = isset($_REQUEST['id'])? $_REQUEST['id']   : '';

        if ($tipo=='upd') {
            $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);
            
            $sql= " UPDATE valores_cotizacion 
            SET 
            valor_arquite='$valor_arquite',
            valor_proyecto='$vlr_proyecto',
            valor_prohori='$vlr_prohori',
            valor_levant='$valor_levant',
            valor_suelos='$vlr_suelos',
            valor_tradicion='$valor_tradicion',
            valor_vecinos='$valor_vecinos',
            valor_aporticado='$valor_aporticado',
            valor_gastos='$valor_gastos',
            valor_confinado='$valor_confinado'

            WHERE valor_id='$id'"; 
            // echo '<pre>';
            // print_r($sql);
            // echo '</pre>';
            $resp = $detalle->insert($sql);

            $sql="truncate vlr_paramentos";

            $resp = $detalle->insert($sql);

            for ($i=0; $i < 6 ; $i++) {                 
                $vlr_rangoini = isset($_REQUEST['vlr_rangoini_'.$i])? $_REQUEST['vlr_rangoini_'.$i]   : '';
                $vlr_rangofin = isset($_REQUEST['vlr_rangofin_'.$i])? $_REQUEST['vlr_rangofin_'.$i]   : '';
                $vlr_valor = isset($_REQUEST['vlr_valor_'.$i])? $_REQUEST['vlr_valor_'.$i]   : '';
                $vlr_estampilla = isset($_REQUEST['vlr_estampilla_'.$i])? $_REQUEST['vlr_estampilla_'.$i]   : '';
                if ($vlr_rangoini!='') {

                    $sql="INSERT INTO vlr_paramentos
                        (
                            vlr_rangoini,
                            vlr_rangofin,
                            vlr_valor,
                            vlr_estampilla
                        )
                        VALUES
                        (
                            '$vlr_rangoini',
                            '$vlr_rangofin',
                            '$vlr_valor',
                            '$vlr_estampilla'
                        )";
                   
                    $resp = $detalle->insert($sql);
                }
                

            }
            
            $detalle->close();
            $icon="";
            $title="";
            $text="";
            if ($resp=='ok') {
                $icon="success";
                $title="En hora buena!";
                $text="Se actualizaron los precios correctamente";
            }else {
                $icon="error";
                $title="Lo sentimos";
                $text="Hubo un problmea al actualizar los precios";
            }

            if ($icon!='') {
                echo"<script>
                        Swal.fire({
                            icon: '$icon',
                            title: '$title',
                            text: '$text'
                        }).then((result) => {                            
                            if (result.isConfirmed) {
                                window.location = 'precios';
                            } 
                        })


                </script>";
            }
        }
    }
}








?>