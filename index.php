<?php
    require './includes/templates/funciones.php'; 
    require './includes/config/database.php';
    session_start();

    $auth = estarAutenticado();
    if (!$auth) {
        header('Location: /regid.php');
    }

    $db = conectarDB();
    $contactName = '';
    $phoneNo = '';
    $errores = array();

    $query = "SELECT * FROM contactos WHERE idUsuario = (SELECT id FROM usuarios WHERE username = '{$_SESSION['usuarios']}')";
    
    $resultadoSelect = mysqli_query($db, $query);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['contacto-nuevo'])){
            $contactName = mysqli_real_escape_string($db, $_POST['contactName']);
            $phoneNo = mysqli_real_escape_string($db, $_POST['phoneNo']);
            
            if (!$contactName) {
                $errores[] = 'Debe introducir un nombre';
            }
            
            if (!$phoneNo) {
                $errores[] = 'Debe introducir un número de teléfono';
            }
            
            if (empty($errores)) {
                $selectQuery = "INSERT INTO contactos (contactname, phoneNo, idUsuario)
                SELECT '${contactName}', '${phoneNo}', usuarios.id
                FROM usuarios
                WHERE usuarios.username = '{$_SESSION['usuarios']}'";
                
                echo $selectQuery;
                $resultado = mysqli_query($db, $selectQuery);
                
                if ($resultado) {
                    //Para que se vean los campos insertados en la tabla sin tener que refrescar la página
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                } else {
                    $errores[] = 'Error al insertar el contacto: ' . mysqli_error($db);
                }
            }
        } else if(isset($_POST['delete-contacto'])){
            $contactNameToDelete = mysqli_real_escape_string($db, $_POST['delete-contacto']);
            $query = "DELETE FROM contactos where contactName='{$contactNameToDelete}' AND idUsuario = (SELECT id FROM usuarios WHERE username= '{$_SESSION['usuarios']}')";
            $resultado = mysqli_query($db, $query); 
            echo $query;
            if ($resultado) {
                  //Para que se vean borren los campos insertados en la tabla sin tener que refrescar la página
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            } else {
                $errores[] = 'Error al borrar la agenda ' . mysqli_error($db);
            }   
        } else if(isset($_POST['delete-complete'])){
            $query = "DELETE FROM contactos where idUsuario = (SELECT id FROM usuarios WHERE username= '{$_SESSION['usuarios']}')";
            $resultado = mysqli_query($db, $query); 
            echo $query;
            if ($resultado) {
                 //Para borrar los campos de la agenda sin tener que refrescar la página
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            } else {
                $errores[] = 'Error al borrar la agenda ' . mysqli_error($db);
            }
        }
    }
?>

<link rel="stylesheet" href="./css/style.css">
<div class="error">
    <?php
            foreach($errores as $error){
                echo "<br> $error </br>";
            }
            ?>
    </div>
  
            
<div class="container">
<div class="btn-rbd">
       <?php if($auth) { ?>
        <a href="cerrar-sesion.php" class="cerrar">Cerrar Sesión</a>
        <?php } ?>
    </div>
        <div class="split left">
            <h1 class="title">Introducir contacto</h1>
           <form method="POST" action="index.php" enctype="multipart/form-data">
            <div class="input__left">
               <input type="text" name="contactName" value="<?php echo $contactName; ?>" placeholde="Nombre">
               <input type="text" name="phoneNo" value="<?php echo $phoneNo; ?>">
               <input type="submit" value="Contacto nuevo" placeholder="Telefono" class="btn-contacto" name="contacto-nuevo">
            </div>
            </form> 
        </div>
       
        <div class="split right">
        <h1 class="title">Ver contactos</h1>    
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th class="tl">Telefono</th>
                    <th>Opciones     
                    </th>
                </tr>
            </thead>
            <tbody>
            <?php while ($contactos=mysqli_fetch_assoc($resultadoSelect)) { ?>    
                <tr>
                    <td><?php echo $contactos['contactname'] ?></td>
                    <td class="tl"><?php echo $contactos['phoneNo'] ?></td>
                    <td class="btn-options">
                        <a href="./actualizar.php?id=<?php echo $contactos['idContacto'] ?>" class="update">Actualizar</a>
                        <form method="post" action="index.php">
                            <input type="hidden" name="delete-contacto" value="<?php echo $contactos['contactname'] ?>">
                            <input type="submit" class="btns cerrar" value="Eliminar">
                        </form>
                    </td>
                </tr>
            <?php } ?>    
            
            <form method=POST>
                <button type="submit" name="delete-complete" class="btns cerrar delete" >
                  Borrar agenda
                </button>
            </form>
                <!-- <a href="" class="btns cerrar delete" name="delete-complete">Borrar agenda</a>   -->
                </tbody>
            </table>
        </div>
    </div>

    <script src="./js/index.js"></script>