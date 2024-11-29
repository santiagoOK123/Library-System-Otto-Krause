

<?php include("./template/nav.php"); ?>
<?php require "./config/config.php"?>
<?php  require "./libs/App.php"?>
<?php
   

   
   $app = new App;
   if (isset($_GET['id_orden'])){
    $id_orden = $_GET['id_orden'];

    $query_ord = "SELECT * FROM orden WHERE id_orden=$id_orden";
    $ord = $app->selectOne($query_ord);
    $query_user = "SELECT * FROM usuario WHERE DNI=$ord->DNI";
    $user = $app->selectOne($query_user);
    $query_ord_lib = "SELECT * FROM orden_libro WHERE id_orden = $ord->id_orden ORDER BY id_libro ASC LIMIT 1";
    $ord_lib = $app->selectOne($query_ord_lib);

    $query_lib = "SELECT * FROM libro WHERE id_libro=$ord_lib->id_libro ORDER BY id_libro ASC LIMIT 1";
    $lib = $app->selectOne($query_lib);

    if(isset($_POST['submit'])){

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

<link rel="stylesheet" href="./css/dash_user_style.css"/>

<div class="cont_gen_dash_user">
   
    <div class="cont_header_dash">
        <h1>Panel de control</h1>
        </div>

    <div class="cont_principal_dash_user">

            <div class="cont_user_icon_dash_user">
                <img src="./img/perfil.png" alt="">
                <h2><?php echo $user->nombre?></h2>
            </div>

            <div class="cont_sub_princ_dash_user">
                <div class="cont_estado_dash_user">
                    <h2>Estado de reserva: <?php echo $ord->estado?></h2>
                    <div class="cont_info_user_dash_user">
                        <p>Informacion del alumno:</p>
                        <div class="cont_datos_dash_user">
                            <p>DNI: <?php echo $ord->DNI?></p>
                            <p>Curso: 6°1</p>
                            <p>Turno: tarde</p>
                            <p>Especialidad: Computacion</p>
                            <p>Veces bloqueado: 1</p>
    
                        </div>
    
                    </div>
                </div>
                <div class="cont_info_gen_lib_dash_user">
                    <p>Informacion del libro:</p>
                    <div class="cont_info_lib_dash_user">
    
                        <div class="cont_datos_lib_dash_user">
                            <img src="./img/portadas/<?php echo $lib->portada?>" alt="">
                            <div class="cont_text_datos_lib_dash_user">
                                <p>Titulo:<?php echo $lib->titulo?></p>
                                <p>Autor: <?php echo $lib->autor?></p>
                                <p>Editorial:</p>
                                <p>N° de edicion: <?php echo $lib->numero_edicion?></p>
                                <p>Ubicacion:<?php echo $lib->ubicacion?></p>
                                <p>Desde:<?php echo $ord->fecha_retiro?></p>
                                <p>Hasta:<?php echo $ord->fecha_devolucion?></p>
                            </div>
                        </div>
    
                    </div>
                    <?php if($ord->estado !== 'Finalizado') :?>
                    <form class="cont_devo_dash_user" method="POST" action="dash_user.php?id_orden=<?php echo $id_orden?>">
                        <input type="text" placeholder="Ingresar N° de devolucion" name="cod_devol">
                        <button type="submit" name="submit">Devolver</button>
    
                    </form>
                    <?php endif;?>
    
                </div>

            </div>

    </div>

</div>



<script>
        const maxHeight = Math.max(
        document.body.scrollHeight,
        document.documentElement.scrollHeight
        );
        document.documentElement.style.setProperty('--max-height', `${maxHeight}px`);
    </script>





<?php include("./template/pie_pag.php"); ?>