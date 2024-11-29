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

$sql = "SELECT id_libro, titulo, autor, portada, id_editorial, anio_edicion, idioma, ISSN, ISBN, descriptor_primario, descriptor_secundario, numero_edicion, ubicacion FROM libro";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  echo "<div class='libros_general'>";
  while($row = $result->fetch_assoc()) {
    $id_libro = !empty($row['id_libro']) ? $row['id_libro'] : 'ID desconocido';
    $titulo = !empty($row['titulo']) ? $row['titulo'] : 'Título desconocido';
    $autor = !empty($row['autor']) ? $row['autor'] : 'Autor desconocido';
    $id_editorial = !empty($row['id_editorial']) ? $row['id_editorial'] : 'Editorial desconocida';
    $anio_edicion = !empty($row['anio_edicion']) ? $row['anio_edicion'] : 'Año desconocido';
    $idioma = !empty($row['idioma']) ? $row['idioma'] : 'Idioma desconocido';
    $ISSN = !empty($row['ISSN']) ? $row['ISSN'] : 'ISSN no disponible';
    $ISBN = !empty($row['ISBN']) ? $row['ISBN'] : 'ISBN no disponible';
    $descriptor_primario = !empty($row['descriptor_primario']) ? $row['descriptor_primario'] : 'Descriptor primario no disponible';
    $descriptor_secundario = !empty($row['descriptor_secundario']) ? $row['descriptor_secundario'] : 'Descriptor secundario no disponible';
    $numero_edicion = !empty($row['numero_edicion']) ? $row['numero_edicion'] : 'Número de edición no disponible';
    $ubicacion = !empty($row['ubicacion']) ? $row['ubicacion'] : 'Ubicación no disponible';

    echo "<div class='libro_query'>";
    echo " ID: " . $row["id_libro"]. "<br>Titulo: " . $row["titulo"]. "<br>Autor: " . $row["autor"];
    echo "<br>";
    echo "<img src='../img/portadas/portada_default.jpg'" . $row["portada"] . "' alt='Portada del libro' style='width:150px;height:200px;'>";
    //echo "<a href='eliminar_libro.php?id=$row[id_libro]&titulo=$row[titulo]&autor=$row[autor]&id_editorial=$row[id_editorial]&anio_edicion=$row[anio_edicion]&idioma=$row[idioma]&ISSN=$row[ISSN]&ISBN=$row[ISBN]&descriptor_primario=$row[descriptor_primario]&descriptor_secundario=$row[descriptor_secundario]&ubicacion=$row[ubicacion]&numero_edicion=$row[numero_edicion]'>";
    echo "<a href='eliminar_libro.php?id=$id_libro&titulo=$titulo&autor=$autor&id_editorial=$id_editorial&anio_edicion=$anio_edicion&idioma=$idioma&ISSN=$ISSN&ISBN=$ISBN&descriptor_primario=$descriptor_primario&descriptor_secundario=$descriptor_secundario&ubicacion=$ubicacion&numero_edicion=$numero_edicion'>";
    echo "<button id='inspBttn' onclick='to_delete_result()'>Inspeccionar</button>";
    echo "</a>";
    echo "</div>";
    //C:\xampp\htdocs\proyecto_biblioteca_admin\img\portadas
  }
  echo "</div>";
} else {
  echo "0 results";
}
$conn->close();
?>