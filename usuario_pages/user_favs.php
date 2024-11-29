<?php require "../config/config.php"?>
<?php  require "../libs/App.php"?>

<?php
   
   session_start();
   $app = new App;

    
   $email = $_SESSION['email'];

   $query = "SELECT * FROM usuario WHERE email='$email'";
   $user = $app->selectOne($query);

   $id_usuario = $user->id_cuenta;

   $query_fav = "SELECT l.* FROM favoritos f INNER JOIN libro l ON f.id_libro = l.id_libro WHERE f.id_usuario = '$id_usuario'";

   $lista_libros_fav = $app->selectAll($query_fav);

   
   


   

   


   
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user_favs_style.css">
    <title>Favs</title>
</head>

<body>
    <?php include("../template/user_nav.php"); ?>
    <div class="cont_main_l">
       
        <h2>Lista de deseos:</h2>

        <ul class="cont_ord_l">

            <?php foreach($lista_libros_fav as $libro_fav) : ?>
            <li class="cont_lib_l">
                <img class="fav_icon_w" src="../img/fav_w.png" />
                <div>
                    <img class="portada" src="../img/portadas/<?php echo $libro_fav->portada?>" />
                </div>
                
            </li>
            <?php endforeach;?>

            
        </ul>



    </div>
</body>

</html>