<?php
$servername = "localhost";
$username = "root";
$password = "caetanomysql";
$dbname = "biblioteca2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Fallo la conección a la base de datos: " . $conn->connect_error);
}
$conn->set_charset("utf8");

// Incluir archivo de conexión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar campos obligatorios
    if (empty($_POST['id_libro']) || empty($_POST['titulo']) || empty($_POST['autor'])) {
        die("Error: Algunos campos obligatorios están vacíos.");
    }

    // Recibir y sanitizar datos
    $id_libro = intval($_POST['id_libro']);
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $autor = $conn->real_escape_string($_POST['autor']);
    $editorial = $conn->real_escape_string($_POST['id_editorial']);
    $anio = intval($_POST['anio_edicion']);
    $idioma = $conn->real_escape_string($_POST['idioma']);
    $ISBN = $conn->real_escape_string($_POST['ISBN']);
    $ISSN = $conn->real_escape_string($_POST['ISSN']);
    $descriptor_primario = $conn->real_escape_string($_POST['descriptor_primario']);
    $descriptor_secundario = $conn->real_escape_string($_POST['descriptor_secundario']);
    $numero_edicion = intval($_POST['numero_edicion']);
    $ubicacion = $conn->real_escape_string($_POST['ubicacion']);

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";


    // Preparar y ejecutar consulta
    $sql = "UPDATE libro SET 
                titulo = ?, 
                autor = ?, 
                id_editorial = ?, 
                anio_edicion = ?, 
                idioma = ?, 
                ISBN = ?, 
                ISSN = ?, 
                descriptor_primario = ?, 
                descriptor_secundario = ?, 
                numero_edicion = ?, 
                ubicacion = ? 
            WHERE id_libro = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param(
        "sssisssssisi",
        $titulo, $autor, $editorial, $anio, $idioma, 
        $ISBN, $ISSN, $descriptor_primario, $descriptor_secundario, 
        $numero_edicion, $ubicacion, $id_libro
    );

    if ($stmt->execute()) {
        // Redirigir en caso de éxito
        header("Location: ../modif_libro_preview.php");
        exit();
    } else {
        echo "Error al actualizar el libro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    die("Acceso no permitido.");
}
?>
