<?php require "../config/config.php"?>
<?php  require "../libs/App.php"?>
<?php  
    session_start();
    $app = new App;
    $path_search = "user_search.php";
    $app->validateSession($path_search);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../css/user_home_t_style.css"/>
</head>

<body>
    <div class="Home_container">
        <div class="home_cont_principal">
            <img src="../img/side_home_bk.webp" alt="" class="side_bk_home" />
            <div class="laptop_cont">
                <img src="../img/laptop_home.png" class="laptop_home" />
            </div>


            <nav class="home_nav">
                <div class="logo_div_h">
                    <img src="../img/logo.png" class="logo_h" />
                </div>
                <div class="links_container">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
                        <a href="../backend/logout.php" id="logoutButton" class="login_h">Cerrar sesión</a>
                    <?php else: ?>
                        <a href="user_login.php" id="loginButton" class="login_h">Iniciar sesión</a>
                        <a href="user_reg.php" id="regButton" class="login_h">Registrarse</a>
                    <?php endif; ?>
                </div>
            </nav>

            <div class="content_h">
                <div class="content_text_h">
                    <div class="title_content_h">
                        <h1>Encuentra el libro que necesites</h1>
                    </div>
                    <div class="paragraph_content_h">
                        <p>
                            Accede a todos los libros de la biblioteca del colegio.
                            Encuentra el que necesites, resérvalo y pásalo a buscar.
                        </p>
                    </div>
                    <div class="button_search_h">
                        <a href="user_search.php" class="buscar_libro_h">
                        Buscar libro 🡆
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>