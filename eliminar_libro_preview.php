
<?php require "./config/config.php"?>
<?php  require "./libs//App.php"?>
<?php
   

   
   $app = new App;

   $query_all_libs = "SELECT * FROM libro";

   $list_lib = $app->selectAll($query_all_libs);
   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
       $search = $_POST['search'];
      
       $query_search = "SELECT * FROM libro WHERE titulo LIKE ?";
       
       $results = $app->select_all_like($query_search, $search);
       echo json_encode($results);
       exit;
       
   }
   
   
   

?>

<?php include("./template/nav.php"); ?>
<link rel="stylesheet" href="./css/delete_lib_preview.css"/>
<div class="cont_gen_delete_preview">

    <h1>Eliminar libro</h1>
    <form action="eliminar_libro_preview.php" method="get">
            <input type="text" id="search" onkeyup="fetchSearchResults()">
    </form>
    
    <div class="cont_lib_delete_preview" id="results">
       
    </div>
    <!-- <img src="./img/portadas/Portada_18.png" onclick="to_delete_result()" alt=""> -->
    
    
</div>

<script>
    function to_delete_result() {
            window.location.href = 'eliminar_libro.php'; // Cambia 'pagina.php' por la URL a la que deseas redirigir
    }
    
    function fetchSearchResults() {
    const query = document.getElementById('search').value;
    fetch('search_preview.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'search=' + encodeURIComponent(query)
    })
    .then(response => response.json())
    .then(data => {
        const resultsContainer = document.getElementById('results');
        resultsContainer.innerHTML = ''; // Limpia resultados anteriores
        if (data.length > 0) {
            data.forEach(item => {
                const div = document.createElement('div');
                const disponibilidad = item.disponible === 1 ? 'Disponible' : "No disponible";
                div.classList.add('libro-item');
                div.innerHTML = ` <a href="eliminar_libro.php?id_libro=${item.id_libro}" class="portada_delete_modif"> <img src="./img/portadas/${item.portada}" alt=""> </a>
                <div class="book-info">
                    <h3>${item.titulo}</h3>
                    <p>Autor: ${item.autor}</p>
                    <p>${disponibilidad}</p>
                </div>`;
                resultsContainer.appendChild(div);
            });
        } else {
            resultsContainer.innerHTML = '<p>No se encontraron resultados.</p>';
        }
    })
    .catch(error => console.error('Error:', error));}
</script>

<?php include("./template/pie_pag.php"); ?>