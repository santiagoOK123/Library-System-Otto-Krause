<?php require "./config/config.php"?>
<?php  require "./libs/App.php"?>

<?php
session_start();
$app = new App;

if(isset($_POST['submit'])){
    $search = $_POST['search'];
    $query_cod = "SELECT * FROM orden WHERE codigo_reserva='$search' AND estado IN ('En curso', 'Sin devolver') ";
    
    
    if($app->checkEmailExists($query_cod) == true){
        $ord = $app->selectOne($query_cod);
       

        
            
          
          
                $query_user = "SELECT * FROM usuario WHERE DNI=$ord->DNI";
                $user = $app->selectOne($query_user);
                $query_ord_lib = "SELECT * FROM orden_libro WHERE id_orden = $ord->id_orden ORDER BY id_orden ASC LIMIT 1";
                $ord_lib = $app->selectOne($query_ord_lib);
                $query_lib = "SELECT * FROM libro WHERE id_libro = $ord_lib->id_libro";
                $libro = $app->selectOne($query_lib);

           
           

        
       

        
    }else{
        echo "ESE CODIGO No tiene un prestamo asignado";
        exit;
    }

    $_SESSION['order'] = $ord;
    $_SESSION['user'] = $user;
    $_SESSION['book'] = $libro;

    
}

if(isset($_POST['conf'])){
            
    $ord = $_SESSION['order'];
    $user = $_SESSION['user'];
    $libro = $_SESSION['book'];

    $query_ord_lib = "SELECT * FROM orden_libro WHERE id_orden = $ord->id_orden";
    $ord_lib_list = $app->selectAll($query_ord_lib);

    foreach($ord_lib_list  as $ord_lib){
        
        $query_update_lib = "UPDATE libro SET disponible = 1 WHERE id_libro = $ord_lib->id_libro";
        $app->update($query_update_lib);
    }
    $query_delete_ord_lib = "DELETE FROM orden_libro WHERE id_orden = $ord->id_orden";
    $app->update($query_delete_ord_lib);

    

    $path = "libro_devuelto_advice.php";

    $query_delete_ord = "DELETE FROM orden WHERE id_orden = $ord->id_orden";
    $app->delete($query_delete_ord,$path);

    
   


}




?>

<?php include("./template/nav.php"); ?>



<link rel="stylesheet" href="./css/codigo_devol_style.css"/>


<div class="cont_gen_cod_devol">
    <div class="cont_princ_cod_devol">
        <div class="searchAndBttn">
            <h1>Ingrese el código de devolución</h1>


            <form action="codigo_devol.php"
                    method="POST">
                <input class="search_cod_devol" type="text" name="search">
                <button name="submit" type="submit">BUSCAR</button>
            </form>
        </div>
        
        
        <?php if (isset($user)) :?>
        <div class="cont_lib_gen_info_cod_devol">
            <div class="cont_inner_ingo_cod_devol">

                <div class="cont_info_cod_devol">
                    <div class="cont_info_alum_cod_devol">
                        <div class="cont_alum_icon_cod_devol">
                            <img src="./img/perfil.png" alt="">
                            <p>Alumno: <?php echo $user->nombre?></p>
                        </div>
    
                        <p>D.N.I: <?php echo $user->DNI?></p>
                        <p>Curso:</p>
                        <p>Turno:</p>
                        <p>Especialidad:</p>
                    </div>
                    <hr style="height:2px;border-width:0;color:black;background-color:black;width:70%;">
                    <div class="cont_info_book_cod_devol">
                        <p>Libro:  <?php echo $libro->titulo?></p>
                        <p>Autor:</p>
                        <p>Editorial:</p>
                        <p>N° de edicion:</p>
                        <p>Ubicación:</p>
    
                    </div>
    
                    <form class="cont_buttons_cod_devol" action="codigo_devol.php" method="POST">
                        <button class="conf_button_cod_devol" name="conf" type="submit">Confirmar devolución</button>
                        <button class="cancel_button_cod_devol"  name="cancel" type="submit">Cancelar</button>
    
                    </form>

                    
    
                    
                    
                </div>
                <div class="cont_port_cod_devol">
                        <img src="./img/portadas/<?php echo $libro->portada?>" alt="">
                </div>
            </div>

            

        </div>
        <?php endif;?>

    </div>
</div>



<?php include("./template/pie_pag.php"); ?>