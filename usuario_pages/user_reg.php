<?php require "../config/config.php"?>
<?php  require "../libs/App.php"?>

<?php
    session_start();
    $app = new App;
    $path_search = "user_search.php";
    $app->validateSession($path_search);
    if(isset($_POST['submit'])){

        $email = $_POST['email'];
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        if ($_POST["password"] !== $_POST["password_conf"]){
            echo "Las contraseñas no coinciden.";
            exit;
        }
        
        if (!(is_numeric($dni) && strlen((string)$dni) === 8)) {
       
            echo "DNI invalido";
          
            
            exit;
        } 

        $queryc = "SELECT * FROM usuario WHERE email='$email' OR DNI = $dni";

        if($app->checkEmailExists($queryc) === true){
            echo "Ya existe un usuario con ese Email o DNI";
            exit;

        }
        
        
        $query = "INSERT INTO usuario (email, DNI, nombre, apellido, password) VALUES(:email, :dni, :nombre, :apellido, :password)";
       
        $arr = [
            ":email" => $email,
            ":dni" => $dni,
            ":nombre" => $nombre,
            ":apellido" => $apellido,
            ":password" => $password,
        ];

        $path = "user_login.php";

        $app->register($query, $arr, $path);

    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user_login_style.css">
    <title>Register</title>
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
                action="user_reg.php"
                method="POST"
                class="login-form">

                <div class="form-group_l">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        required />
                </div>

                <div class="form-group_l">
                    <label for="dni">DNI</label>
                    <input
                        type="text"
                        id="dni"
                        name="dni"
                        required />
                </div>

                <div class="form-group_l">
                    <label for="nombre">Nombre</label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        required />
                </div>

                <div class="form-group_l">
                    <label for="apellido">Apellido</label>
                    <input
                        type="text"
                        id="apellido"
                        name="apellido"
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

                
                <div class="form-group_l">
                    <label for="password_conf">Repetir Contraseña</label>
                    <input
                    type="password"
                    id="password_conf"
                    name="password_conf"
                    required/>
                </div>
                <button name="submit" type="submit" id="login-btn">
                    Registrarse
                </button>

            </form>
        </main>
    </div>
</body>

</html>