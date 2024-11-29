<?php include("./template/nav.php"); ?>
<?php require "./config/config.php"?>
<?php  require "./libs//App.php"?>
<?php
    $app = new App;

   
    $query_ord = "SELECT o.* FROM orden o JOIN bloqueo b ON o.DNI = b.DNI JOIN usuario u ON o.DNI = u.DNI WHERE o.estado = 'Sin devolver'";

    $list_ord_bloq = $app->selectAllBloqueados($query_ord);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
        $search = $_POST['search'];
       
        $query_search = "SELECT * FROM orden WHERE DNI LIKE ? AND estado = 'Sin devolver'";
        
        $results = $app->select_all_like($query_search, $search);
        echo json_encode($results);
        exit;
    }


?>

<link rel="stylesheet" href="./css/bloq_style.css"/>
    <div class="cont_gen_bloq">

        <form class="cont_header_bloq" action="bloqueados.php" method="get">
            <h1>Bloqueados</h1>
            <input type="text" id="search" placeholder="Busca por DNI" onkeyup="fetchSearchResults()"/>
        </form>

        <div class="cont_body_bloq">
            <div class="cont_secc_bloq">
                <p>Documento</p>
                <p>Cantidad de libros</p>
                <p>Fecha de devolucion</p>
               
                <p>Devolucion del libro</p>

            </div>

            <div class="cont_casos_bloq" id="results">
              
                    
                

                

                
            </div>
        </div>

    </div>

    <script>
       


       function fetchSearchResults() {
    const query = document.getElementById('search').value;
    fetch('dash.php', {
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

                if(item.estado == 'Sin devolver'){
                    const div = document.createElement('div');
                
               
                    div.innerHTML = ` <a class="caso_user_bloq" href="bloqueados_user.php?id_orden=${item.id_orden} ">
                    <p id="dni">${item.DNI}</p>
                    <p id="cant_lib">${item.cantidad}</p>
                    <p id="f_dev">${item.fecha_devolucion}</p>
                    <p id="dev_lib">${item.estado}</p>
                    </a>`;
                    resultsContainer.appendChild(div);

                }
                
            });
        } else {
            resultsContainer.innerHTML = '<p>No se encontraron resultados.</p>';
        }
    })
    .catch(error => console.error('Error:', error));
}
    </script>
<?php include("./template/pie_pag.php"); ?>