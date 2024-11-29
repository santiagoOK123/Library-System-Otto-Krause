<?php require "../config/config.php"?>
<?php  require "../libs/App.php"?>

<?php
    
    session_start();
    if (isset($_GET['id_libro'])){
        $id_libro = $_GET['id_libro'];
        $query = "SELECT * FROM libro WHERE id_libro='$id_libro'";
        $app = new App;

        $one = $app->selectOne($query);

        if (isset($_POST['submit'])){

            $email = $_SESSION['email'];
            $query_user = "SELECT * FROM usuario WHERE email='$email'";
            $user = $app->selectOne($query_user);
    
            $id_usuario = $user->id_cuenta;
            
            $query_check_fav = "SELECT l.* FROM favoritos f INNER JOIN libro l ON f.id_libro = l.id_libro WHERE f.id_usuario = '$id_usuario' AND f.id_libro ='$id_libro'" ;
            

            if($app->checkEmailExists($query_check_fav) == false){
                $query_addfav = "INSERT INTO favoritos (id_libro, id_usuario) VALUES (:id_libro, :id_usuario)";
    
                $arr = [
                    ":id_libro" => $id_libro,
                    ":id_usuario" => $id_usuario,
                    
                ];
        
                $path = "user_favs.php";
            
                $app->insert($query_addfav, $arr, $path);

            }else{
                echo "
                <script>
                    alert('No añada los mismos libros');
                    
                </script>
                ";
               
            }

            
    
        }

        if (isset($_POST['add_carr'])){

            $email = $_SESSION['email'];
            $query_user = "SELECT * FROM usuario WHERE email='$email'";
            $user = $app->selectOne($query_user);
    
            $dni = $user->DNI;
            
            $query_check_carr = "SELECT l.* FROM carrito c INNER JOIN libro l ON c.id_libro = l.id_libro WHERE c.id_usuario = '$dni' AND c.id_libro ='$id_libro'" ;
            if($app->checkEmailExists($query_check_carr) == false){

                $query_addcarr = "INSERT INTO carrito (id_libro, id_usuario) VALUES (:id_libro, :id_usuario)";
    
                $arr = [
                    ":id_libro" => $id_libro,
                    ":id_usuario" => $dni,
                    
                ];
        
                $path = "user_carrito.php";
            
            $app->insert($query_addcarr, $arr, $path);
            

            }else{
                echo "
                <script>
                    alert('No añada los mismos libros');
                    
                </script>
                ";
            }
            
    
        }

        if(isset($_POST['reservar'])){
            if(isset($_SESSION['email'])){
                
                header('Location: http://localhost/proyecto_biblioteca_admin/usuario_pages/user_checkout.php?one=' . $id_libro);
            }else{
                header('Location: http://localhost/proyecto_biblioteca_admin/usuario_pages/user_login.php');
            }
        }

        

    }
    
    

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user_book_info_style.css">
    <title>Document</title>

</head>

<body>
    <div id="rasta">
        <body>
            
            <div class="bk_info_main">
                <?php include("../template/user_nav.php"); ?>
                <div class="cont_principal_bki">
                    <div class="cont_port_bki">
                        <div>
                             <img src="../img/portadas/<?php echo $one->portada; ?>"/>
                        </div>
                    </div>
        
                    <div class="cont_info_bki">
                        <div class="text_info_bki">
                            <h2>Información</h2>
                            <p>Titulo: <?php echo $one->titulo; ?></p>
                            <p>Autor: <?php echo $one->autor; ?></p>
                            <p>Número de edición: <?php echo $one->numero_edicion; ?></p>
                            <p>Año: <?php echo $one->anio_edicion; ?></p>
                            <p>Ejemplares disponibles: <?php echo $one->disponible; ?></p>
                            
                    </div>
        
                    <div class="black_buttons_bki">
                        <form  action="user_book_info.php?id_libro=<?php echo $id_libro;?>"
                                method="POST">
                            <?php if (isset($_SESSION['email'])) :?>
                            <button class="favorito_bki " name="submit" type="submit">
                                <img src="../img/fav_w.png" alt="" />
                            </button>
                            <?php endif;?> 
                            <?php if (($one->disponible > 0)) :?>
                            <button name="reservar" type="submit" class="reservar_bki " >Reservar ahora</button>
                            <?php endif;?> 
                            <?php if (isset($_SESSION['email']) && ($one->disponible > 0)) :?>
                            <button class="carrito_bki " name="add_carr" type="submit" >
                                <img  src="../img/carr_w.png" alt="" />
                            </button>
                            <?php endif;?> 

                        </form>
                        
                    </div>
        
                    <div class="cont_more_info_desp">
                        <button class="more_info_bki_desp">
                            Más Información <img class="arrow_desp" src="../img/arrow_open.webp" />
                        </button>
                    </div>
        
                    <div class="cont_more_info_bki">
                        <button class="more_info_down_bki" >
                            Más Información
                            <img class="arrow_desp" src="../img/arrow_open.webp" alt="" />
                        </button>
                        <p>Titulo: <?php echo $one->titulo; ?></p>
                        <p>Autor: <?php echo $one->autor; ?></p>
                        <p>Editorial:<?php echo $one->id_editorial; ?></p>
                        <p>Número de edición:<?php echo $one->numero_edicion; ?></p>
                        <p>Año: <?php echo $one->anio_edicion; ?></p>
                        <p>Lugar de edición: <?php echo $one->lugar_edicion; ?></p>
                        <p>Idioma: <?php echo $one->idioma; ?></p>
                        <p>ISBN: <?php echo $one->ISBN; ?></p>
                        <p>N° de páginas: <?php echo $one->paginas; ?></p>
                        <p>Ubicación: <?php echo $one->ubicacion; ?></p>
                        <p>Descriptores temáticos: </p>
                        <p>Primario: <?php echo $one->descriptor_primario; ?></p>
                        <p>Secundario: <?php echo $one->descriptor_secundario; ?></p>
                    </div>
            </div>
            </div>
            </div>
        </body>
    </div>


<script>

    const more_info_desp = document.querySelector(".cont_more_info_bki")

    const openMore_info_desp = document.querySelector(".more_info_bki_desp")
    const closeMore_ingo_desp = document.querySelector(".more_info_down_bki")

    openMore_info_desp.addEventListener("click",() =>{
        more_info_desp.classList.add("open")
    })

    closeMore_ingo_desp.addEventListener("click",() =>{
        more_info_desp.classList.remove("open")
    })


</script>



    <?php include("../template/pie_pag_user_search.php"); ?>