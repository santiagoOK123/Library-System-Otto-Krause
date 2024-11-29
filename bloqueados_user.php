<?php require "./config/config.php"?>
<?php  require "./libs//App.php"?>
<?php 

    $app = new App;
    if(isset($_GET['id_orden'])){
        $id_orden = $_GET['id_orden'];
        $query_ord = "SELECT * FROM orden WHERE id_orden = $id_orden";
        $ord = $app->selectOne($query_ord);

        $query_user = "SELECT * FROM usuario WHERE DNI = $ord->DNI";
       
        $user_bloq = $app->selectOne($query_user);

       
    
        

      

        $query_ord_lib = "SELECT * FROM orden_libro WHERE id_orden=$ord->id_orden";
        $ord_lib = $app->selectOne($query_ord_lib);
        $query_lib = "SELECT * FROM libro WHERE id_libro = '$ord_lib->id_libro'";
        $lib = $app->selectOne($query_lib);

        $query_bloq_extra = "SELECT * FROM bloqueo_dias_extra";
        $bloq_extra_time = $app->selectOne($query_bloq_extra);
        
        $query_time_bloq = "SELECT * FROM bloqueo_dias_extra WHERE id_bloqueo_exta = 1";
        $time_bloq = $app->selectOne($query_bloq_extra);

        if(isset($_POST['submit'])){
            
          

           

           
            $time_extra =  $time_bloq->dias_extra;
           
            $query_update_ord = "UPDATE orden SET fecha_devolucion = DATE_ADD(fecha_devolucion, INTERVAL $time_extra DAY), estado = 'En curso' WHERE DNI = $dni_bloq";
            $app->update($query_update_ord);

            $query_delete_bloq = "DELETE FROM bloqueo WHERE DNI=$dni_bloq";
            $path = "bloqueados.php";
            $app->delete($query_delete_bloq,$path);

            
        }

        if(isset($_POST['devol'])){

            $cod_devol_ing = $_POST['cod_devol'];
    
            
    
    
    
            if($cod_devol_ing === $ord->codigo_reserva){
                
                
    
                $query_ord_lib_list = "SELECT * FROM orden_libro WHERE id_orden = $ord->id_orden";
                $ord_lib_list = $app->selectAll($query_ord_lib_list);
            
                foreach($ord_lib_list  as $ord_lib){
                    
                    $query_update_lib = "UPDATE libro SET disponible = 1 WHERE id_libro = $ord_lib->id_libro";
                    $app->update($query_update_lib);
                }
                $query_delete_ord_lib = "DELETE FROM orden_libro WHERE id_orden = $ord->id_orden";
                $app->update($query_delete_ord_lib);
            
                
            
                $path = "index.php";
                
            
                $query_delete_ord = "DELETE FROM orden WHERE id_orden = $ord->id_orden";
                $app->delete($query_delete_ord,$path);
            }else{
                echo 'los codigos no coinciden';
            }
        }


    }
?>
<?php include("./template/nav.php"); ?>


<link rel="stylesheet" href="./css/bloq_user_style.css"/>

<div class="cont_gen_bloq_user">
   
    <div class="cont_header_bloq">
            <h1>Bloqueados</h1>
            
        </div>
    
    <div class="cont_principal_bloq_user">

            <div class="cont_user_icon_bloq_user">
                <div class="cont_sub_icon_bloq_user">
                    <img class="perfil_bloq_user" src="./img/perfil.png" alt="">
                    <button class="bloq_option"><img src="./img/config_icon_w.png" alt=""></button>
                </div>
                
                <div class="cont_bloq_user_name">
                    <h2><?php echo $user_bloq->nombre?></h2>
                    <h2 class="bloq_state">Bloqueado</h2>
                </div>
                
               
            </div>

            <div class="cont_sub_princ_bloq_user">
                <div class="cont_estado_bloq_user">
                    <h2>Estado de reserva: <?php echo $ord->estado?></h2>
                    <div class="cont_info_user_bloq_user">
                        <p>Informacion del alumno:</p>
                        <div class="cont_datos_bloq_user">
                            <p>DNI:<?php echo $user_bloq->DNI?></p>
                            <p>Curso: 6°1</p>
                            <p>Turno: tarde</p>
                            <p>Especialidad: Computacion</p>
                            <p>Veces bloqueado: 1</p>
    
                        </div>
    
                    </div>
                </div>
                <div class="cont_info_gen_lib_bloq_user">
                    <p>Informacion del libro:</p>
                    <div class="cont_info_lib_bloq_user">
    
                        <div class="cont_datos_lib_bloq_user">
                            <img src="./img/portadas/Portada_17.png" alt="">
                            <div class="cont_text_datos_lib_bloq_user">
                                <p>Titulo: <?php echo $lib->titulo?></p>
                                <p>Autor: <?php echo $lib->autor?></p>
                                <p>Editorial: <?php echo $lib->id_editorial?></p>
                                <p>N° de edicion: <?php echo $lib->numero_edicion?></p>
                                <p>Ubicacion: <?php echo $lib->ubicacion?></p>
                                <p>Desde: <?php echo $ord->fecha_retiro?></p>
                                <p>Hasta: <?php echo $ord->fecha_devolucion?></p>
                            </div>
                        </div>
    
                    </div>
    
                    <form class="cont_devo_bloq_user" method="POST" action="bloqueados_user.php?DNI=<?php echo $dni_bloq?>">
                        <input type="text" placeholder="Ingresar N° de devolucion" name="cod_devol">
                        <button type="submit" name="devol">Devolver</button>
    
                    </form>
    
                </div>

            </div>

    </div>

</div>

<div class="overlay_bloq_user">
    <div class="modal_bloq_user">
        <h2>¿Desea dar mas tiempo extra?</h2>
        <h3><?php echo $time_bloq->dias_extra?> dias extra</h3>
        <form action="bloqueados_user.php?DNI=<?php echo $dni_bloq?>" method="POST" class="modal_buttons_bloq_user">
            <button type="submit" name="submit" class="conf_bloq_user">Confirmar</button>
            <button class="cancel_bloq_user">Cancelar</button>
        </form>
    </div>
</div>




<script> 
    const modal_bloq_user = document.querySelector('.overlay_bloq_user')
    const openModal = document.querySelector('.bloq_option')
    const closeModal = document.querySelector('.cancel_bloq_user')
    const confModal = document.querySelector('.conf_bloq_user')

    openModal.addEventListener('click', ()=> {
        modal_bloq_user.classList.add('open')
    })

    closeModal.addEventListener('click', ()=> {
        modal_bloq_user.classList.remove('open')
    })

    confModal.addEventListener('click', ()=> {
        modal_bloq_user.classList.remove('open')
    })



</script>





<?php include("./template/pie_pag.php"); ?>