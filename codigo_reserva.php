<?php require "./config/config.php"?>
<?php  require "./libs/App.php"?>

<?php
session_start();
$app = new App;

if(isset($_POST['submit'])){
    $search = $_POST['search'];
    $query_cod = "SELECT * FROM orden WHERE codigo_reserva='$search'";
    
    
    if($app->checkEmailExists($query_cod) == true){
        $ord = $app->selectOne($query_cod);
        $query_check_ord = "SELECT * FROM orden WHERE id_orden = $ord->id_orden AND estado IN ('En curso', 'Sin devolver')";
        if($app->checkEmailExists($query_check_ord) == false){
            $query_user = "SELECT * FROM usuario WHERE DNI=$ord->DNI";
            $user = $app->selectOne($query_user);
            $query_ord_lib = "SELECT * FROM orden_libro WHERE id_orden = $ord->id_orden";
            $ord_lib = $app->selectOne($query_ord_lib);
            $query_lib = "SELECT * FROM libro WHERE id_libro = $ord_lib->id_libro";
            $libro = $app->selectOne($query_lib);
            
            $_SESSION['order'] = $ord;
            $_SESSION['user'] = $user;
            $_SESSION['book'] = $libro;

        }else{
            echo "ESE CODIGO YA TIENE UN PRESTAMO ASIGNADO";
            exit;
        }
       

    
    }

    

    
}

if(isset($_POST['cancel'])){
    $ord = $_SESSION['order'];
    
    $query_ord_lib = "SELECT * FROM orden_libro WHERE id_orden = $ord->id_orden";
    $ord_lib_list = $app->selectAll($query_ord_lib);

    foreach($ord_lib_list  as $ord_lib){
        
        $query_update_lib = "UPDATE libro SET disponible = 1 WHERE id_libro = $ord_lib->id_libro";
        $app->update($query_update_lib);
    }

    $query_delete_ord_lib = "DELETE FROM orden_libro WHERE id_orden = $ord->id_orden";
    $app->update($query_delete_ord_lib);
    $query_delete_ord = "DELETE FROM orden WHERE id_orden = $ord->id_orden";
    $path = "index.php";
    $app->delete($query_delete_ord,$path);

}

if(isset($_POST['conf'])){
            
    $ord = $_SESSION['order'];
    $user = $_SESSION['user'];
    $libro = $_SESSION['book'];

    $fecha_devol = date('Y-m-d', strtotime('+14 days'));
    $fecha_retiro = date('Y-m-d', strtotime('-1 days'));
    $query_update_ord = "UPDATE orden SET estado = 'En curso', fecha_retiro = '$fecha_retiro' ,fecha_devolucion = '$fecha_devol' WHERE id_orden = $ord->id_orden";

    $app->update($query_update_ord);

   header('Location: libro_prestado_advice.php');
}




?>

<?php include("./template/nav.php"); ?>



<link rel="stylesheet" href="./css/codigo_reser_style.css"/>


<div class="cont_gen_cod_reser">
    <div class="cont_princ_cod_reser">
        <div class="searchAndBttn">
            <h1>Ingrese el código de reserva</h1>

            <form action="codigo_reserva.php"
                    method="POST">
                <input class="search_cod_reser" type="text" name="search">
                <button name="submit" type="submit" id="searchBttn">BUSCAR</button>
            </form>
        </div>


        
        
        <?php if (isset($user)) :?>
        <div class="cont_lib_gen_info_cod_reser">

            <div class="cont_inner_ingo_cod_reser">
                
                <div class="cont_info_cod_reser" id="results">
                
                    <div class="cont_info_alum_cod_reser">
                        <div class="cont_alum_icon_cod_reser">
                            <img src="./img/perfil.png" alt="">
                            <p>Alumno: <?php echo $user->nombre?></p>
                        </div>
    
                        <p>D.N.I: <?php echo $user->DNI?></p>
                        <p>Curso:</p>
                        <p>Turno:</p>
                        <p>Especialidad:</p>
                    </div>
                    <hr style="height:2px;border-width:0;color:black;background-color:black;width:70%;">
                    <div class="cont_info_book_cod_reser">
                        <p>Libro: <?php echo $libro->titulo?></p>
                        <p>Autor:</p>
                        <p>Editorial:</p>
                        <p>N° de edicion:</p>
                        <p>Ubicación:</p>
    
                    </div>
    
                    <form class="cont_buttons_cod_reser" action="codigo_reserva.php" method="POST">
                        
                        <button class="conf_button_cod_reser" name="conf" type="submit">Confirmar retiro</button>
                        
                        <button class="cancel_button_cod_reser" name="cancel" type="submit">Cancelar</button>
    
                    </form>
    
                    
                    
                </div>
                <div class="cont_port_cod_reser">
                        <img src="./img/portadas/<?php echo $libro->portada?>" alt="">
                </div>
                 
            </div>
            
            

        </div>
        <?php endif;?>

    </div>
</div>

<script>

</script>



<?php include("./template/pie_pag.php"); ?>