<?php require "../config/config.php"?>
<?php  require "../libs/App.php"?>

<?php
    session_start();
    $app = new App;
    $path_search = "../usuario_pages/user_search.php";
    $app->validateSession($path_search);
    if(isset($_POST['submit'])){

        $dni = $_POST['dni'];
        $password = $_POST['password'];

       
        

        $query = "SELECT * FROM usuario WHERE DNI='$dni'";

        $data = [
            "dni" => $dni,
            "password" => $password,
        ];

        
        $path = "../usuario_pages/user_search.php";

        $app->login($query, $data, $path);

        $query_admin = "SELECT * FROM admins WHERE DNI ='$dni' ";

        $path_admin = "http://localhost/proyecto_biblioteca_admin/index.php";

        $app->login_admin($query_admin, $data, $path_admin);

        if($app->login($query, $data, $path) === false){
            if($app->login_admin($query_admin, $data, $path_admin) === false){
                echo "DNI o contraseña invalidos";
                exit; 
            }

        }
        

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