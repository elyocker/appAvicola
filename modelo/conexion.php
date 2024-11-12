<?php

class con_db extends mysqli
{
    public function __construct($host,$usuario,$pass,$nombd){
        $this->host=$host;
        $this->usuario=$usuario;
        $this->pass=$pass;
        $this->nombd=$nombd;

        parent::__construct($this->host,$this->usuario,$this->pass,$this->nombd);
        // $this->set_charset('utf-8');
        $this->set_charset("utf8");
        if ( mysqli_connect_error() ) {
            echo " Error de conexion ".mysqli_connect_errno()."<BR>";
        }
    }

    public function insert($sql=""){
        return $this->query($sql) ? "ok" : "error";
    }
     
    public function getDatos($sql=""){
        $result = $this->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDatosArray ($sql=""){
        $result = $this->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
}








