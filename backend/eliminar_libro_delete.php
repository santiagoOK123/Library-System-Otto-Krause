<?php
header('Content-Type: application/json');

$id_libro = $_POST['id_libro'];

if (!$id_libro) {
    echo json_encode(['success' => false, 'message' => 'ID del libro no proporcionado']);
    exit;
}

$conn = new mysqli("localhost", "root", "caetanomysql", "biblioteca2");

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión']);
    exit;
}

$sql = "DELETE FROM libro WHERE id_libro = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_libro);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al eliminar']);
}

$stmt->close();
$conn->close();
?>
