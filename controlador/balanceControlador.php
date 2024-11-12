<?php

class balanceControlador 
{
    static public function getBalance(){    

        $detalle = new con_db( $_SESSION['ipConect'], $_SESSION['usuConect'],$_SESSION['passConect'], $_SESSION['proyeConect']);

        $sql="SELECT *
            FROM balance         
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








?>