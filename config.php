<?php require "./config/config.php"?>
<?php  require "./libs//App.php"?>
<?php
    session_start();
    $app = new App;

    $query_admins = "SELECT * FROM admins";
    $list_admins = $app->selectAll($query_admins);
    if (isset($_SESSION['DNI'])){
        $query_time_bloq_act = "SELECT * FROM bloqueo_dias_extra WHERE id_bloqueo_extra = 1";
        $bloq_extra_act = $app->selectOne($query_time_bloq_act);
        $admin_dni = $_SESSION['DNI'];
        $query_admin = "SELECT * FROM admins WHERE DNI = $admin_dni";
        $admin = $app->selectOne($query_admin);

        if(isset($_POST['submit'])){
        
            if(isset($_SESSION['selected_admin'])){
                
                if(isset($_POST['password'])){
                    $password = $_POST['password'];
                    if($password == $admin->password){
                        $selected_id_admin = $_SESSION['selected_admin'];
                        $query_delete_admin = "DELETE FROM admins WHERE id_admin = $selected_id_admin";
                        $path = "index.php";
                        $app->delete($query_delete_admin, $path);
                        unset($_POST['password']);
                        
                    }
    
                }else{
                    echo "caballero";
                }
                
    
            }

            if(isset($_POST['tiempodebloq'])){
                $tiempo_bloq = $_POST['tiempodebloq'];

                $query_update_bloq_time = "UPDATE bloqueo_dias_extra SET dias_extra = $tiempo_bloq WHERE id_bloqueo_extra = 1";
                $app->update($query_update_bloq_time);

               
                unset($_POST['tiempodebloq']);
            }

            if(isset($_POST['new_password'])){

                $password_act = $_POST['password_act'];
                $new_password = $_POST['new_password'];
                if($password_act == $admin->password){
                    $query_new_password = "UPDATE admins SET password = $new_password WHERE id_admin = $admin->id_admin";
                    $app->update($query_new_password);

                    unset($_POST['new_password']);
                    unset($_POST['password_act']);
                    

                    
                }

            }
    
            
        }else{
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Procesa datos enviados desde AJAX
                $input = file_get_contents('php://input');
                $data = json_decode($input, true);
            
                if (isset($data['id_admin'])) {
                    $id_admin = $data['id_admin'];
                    $_SESSION['selected_admin'] = $id_admin; // Guarda en la sesión
            
                    // Responde con éxito
                    echo json_encode(['success' => true, 'id_admin' => $id_admin]);
                } else {
                    // Responde con error
                    echo json_encode(['success' => false, 'message' => 'ID no recibido']);
                }
                
                exit; // Finaliza la ejecución del script para la solicitud AJAX
            }
    
        }

    }else{
        //echo "BASTA";
    }
    
    

    


?>

<?php include("./template/nav.php"); ?>

<link rel="stylesheet" href="./css/configuration_style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<div class='cont_principal_admconfig'>

    <h1>Configuración</h1>

    <div class='cont_gen_buttons_admconfig'>

        <div class='cont_cuen_admconfig'>

            <h2>Cuenta</h2>
            <button class='remove_admin_button_admconfig'>Remover administradores</button>
            <button class='change_password_admconfig'>Cambiar contraseña</button>

        </div>
        <div class='cont_adm_admconfig'>
            <h2>Administración</h2>
            <button class='change_time_admconfig'>Cambiar tiempo de bloqueo</button>
            <button class='remove_hist_admconfig'>Eliminar historial</button>

        </div>



    </div>



</div>

<div class="overlay">
    <form class="modal_gen_pe" action="config.php" method="POST">
        <div class="modal_gen_header">
            <p class="modal_titulo">Placeholder</p>
            <button class="close_button">X</button>
        </div>


        <div class="modal_remove_admin">

            <div #swiperRef="" class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <?php foreach($list_admins as $admin) : ?>
                    <div class="swiper-slide" id="<?php echo $admin->id_admin?>"><img src="./img/perfil.png" alt="" />
                        <p><?php echo $admin->nombre?></p>
                    </div>
                    <?php endforeach;?>
                    
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>

            <div class='cont_ing_password_remove_admconfig'>
                <div class='cont_test_config'>
                    <h2>Ingrese su contraseña para confirmar:</h2>
                    <input type="password" name="password"/>
                </div>
            </div>
        </div>

        <div class="modal_change_password">
            <p><?php echo $admin->nombre?></p>
            <div>
                <input type="text" name="password_act" placeholder="Contraseña actual">
                <input type="text" name="new_password" placeholder="Contraseña nueva">
            </div>

        </div>

        <div class="modal_change_time">
            <h2>Tiempo de bloqueo:</h2>
            <select name="tiempodebloq" id="tiempodebloq">
                <option value=<?php echo $bloq_extra_act->dias_extra?>><?php echo $bloq_extra_act->dias_extra?> dias - actuales</option>
                <option value="5">5 dias </option>
                <option value="10">10 dias</option>
                <option value="30">30 dias</option>
            </select>

        </div>

        <div class="modal_delete_historial">
            <div class='cont_select_delete_admconfig'>
                <p>Borrar historial de:</p>
                <select value="" name="delete_historial" id="select_delete_historial">
                    <option value="">Seleccionar</option>
                    <option value="Alumnos">Alumnos</option>
                    <option value="Profesores">Profesores</option>
                    <option value="Graduados">Graduados</option>
                    <option value="Todos">Todos</option>
                </select>

            </div>

            <div class="cont_ing_dni_alum_admconfig">
                <p>Dni del alumno:</p>
                <input type="number" />
            </div>

            <div class="cont_ing_dni_prof_admconfig">
                <p>Dni del profesor:</p>
                <input type="number" />
            </div>

            <div class='cont_ing_password_admconfig'>
                <p>Ingresar contraseña para confirmar:</p>
                <input type="password" />
            </div>
        </div>



        <button class="conf_button" type="submit" name="submit">Confirmar</button>

    </form>

</div>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 3,
        centeredSlides: true,
        spaceBetween: 40,
        pagination: {
            el: ".swiper-pagination",
            type: "fraction",
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    

    const modal_gen = document.querySelector('.overlay')
    const modals = document.querySelectorAll('div');


    const modal_1 = document.querySelector('.modal_remove_admin')
    const modal_2 = document.querySelector('.modal_change_time')
    const modal_3 = document.querySelector('.modal_change_password')
    const modal_4 = document.querySelector('.modal_delete_historial')

    const openModal_1 = document.querySelector('.remove_admin_button_admconfig');
    const openModal_2 = document.querySelector('.change_time_admconfig');
    const openModal_3 = document.querySelector('.change_password_admconfig');
    const openModal_4 = document.querySelector('.remove_hist_admconfig');


    const closeModal = document.querySelector('.close_button')
    const confModal = document.querySelector('.conf_button')

    const dni_alum_input = document.querySelector('.cont_ing_dni_alum_admconfig')
    const dni_prof_input = document.querySelector('.cont_ing_dni_prof_admconfig')
    const select_open_value = document.getElementById('select_delete_historial')

    select_open_value.addEventListener('change', function() {
        const valorSeleccionado = select_open_value.value;

        switch (valorSeleccionado) {
            case "Alumnos":
                dni_alum_input.classList.add('open')
                dni_prof_input.classList.remove('open')
                break;
            case "Profesores":
                dni_prof_input.classList.add('open')
                dni_alum_input.classList.remove('open')
                break;

            default:
                dni_alum_input.classList.remove('open')
                dni_prof_input.classList.remove('open')
                break;
        }

    });

    openModal_1.addEventListener('click', (e) => {
        e.preventDefault();
        modal_gen.classList.add('open')
        modal_1.classList.add('open')

    })

    openModal_2.addEventListener('click', (e) => {
        e.preventDefault();
        modal_gen.classList.add('open')
        modal_2.classList.add('open')

    })

    openModal_3.addEventListener('click', (e) => {
        e.preventDefault();
        modal_gen.classList.add('open')
        modal_3.classList.add('open')

    })

    openModal_4.addEventListener('click', (e) => {
        e.preventDefault();
        modal_gen.classList.add('open')
        modal_4.classList.add('open')

    })


    closeModal.addEventListener('click', (e) => {
        e.preventDefault();
        modal_gen.classList.remove('open')
        modals.forEach(modal => {
            modal.classList.remove('open');
        });
    })

    confModal.addEventListener('click', (e) => {
        modal_gen.classList.remove('open')
        modals.forEach(modal => {
            modal.classList.remove('open');
        });
    })


    const swiperSlides = document.querySelectorAll('.swiper-slide');

            // Añade un evento de clic a cada slide
            swiperSlides.forEach(slide => {
                slide.addEventListener('click', function () {
                    const adminId = this.id; // Obtiene el ID del admin

                    // Envía el ID al servidor mediante fetch
                    fetch('', { // Mismo archivo PHP
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id_admin: adminId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Admin ID actualizado:', adminId);

                            // Remueve la clase activa de todos los slides
                            swiperSlides.forEach(s => s.classList.remove('active'));

                            // Añade la clase activa al elemento clickeado
                            this.classList.add('active');

                            // Actualiza el texto del administrador seleccionado
                            const adminText = document.querySelector('p');
                           
                        } else {
                            console.error('Error al actualizar el Admin ID:', data.message);
                        }
                    })
                    .catch(error => console.error('Error en la solicitud:', error));
                });
            });

</script>













<?php include("./template/pie_pag.php"); ?>