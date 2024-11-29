<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "caetanomysql";
$dbname = "biblioteca2";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn -> connect_error){
    die("Conexión fallida." . $conn -> connect_error);
}

$dni = $_POST['dni'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuario WHERE DNI = ?";
$stmt = $conn -> prepare($sql); 
$stmt->bind_param("s", $dni);
$stmt->execute();
$result = $stmt->get_result();

if ($result -> num_rows === 1){
    $user = $result -> fetch_assoc();
    if (password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $user['id_cuenta']; 
        $_SESSION['user_name'] = $user['nombre'];
        header("Location: ../usuario_pages/user_home.php");
        exit;
    }else{
        echo "Contraseña Incorrecta.";
    }
}else{
    echo "Usuario no encontrado.";
}

$conn -> close();
?>