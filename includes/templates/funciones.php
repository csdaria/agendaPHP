<?php
    function estarAutenticado(): bool{
        $auth=$_SESSION['login'];

        if($auth){
            return true;
        }else{
            return false;
        }
    }