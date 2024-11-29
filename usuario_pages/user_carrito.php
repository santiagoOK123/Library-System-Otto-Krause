<?php require "../config/config.php"?>
<?php  require "../libs/App.php"?>

<?php 

session_start();
$app = new App;
$email = $_SESSION['email'];

$query = "SELECT * FROM usuario WHERE email='$email'";
$user = $app->selectOne($query);

$dni = $user->DNI;

$query_carr = "SELECT l.* FROM carrito c INNER JOIN libro l ON c.id_libro = l.id_libro WHERE c.id_usuario = '$dni'";

$lista_libros_carr = $app->selectAllCarrito($query_carr);

if(isset($_POST['delete'])){
    $lib_carr = $_POST['lib_carr'];

    $query_delete_carr_lib = "DELETE FROM carrito WHERE id_usuario = $dni AND id_libro = $lib_carr";
    $path = "user_carrito.php";
    $app->delete($query_delete_carr_lib,$path);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user_carr_style.css">
    <title>Carrito</title>
</head>

<body>
    <?php include("../template/user_nav.php"); ?>

    <div class="cont_principal_carr">
        <div class="cont_lib_carr">
            <h1>Carrito:</h1>
             <!-- Verificar si no hay libros en el carrito -->
            <?php if (count($lista_libros_carr) > 0) : ?>
                <?php foreach($lista_libros_carr as $libro_carr) : ?>
                <form class="cont_sub_lib_carr" method="POST" action="user_carrito.php">
                    <img src="../img/portadas/<?php echo $libro_carr->portada?>" />
                    <div class="descrip_carr">
                        <p>Nombre: <?php echo $libro_carr->titulo?></p>
                        <p>Tipo de libro:</p>
                    </div>
                    <input type="hidden" name="lib_carr" value="<?= $libro_carr->id_libro ?>">
                    <button name="delete" type="submit" >eliminar</button>
                </form>
                <?php endforeach;?>
            <?php else : ?>
                <p>No hay ningún libro en el carrito</p> <!-- Mensaje cuando no hay libros -->
            <?php endif; ?>
        </div>

        <div class="cont_cant_carr">
            <!-- <p id="cantidadLibros">Cantidad de libros: 
                <?php /* echo isset($ids) ? count($ids) : 0;  */?>
            </p> -->
            <p id="cantidadLibros">Cantidad de libros: <?php echo count($lista_libros_carr); ?></p>
            <a href="user_checkout.php?one=false">Continuar Orden</a>
        </div>
    </div>

    <script>
       
    </script>

    <?php include("../template/pie_pag_user_search.php"); ?>
</body>

</html>