<?php require "../config/config.php"?>
<?php  require "../libs/App.php"?>
<?php  
 session_start();
 $app = new App;
 if (isset($_GET['codigo_reserva'])){
    $cod_reserva = $_GET['codigo_reserva'];

    if(isset($_POST['cancel'])){
        $query_ord = "SELECT * FROM orden WHERE codigo_reserva = '$cod_reserva'";
        $ord = $app->selectOne($query_ord);
        $query_ord_lib = "SELECT * FROM orden_libro WHERE id_orden = $ord->id_orden";
        $ord_lib_list = $app->selectAll($query_ord_lib);

        foreach($ord_lib_list  as $ord_lib){
            
            $query_update_lib = "UPDATE libro SET disponible = 1 WHERE id_libro = $ord_lib->id_libro";
            $app->update($query_update_lib);
        }

        $query_delete_ord_lib = "DELETE FROM orden_libro WHERE id_orden = $ord->id_orden";
        $app->update($query_delete_ord_lib);
        $query_delete_ord = "DELETE FROM orden WHERE id_orden = $ord->id_orden";
        $path = "user_search.php";
        $app->delete($query_delete_ord,$path);
        
    }
 }


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user_order_gen_style.css">
    <title>Order gen</title>
</head>

<body>
    <div class='cont_principal_og'>
    <?php include("../template/user_nav.php"); ?>
        <div
            class='cont_gen_og'>
            <div class='text_gen_og'>
                <h1>¡Orden generada con éxito!</h1>
                <h1>Tu número de orden es: </h1>
                <h1>#<?php echo $cod_reserva?> </h1>
            </div>
            <div class='cont_buttons_og'>
                <a href="user_search.php">🡐 Ordenar más libros</a>
                <form action="user_order_gen.php?codigo_reserva=<?php echo $cod_reserva?>" method="POST">
                    <button type="submit" name="cancel" >Cancelar orden</button>

                </form>
                

            </div>

        </div>

    </div>
</body>

</html>