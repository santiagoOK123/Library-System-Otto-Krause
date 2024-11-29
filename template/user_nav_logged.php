<?php 
    session_start();
?>
<link rel="stylesheet" href="../css/user_nav_login_style.css">

<header>
    <div class="cont_nav">
        <img class="otto_log_n" src="../img/ottolog.webp" />
        <?php if (isset($_SESSION['user_id'])): ?>
            <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
            <div class="cont_buttons">
            <img
                class="camp_icon_f"
                src="../img/campana.webp"
                id="camp_open"
                onclick="camp_open()" />
            <img class="carr_icon" src="../img/carr.png"  onclick="to_carr()"/>
            <img
                class="user_icon"
                src="../img/perfil.png"
                id="user_open"
                onclick="user_open()" />
            <div class="cont_camp_desp" id="sub_menu_camp">
                <ul>
                    <li class="cont_lib_camp">
                        <div>
                            <img src="../img/portadas/Portada_11.png" />
                        </div>
                        <div class="lib_camp_side">
                            <p>Placeholder</p>
                            <h3 class="disp">Libro disponible</h3>
                        </div>
                    </li>



                    <li class="cont_lib_camp">
                        <div>
                            <img src="../img/portadas/Portada_11.png" />
                        </div>
                        <div class="lib_camp_side">
                            <p>Placeholder</p>
                            <h3 class="no_disp">No disponible</h3>
                            <img src="../img/cubo.png" />
                        </div>
                    </li>

                    <li class="cont_lib_camp">
                        <div>
                            <img src="../img/portadas/Portada_15.png" />
                        </div>
                        <div class="lib_camp_side">
                            <p>Placeholder</p>
                            <h3 class="disp">Libro disponible</h3>
                        </div>
                    </li>

                </ul>
            </div>

            <div class="cont_user_desp" id="sub_menu_user">
                <div class="cont_list_deseos">
                    <img src="../img/fav.webp" />
                    <a href="user_favs.php">Lista de deseos</a>
                </div>

                <div class="cont_mis_ord">
                    <img src="../img/ord.png" />
                    <a href="user_ords.php">Mis ordenes</a>
                </div>

                <div class="cont_ord_fin">
                    <a href="user_ords_fin.php">Ordenes finalizadas</a>
                </div>

                <div class="cont_asist">
                    <a class="user_link" href="user_asist.php">
                        Asistencia al usuario
                    </a>
                </div>
                <a class="cerr_ses" href="../backend/logout.php">
                    <img class="end_icon" src="../img/endsess.png" />
                    Cerrar sesion
                </a>
            </div>
        </div>
        <?php else: ?>
            <a href="user_login.php" id="loginButton" class="login_h">Iniciar sesión</a>
            <a href="user_reg.php" id="regButton" class="login_h">Registrarse</a>
        <?php endif; ?>

    </div>
</header>


<script>
    const camp_desp = document.querySelector(".cont_camp_desp")
    const user_desp = document.querySelector(".cont_user_desp")

    function camp_open() {
        if (document.querySelector('.cont_camp_desp.open-menu')) {
            camp_desp.classList.remove("open-menu")
        } else {
            user_desp.classList.remove("open-menu")
            camp_desp.classList.add("open-menu")
        }
    }

    function user_open() {
        if (document.querySelector('.cont_user_desp.open-menu')) {
            user_desp.classList.remove("open-menu")
        } else {
            camp_desp.classList.remove("open-menu")
            user_desp.classList.add("open-menu")
        }
    }

    function to_carr() {
    const carrito = localStorage.getItem('carrito');
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'user_carrito.php';
    
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'carrito';
    input.value = carrito;
    
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
    }

</script>