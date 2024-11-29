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

$sql = "SELECT id_libro, titulo, autor, portada FROM libro";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  echo "<div class='libros_general'>";
  while($row = $result->fetch_assoc()) {
    echo "<div class='libro_query'>";
    echo " ID: " . $row["id_libro"]. "<br>Titulo: " . $row["titulo"]. "<br>Autor: " . $row["autor"];
    echo "<br>";
    echo "<img src='../img/portadas/portada_default.jpg'" . $row["portada"] . "' alt='Portada del libro' style='width:150px;height:200px;'>";
    echo "<button id='agregarBttn' onclick='addCarrito(" . $row["id_libro"] . ")'>Agregar al carrito</button>";
    echo "</div>";
  }
  echo "</div>";
} else {
  echo "0 results";
}
echo "
<script>
  function addCarrito(id) {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    if (!carrito.includes(id)) {
      carrito.push(id);
      localStorage.setItem('carrito', JSON.stringify(carrito));
      console.log('Libro agregado al carrito:', id);
    } else {
      console.log('El libro ya está en el carrito:', id);
    }
  }
</script>
";
$conn->close();
?>