<?php require "../config/config.php"?>
<?php  require "../libs/App.php"?>
<?php  require "../backend/mail.php"?>
<?php 

$app = new App;

if(isset($_POST['submit'])){
    $dni_input = $_POST['dni'];
    $query_check_dni = "SELECT * FROM usuario WHERE DNI  = $dni_input";

    if($app->checkEmailExists($query_check_dni) == true){
        echo "
        <script>
            alert('¡El correo se ha enviado!');
            
        </script>
        ";
        $user = $app->selectOne($query_check_dni);

        $email = $user->email;

        $token = bin2hex(random_bytes(16));
        $token_hash = hash("sha256",$token);

        $expire = date("Y-m-d H:i:s", time() + 60 * 30);

        $query_expire_time = "UPDATE usuario SET reset_token_hash = '$token_hash', reset_token_expires_at = '$expire' WHERE DNI = $dni_input";
        $app->update($query_expire_time);


        $mail->setFrom("noreply@example.com");
        $mail->addAddress($email);
        $mail->Subject = "Reiniciar contrasenia";
        
        $mail->Body = <<<END

        Click <a href="http://localhost/proyecto_biblioteca_admin/usuario_pages/user_new_password.php?token=$token">Aqui</a>
        Para reiniciar tu contraseña.
        END;

        $mail->send();

        

    }else{
        echo "DNI invalido";
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
            <form action="user_recover_pass.php" method="POST" class="login-form_r">
                <div class="form-group_r">
                    <label for="dni">Documento</label>
                    <input type="text" id="dni" name="dni" required />
                </div>
                <button type="submit" name="submit" id="login-btn">
                    Enviar
                </button>
            </form>
        </main>
    </div>

    <?php if(isset($expire)) :?>
    <div id="confirmationMessage" class="hidden_r">
        ¡El correo se ha enviado!
    </div>
    <?php endif;?>
</body>

</html>