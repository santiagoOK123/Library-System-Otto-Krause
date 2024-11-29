<?php require "../config/config.php"?>
<?php  require "../libs/App.php"?>
<?php  
session_start();
$app = new App;
$email = $_SESSION['email'];

   $query = "SELECT * FROM usuario WHERE email='$email'";
   $user = $app->selectOne($query);

   $dni = $user->DNI;

   $query_ord_libro_encurso = "SELECT l.* FROM orden_libro ol JOIN libro l ON ol.id_libro = l.id_libro JOIN orden o ON ol.id_orden = o.id_orden JOIN usuario u ON o.dni = u.DNI WHERE o.estado = 'Sin retirar' AND u.DNI = $dni";
    
   $lista_libros_encurso = $app->selectAll($query_ord_libro_encurso);

   $ord_list_query = "SELECT * FROM orden WHERE DNI = $dni AND estado = 'Sin retirar'";
   $ords = $app->selectAll($ord_list_query);





?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user_orden_style.css">
    <title>Ords</title>
</head>

<body>
    <?php include("../template/user_nav.php"); ?>    
    <div class="cont_main_o">
        <h2>Mis ordenes:</h2>
        <ul class="cont_ord_o">
        
                <?php foreach($lista_libros_encurso as $libro_curso) : ?>
                <li class="cont_lib_o">
                    
                    <img class="portada" src="../img/portadas/<?php echo $libro_curso->portada?>" />
                    
                    <p>Nombre: <?php echo $libro_curso->titulo?></p>
                    
                  
                        
                   
                    
                </li>
                <?php endforeach;?>
          


                
        </ul>

        

    </div>
</body>

</html>