<?php require "../config/config.php"?>
<?php  require "../libs/App.php"?>
<?php  
session_start();
$app = new App;
$email = $_SESSION['email'];

   $query = "SELECT * FROM usuario WHERE email='$email'";
   $user = $app->selectOne($query);

   $dni = $user->DNI;


   $query_ord_fin = "SELECT l.* FROM orden_libro ol JOIN libro l ON ol.id_libro = l.id_libro JOIN orden o ON ol.id_orden = o.id_orden JOIN usuario u ON o.dni = u.DNI WHERE o.estado = 'Finalizado' AND u.DNI = $dni";


   $lista_libros_fin = $app->selectAll($query_ord_fin);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user_orden_fin_style.css">
    <title>Orden fin</title>
</head>

<body>
    <?php include("../template/user_nav.php"); ?>
    <div
        class="cont_main_of">
        <h2>Ordenes finalizadas:</h2>
        <ul class="cont_ord_of">

            <?php foreach($lista_libros_fin as $libro_fin) : ?>
            <li class="cont_lib_of">
                <img src="../img/portadas/<?php echo $libro_fin->portada?>"  />
                <p>Nombre: <?php echo $libro_fin->titulo?></p>
                <label for="number-sel">Calificar:</label>

                <select id="number-sel">

                    <option value="">--1 al 5--</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>

                </select>


            </li>
            <?php endforeach;?>

            



        </ul>
    </div>
</body>

</html>