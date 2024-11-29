<?php
$servername = "localhost";
$username = "root";
$password = "caetanomysql";
$dbname = "biblioteca2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn -> connect_error){
    die ("Conexión fallida: " . $conn -> connect_error);
}

$email = $_POST['email'];
$dni = $_POST['dni'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$password = $_POST['password'];

if ($_POST["password"] !== $_POST["password_conf"]){
    echo "Las contraseñas no coinciden.";
    exit;
}
$password_hash = password_hash($password, PASSWORD_BCRYPT); //Encriptar contraseña

$sql = "INSERT INTO usuario (email, DNI, nombre, apellido, password) VALUES('$email', '$dni', '$nombre', '$apellido', '$password_hash')";

if ($conn -> query($sql) === TRUE){
    echo "Usuario creado exitosamente";
    header("location: ../usuario_pages/user_home.php");
}else{
    echo "Error: ". $sql . "<br>" . $conn -> error;
}

$conn -> close();
?>