<?php require "../config/config.php"?>
<?php  require "../libs/App.php"?>
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
<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../css/search_lib_user_t_style.css">
     <title>Biblioteca Otto Krause</title>
</head>
<body>
     <div class="search_container">
       
               
               
        
          <header>
                    <div class="cont_nav">
                        <a href="../usuario_pages/user_home.php">
                        <img class="otto_log_n" src="../img/ottolog.webp" />
                        </a>
                         
                        
                              <input type="text" id="search" onkeyup="fetchSearchResults()">

                         
                         <?php include("../template/user_nav.php"); ?>
                    </div>
          </header>
          
          <main class="search_main">
              
               <div class="book-gallery_s" id="results">
                    
                   
               </div>
          </main>
     </div>


    

     
<script>

function fetchSearchResults() {
    const query = document.getElementById('search').value;
    fetch('user_search.php', {
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
                div.innerHTML = ` <a  href="user_book_info.php?id_libro=${item.id_libro}" > <img src="../img/portadas/${item.portada}" class="image_galery"/> </a>
                <div class="book-info">
                    <h3>${item.titulo}</h3>
                    <p>Autor: ${item.autor}</p>
                    <p>${disponibilidad}</p>
                </div>
                `;
                resultsContainer.appendChild(div);
            });
        } else {
            resultsContainer.innerHTML = '<p>No se encontraron resultados.</p>';
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>

<?php include("../template/pie_pag_user_search.php"); ?>
