<?php require "../config/config.php"?>
<?php  require "../libs/App.php"?>

<?php 

session_start();
$app = new App;
$email = $_SESSION['email'];

$query = "SELECT * FROM usuario WHERE email='$email'";
$user = $app->selectOne($query);

$dni = $user->DNI;
$password = $user->password;
if(isset($_GET['one'])){
    $one = $_GET['one'];

    if (isset($_POST['submit'])){
        
           
        
       
        $dni_input = $_POST['dni_a'];
        $password_input = $_POST['password_a'];
    
        if($dni_input != $dni){
            echo "El dni no coinciden con la sesion actual";
            die;
        }
    
        if(!password_verify($password_input, $password)){
            echo "La contraseña no coincide con la sesion actual";
            die;
        }
    
        if($one === 'false'){
        $codigo_gen = $app->insertOrder($dni);
        $query_update_lib = "UPDATE libro l INNER JOIN carrito c ON l.id_libro = c.id_libro INNER JOIN usuario u ON c.id_usuario = u.DNI SET l.disponible = 0 WHERE u.DNI = '$dni'";
        $query_delete_carr = "DELETE FROM carrito WHERE id_usuario='$dni'";
        $path = "user_order_gen.php?codigo_reserva=$codigo_gen";
        $app->update($query_update_lib);
        $app->delete($query_delete_carr,$path);
        }else{
            $codigo_gen = $app->reserv_now($dni,$one);
            $query_update_lib = "UPDATE libro SET disponible = 0 WHERE id_libro = $one";
            $app->update($query_update_lib);
            header('Location: http://localhost/proyecto_biblioteca_admin/usuario_pages/user_order_gen.php?codigo_reserva=' . $codigo_gen);

        }
    
    
    
        
      
    
    }
    
    
}else{
    echo "error";
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user_checkout_style.css">
    <title>Checkout</title>
    <style>
        .password_a-ck{
            font-size: 20px;
            margin-left: 0.8em;
        }

        #dni_a {
            border: 0px;
            outline: none;
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
        }

        #password_a {
            border: 0px;
            outline: none;
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
        }

        .boton_submit {
            display: flex;
            justify-content: center;
        }

        .conf_button-ck{
            width: 90%;
            border: none;
            cursor: pointer;
        }

    </style>
</head>

<body>
    <div class="cont_principal-ck">
        <?php include("../template/user_nav.php"); ?>
        <div class="cont_main-ck">
            <div class="cont_datos-orden-ck">
                <h2>Completar</h2>
                <form id="checkoutForm" method="POST" action="user_checkout.php?one=<?php echo $one?>">
                    <p>Nombre: Biblioteca Otto Krause</p>
                    <label class="dni_a-ck" for="dni_a">Dni del alumno:</label>
                    <input type="number" id="dni_a" name="dni_a" required />
                    <br /><br />
                    <label class="password_a-ck" for="password_a">Contraseña:</label>
                    <input type="password" id="password_a" name="password_a" required />
                    <br /><br />
                    <div class="boton_submit">
                    <input type="hidden" id="carritoIds" name="carritoIds" />
                    <button type="submit" name="submit" class="conf_button-ck">Confirmar</button>
                     </div>
                </form>
            </div>

            <div class="cont_datos-conf-ck" style="width: 600px">
                <h3>Libros seleccionados</h3>
                <div id="librosCarrito"></div>
                <div class="desc_aviso-ck">
                    <p>Al aceptar la orden se hace responsable de los daños físicos que pueda tener el libro.</p>
                </div>
            </div>
        </div>  
    </div>

    <script>
       
    </script>
</body>

</html>
