<?php

    function conectarDB(){
        $db=mysqli_connect('localhost', 'root', '', 'agendaBD');
        if(!$db){
            echo "No se conectó";
            exit;
        }
        return $db;
    }

?>