<?php require "./config/config.php"?>
<?php  require "./libs/App.php"?>


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




<link rel="stylesheet" href="./css/search_preview_style.css"/>

    <div class="cont_gen_search_preview">

        <h1>Área administrativa</h1>
        <form action="search_preview.php" method="get">
            <input type="text" id="search" onkeyup="fetchSearchResults()">


        </form>
        

        <div class="cont_lib_search_preview" id="results">

           
            

        </div>
    </div>


    <script>
        function to_search_result() {
            window.location.href = 'search_result.php'; // Cambia 'pagina.php' por la URL a la que deseas redirigir
        }
        const maxHeight = Math.max(
        document.body.scrollHeight,
        document.documentElement.scrollHeight
        );
document.documentElement.style.setProperty('--max-height', `${maxHeight}px`);

    


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
               
                div.innerHTML = ` <a href="search_result.php?id_libro=${item.id_libro}" class="portada_prev_modif"> <img src="./img/portadas/${item.portada}" alt=""> </a>
                <div class="book-info">
                    <h3>${item.titulo}</h3>
                    <p>Autor: ${item.autor}</p>
                    <p>${disponibilidad}</p>
                </div>`;
               
                /* div.innerHTML = ` <a href="search_result.php?id_libro=${item.id_libro}"> <img src="./img/portadas/${item.portada}" alt=""> </a>`; */
                resultsContainer.appendChild(div);
            });
        } else {
            resultsContainer.innerHTML = '<p>No se encontraron resultados.</p>';
        }
    })
    .catch(error => console.error('Error:', error));
}
    </script>
    

<?php include("./template/pie_pag.php"); ?>