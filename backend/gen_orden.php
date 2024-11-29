<?php
session_start(); // Asegúrate de iniciar la sesión al comienzo

$servername = "localhost";
$username = "root";
$password = "caetanomysql";
$dbname = "biblioteca2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Fallo la conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni_input = $_POST['dni_a'];
    $password_input = $_POST['password_a'];
    $carritoIds = json_decode($_POST['carritoIds'], true);

    if (empty($dni_input) || empty($password_input) || empty($carritoIds)) {
        die("Datos incompletos");
    }

    // Verificar si el usuario actual coincide con las credenciales ingresadas
    $dni_sesion = $_SESSION['dni_usuario']; // DNI guardado en la sesión

    if ($dni_input !== $dni_sesion) {
        die("El DNI ingresado no coincide con el usuario autenticado.");
    }

    // Consultar contraseña almacenada para el usuario
    $query = "SELECT password FROM usuarios WHERE dni = '$dni_input'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $password_hash = $row['password'];

        // Verificar la contraseña
        if (!password_verify($password_input, $password_hash)) {
            die("Contraseña incorrecta.");
        }
    } else {
        die("Usuario no encontrado.");
    }

    // Si todo está correcto, continuar con la lógica de la orden
    $ids_str = implode(',', array_map('intval', $carritoIds));
    $updateQuery = "UPDATE libro SET disponible = 0 WHERE id_libro IN ($ids_str)";

    if ($conn->query($updateQuery) === TRUE) {
        echo "Libros deshabilitados correctamente.";

        $fechaDevolucion = date('Y-m-d H:i:s', strtotime('+14 days'));
        $insertOrderQuery = "INSERT INTO ordenes (dni_alumno, libros, fecha_prestamo, fecha_devolucion) 
                             VALUES ('$dni_input', '$ids_str', NOW(), '$fechaDevolucion')";

        if ($conn->query($insertOrderQuery) === TRUE) {
            echo "Orden registrada correctamente.";
        } else {
            echo "Error al registrar la orden: " . $conn->error;
        }
    } else {
        echo "Error al deshabilitar libros: " . $conn->error;
    }
}

$conn->close();
?>
