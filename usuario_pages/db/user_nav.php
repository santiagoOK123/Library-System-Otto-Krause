<?php
   session_start();
   define("APPURL", "http://localhost/proyecto_biblioteca_admin/usuario_pages/user_search.php");
   

?>
<link rel="stylesheet" href="../css/user_nav_login_style.css">

<header>
    
    <div class="cont_nav">
        <img class="otto_log_n" src="../img/ottolog.webp" />
      
        <div class="cont_buttons">
           
            <img class="camp_icon_f" src="../img/campana.webp" id="camp_open" onclick="camp_open()" />
            <img class="carr_icon" src="../img/carr.png" onclick="to_carr()"/>
            
               
                <!-- Usuario logueado -->
                <img class="user_icon" src="../img/perfil.png" id="user_open" onclick="user_open()" />
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
                    <a class="cerr_ses" href="logout.php">
                        <img class="end_icon" src="../img/endsess.png" />
                        Cerrar sesión
                    </a>
                </div>
            
                <!-- Usuario no logueado -->
               
            

        </div>
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

// Función que se ejecuta al hacer clic en el ícono de usuario
    function user_open() {
        const user_desp = document.getElementById('sub_menu_user'); // Asegúrate de usar el ID correcto
        // Si el menú de usuario tiene la clase 'open-menu', la quita, si no, la agrega
        if (user_desp.classList.contains('open-menu')) {
            user_desp.classList.remove('open-menu');
        } else {
            // También puedes cerrar otros menús si es necesario
            document.getElementById('sub_menu_camp').classList.remove('open-menu');
            user_desp.classList.add('open-menu');
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