<?php require "../config/config.php"?>
<?php  require "../libs/App.php"?>

<?php

$app = new App;
$token = $_GET['token'];
$token_hash = hash("sha256",$token);

$query_user = "SELECT * FROM usuario WHERE reset_token_hash = '$token_hash'";

if($app->checkEmailExists($query_user) == true){
    $user = $app->selectOne($query_user);

    if(strtotime($user->reset_token_expires_at) <= time()){
        die("el token expiro");
    }

}else{
    die("token invalido");
}

if(isset($_POST['submit'])){
    $user = $app->selectOne($query_user);
    $input_password = $_POST['password'];
    $conf_password = $_POST['conf_password'];

    if($input_password === $conf_password){
        $input_password_hash = password_hash($input_password, PASSWORD_DEFAULT);
        $query_update_password = "UPDATE usuario SET password = '$input_password_hash' WHERE DNI = $user->DNI";
        $app->update($query_update_password);
        header('Location: http://localhost/proyecto_biblioteca_admin/usuario_pages/user_login.php');
    }else{
        echo "las contraseñas no coinciden";
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/use_recover_pass.css">
    <title>Recover</title>
</head>

<body>
    <div class="container_r">
        <a href="user_login.php">
        <img class="back-imagen" src="../img/back.png" alt="Imagen atras" />
        </a>

        <a href="user_login.php" class="back-link_r">
        Volver atrás
        </a>

        <main>
            <img src="../img/logo.png" alt="Logo Krause" class="logo_r" />
            <form action="user_new_password.php?token=<?php echo $token?>" method="POST" class="login-form_r">
                <div class="form-group_r">
                    <label for="password">Nueva contraseña</label>
                    <input type="text" id="dni" name="password" required />
                    
                   
                </div>
                
                <div class="form-group_r">
                    <label for="conf_password">Confirmar contraseña</label>
                    <input type="text" id="dni" name="conf_password" required />
                    </div>
                <button type="submit" name="submit" id="login-btn">
                    Confirmar
                </button>
            </form>
        </main>
    </div>

    <div id="confirmationMessage" class="hidden_r">
        ¡El correo se ha enviado!
    </div>
</body>

</html>