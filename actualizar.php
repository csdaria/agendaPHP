<?php
require './includes/templates/funciones.php';
require './includes/config/database.php';
session_start();
$auth=estarAutenticado();

$db=conectarDB();

if(!$auth){
    header('Location: /regid.php');
}

$id=$_GET['id'];

$querySelect="SELECT * FROM contactos where idContacto='$id';";
echo $querySelect;
$resultadoSelect=mysqli_query($db,$querySelect);
$contacto=mysqli_fetch_assoc($resultadoSelect); 

$idContacto=$contacto['idContacto'];
$contactname=$contacto['contactname'];
$phoneNo=$contacto['phoneNo'];
$errores=array();

if($_SERVER['REQUEST_METHOD']=='POST'){
    $contactname=mysqli_real_escape_string($db,$_POST['contactname']);
    $phoneNo=mysqli_real_escape_string($db,$_POST['phoneNo']);

    if(!$contactname){
        $errores[]="Debe introducir un nombre de contacto";
    }

    if(!$phoneNo){
        $errores[]= "Debe introducir un número de teléfono";
    }

    if(empty($errores)){
        $queryUpdate= "UPDATE contactos SET contactname='$contactname', phoneNo='$phoneNo' WHERE idContacto='$id';";
        echo $queryUpdate;
        $resultadoUpdate=mysqli_query( $db, $queryUpdate );

        if($resultadoUpdate){
            header('Location: /index.php');
        }
    }
}


?>
<link rel="stylesheet" href="./css/style.css">

<div class="container">
    <form method="POST" class="actualizarForm">
        <input type="text" name="contactname" value="<?php echo $contactname ?>">
        <input type="text" name="phoneNo" value="<?php echo $phoneNo ?>">
        <input type="submit" value="Actualizar">
    </form>
</div>