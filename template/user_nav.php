<?php
 if(!isset($_SESSION)) 
 { 
     session_start(); 
 } 

 $currentUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

// URL que deseas comparar
$desiredUrl = "http://localhost/proyecto_biblioteca_admin/usuario_pages/user_search.php";
 

   

?>
<link rel="stylesheet" href="../css/user_nav_login_style.css">
<link rel="stylesheet" href="../css/user_nav_non_login_style.css">
<?php if (isset($_SESSION['email'])) :?>

    
    <?php if ($currentUrl !== $desiredUrl) :?>
        <header>
            <div class="cont_nav">
                <a href="../usuario_pages/user_home.php">
                <img class="otto_log_n" src="../img/ottolog.webp" />
                </a>
            

        
    <?php endif;?> 
        
        <div class="cont_buttons">
        
            
            <img class="carr_icon" src="../img/carr.png" onclick="to_carr()"/>
            
               
                <!-- Usuario logueado -->
                <img class="user_icon" src="../img/perfil.png" id="user_open" onclick="user_open()" />
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
                        Cerrar sesión
                    </a>
                </div>
       
            
                <!-- Usuario no logueado -->
               
            

        </div>
<?php if ($currentUrl !== $desiredUrl) :?>
    </div>
    
</header>
<?php endif;?> 
        

<?php else:?>
            <?php if ($currentUrl !== $desiredUrl) :?>
                <header>
                    <div class="cont_nav">
                    <img class="otto_log_n" src="../img/ottolog.webp" />

                
            <?php endif;?> 
                    <div class="cont_nv_nol">
                  
                        <div class="cont_login_nol">
                            <a href="user_login.php" >Iniciar sesión</a>
                        </div>
                     </div>
                <?php if ($currentUrl !== $desiredUrl) :?>
                </div>
                
                </header>
                <?php endif;?> 
         
<?php endif;?> 
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
            window.location.href = 'user_carrito.php'; 
        }
    
        

</script>