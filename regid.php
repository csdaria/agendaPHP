<?php 
    require './includes/templates/funciones.php'; 
    require './includes/config/database.php';
    $db=conectarDB();
    $username='';
    $email='';
    $password= '';
    $repeatPassword='';
    $errores=array();

    $contactName='';
    $phoneNo='';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['REGISTER'])){
            $username = mysqli_real_escape_string($db, $_POST['username']);
            $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
            $password = mysqli_real_escape_string($db, $_POST['password']);
            $repeatPassword = mysqli_real_escape_string($db, $_POST['password']);
            
            if (!$username) {
                $errores[] = 'No se ha proporcionado ningún nombre;';
            }
            
            if (!$email) {
                $errores[] = 'No se ha proporcionado ningún email;';
            }
            
            if (!$password) {
                $errores[] = 'Contraseña no introducida';
            }
            
            if ($password !== $repeatPassword) {
                $errores[] = 'Las contraseñas no coinciden';
            }
            
            if (empty($errores)) {
                $hashPassword = password_hash($password, PASSWORD_DEFAULT);
                
                $query = "INSERT INTO usuarios (username, email, contrasenia) VALUES ('$username', '$email', '$hashPassword');";
                $resultado = mysqli_query($db, $query);
                
                if ($resultado) {
                    echo "Registro realizado con éxito, ya puede iniciar sesión";
                } else {
                    $errores[] = 'Error al registrar el usuario';
                }
            }
        }else if (isset($_POST['LOGIN'])) {
            $username=mysqli_real_escape_string($db, $_POST['username']);
            $password=mysqli_real_escape_string($db, $_POST['password']);
    
            if(!$username){
                $errores[] = 'No se ha aportado ningún email;';
            }
    
            if(!$password){
                $errores[] = 'Password no introducido';
            }
    
            if(empty($errores)){
                $query="SELECT * FROM usuarios WHERE username='${username}';";
                $resultado=mysqli_query($db, $query);
    
                if($resultado->num_rows){
                    $usuario=mysqli_fetch_assoc($resultado);
    
                    $auth=password_verify($password, $usuario["contrasenia"]);
    
                    if($auth){
                        session_start();
    
                        $_SESSION['usuarios'] = $usuario["username"];
                        $_SESSION['login'] = true;
                        header('Location: /index.php');
                    }else{
                        $errores[]="Password incorrecto";
                    }
                }else{
                    $errores[]="El usuario no existe";   
                }
            
            }
        }
    }

?>
    <link rel="stylesheet" href="./css/style.css">
    <div class="error">
        <?php 
            foreach($errores as $error){
                
                echo "<br> $error<br>";            
            }
            ?>
    </div>
    <div class="container">
        
        <div class="split left">
            <h1 class="title">Registro</h1>
           <form method="POST">
               <div class="input__left">

                   <input type="text" name="username" value="<?php echo $username ?>" placeholder="Nombre de usuario">
                   <input type="text" name="email" value="<?php echo $email ?>" placeholder="Email">
                   <input type="password" name="password" value="password" placeholder="Introducir contraseña: ">
                   <input type="password" name="password" value="password" placeholder="Repetir contraseña: ">
                   <input type="submit" value="Enviar" name="REGISTER" class="btn black">
                </div>
                </form> 
            </div>
        <div class="split right">
            <h1 class="title">Inicio de sesión</h1>
        <form method="POST">
        <div class="input__right">

            <input type="text" name="username" value="<?php echo $username ?>" placeholder="Nombre de usuario ">
            <input type="password" name="password" value="<?php echo $password ?>" placeholder="Contraseña ">
            <input type="submit" value="Iniciar sesión" name="LOGIN" class="btn blue">
        </form>
        </div>
        </div>
    </div>

    <script src="./js/index.js"></script>

