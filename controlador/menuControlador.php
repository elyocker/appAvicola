<?php

class menuControlador 
{
    static public function getMenuUrl(){

        $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);
        
        $sql="  SELECT 
                    men_menurl AS url
                FROM menu 
                WHERE 1=1 AND men_estado='1' 
                AND men_menurl IS NOT null
                
                UNION ALL 
                
                SELECT 
                    men_suburl AS url
                FROM menu 
                WHERE 1=1 AND men_estado='1' 
                AND men_suburl IS NOT NULL
            ";      

        $resp = $detalle->getDatos($sql);

        $result = array_column($resp,'url');
        $new_arr=array();

        for ($i=0; $i < sizeof($result); $i++) { 

            if (!strpos($result[$i],',') ) array_push($new_arr, $result[$i]);
            
            if (strpos($result[$i],',') ) {

                $sub_menu = explode(',',$result[$i]);
                for ($j=0; $j < sizeof($sub_menu); $j++) { 
                    array_push($new_arr, $sub_menu[$j]);
                }
            }

        }
       
        $detalle->close();

        return $new_arr;
    }

    static public function getMenu(){

        $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);
        
        $sql= " SELECT  men_menu ,
                men_submen,
                men_menurl,
                men_suburl,
                men_estado
        FROM menu 
        WHERE 1=1 AND   
                men_estado='1' AND 
                men_menu IS NOT NULL"; 

        $resp = $detalle->getDatos($sql);

        $detalle->close();

        return $resp;
    }
}








?>