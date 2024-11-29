<?php
var_dump($_POST);
var_dump($_FILES);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "caetanomysql", "biblioteca2");

    if ($conn->connect_error) {
        die("Fallo la conexión a la base de datos: " . $conn->connect_error);
    }

    // Recibir datos del formulario
    $id_editorial = htmlspecialchars($_POST['id_editorial']);
    $titulo = htmlspecialchars($_POST['titulo']);
    $autor = htmlspecialchars($_POST['autor']);
    $idioma = htmlspecialchars($_POST['idioma']);
    $paginas = intval($_POST['paginas']);
    $numero_edicion = intval($_POST['numero_edicion']);
    $lugar_edicion = htmlspecialchars($_POST['lugar_edicion']);
    $anio_edicion = intval($_POST['anio_edicion']);
    $descriptor_primario = htmlspecialchars($_POST['descriptor_primario']);
    $descriptor_secundario = htmlspecialchars($_POST['descriptor_secundario']);
    $ISBN = htmlspecialchars($_POST['ISBN']);
    $ISSN = htmlspecialchars($_POST['ISSN']);
    $notas = htmlspecialchars($_POST['notas']);
    $cantidad_ejemplares = intval($_POST['cantidad_ejemplares']);
    $ubicacion = htmlspecialchars($_POST['ubicacion']);

    // Procesar el archivo de portada
    $portada = null;
    if (isset($_FILES['portada']) && $_FILES['portada']['error'] == 0) {
        $upload_dir = './img/portadas/';
        $portada = $upload_dir . basename($_FILES['portada']['name']);
        move_uploaded_file($_FILES['portada']['tmp_name'], $portada);
    }

    $result = $conn->query("SELECT id_editorial FROM editorial WHERE nombre_editorial = '$id_editorial'");
    if ($result->num_rows > 0) {
        // La editorial existe, obtener su ID
        $row = $result->fetch_assoc();
        $id_editorial = $row['id_editorial'];
    } else {
        // La editorial no existe, insertarla
        $stmt = $conn->prepare("INSERT INTO editorial (nombre_editorial) VALUES (?)");
        $stmt->bind_param("s", $id_editorial);

        if ($stmt->execute()) {
            // Obtener el ID de la nueva editorial
            $id_editorial = $stmt->insert_id; // ID de la nueva editorial
        } else {
            die("Error al insertar nueva editorial: " . $stmt->error);
        }
    }

    // Preparar e insertar en la base de datos
    $sql = "INSERT INTO libro (id_editorial, titulo, autor, idioma, paginas, numero_edicion, lugar_edicion, anio_edicion, descriptor_primario, descriptor_secundario, ISBN, ISSN, notas, cantidad_ejemplares, ubicacion) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssississsssis", $id_editorial, $titulo, $autor, $idioma, $paginas, $numero_edicion, $lugar_edicion, $anio_edicion, $descriptor_primario, $descriptor_secundario, $ISBN, $ISSN, $notas, $cantidad_ejemplares, $ubicacion);

    if ($stmt->execute()) {
        echo "Libro agregado correctamente.";
        header("Location: ../libro_public_advice.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    // Cerrar conexión
    $stmt->close();
    $conn->close();
}
?>
