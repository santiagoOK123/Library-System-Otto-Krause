<?php require "../config/config.php"?>
<?php  require "../libs/App.php"?>

<?php

    $app = new App;

    if(isset($_POST['submit'])){

        $dni = $_POST['dni'];
        $password = $_POST['password'];

       

        $query = "SELECT * FROM usuario WHERE DNI='$dni'";

        $data = [
            "dni" => $dni,
            "password" => $password,
        ];

        $path = "http://localhost/proyecto_biblioteca_admin/usuario_pages/user_search.php";

        $app->login($query, $data, $path);

    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user_login_style.css">
    <title>Login</title>
</head>

<body>
    <div class="container_l">
        <a href="user_home.php">
        <img class="back-imagen" src="../img/back.png" alt="Back" />
        </a>

        <a href="user_home.php" class="back-link">
        Volver atrás
        </a>

        <main class="main_l">
            <img src="../img/logo.png" alt="Logo Krause" class="logo_l" />
            <form
                action="user_login.php"
                method="POST"
                class="login-form">
                <div class="form-group_l">
                    <label for="dni">DNI</label>
                    <input
                        type="text"
                        id="dni"
                        name="dni"
                        required />
                </div>
                <div class="form-group_l">
                    <label for="password">Contraseña</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required />
                </div>
                <div class="forgot-password_l">
                    <a href="user_recover_pass.php">¿Olvidaste tu contraseña?</a>
                </div>
                <button name="submit" type="submit" id="login-btn">
                    Iniciar sesión
                </button>

            </form>
        </main>
    </div>
</body>

</html>