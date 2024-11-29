<?php 
require "./config/config.php";
require "./libs/App.php";

$app = new App;
$query_ord = "SELECT * FROM orden";
$ord_list = $app->selectAll($query_ord);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $search = $_POST['search'];
   
    $query_search = "SELECT * FROM orden WHERE DNI LIKE ?";
    
    $results = $app->select_all_like($query_search, $search);
    echo json_encode($results);
    
    
    exit;
}


?>

<?php include("./template/nav.php"); ?>

<!-- Vincular el CSS actualizado -->
<link rel="stylesheet" href="./css/ord_styles.css"/>
<style>
    .cont_casos_ord {
        height: 82.6%;
    }

    .cont_body_ord {
        overflow-y: auto;
        max-height: 600px;
    }

    ::-webkit-scrollbar {
    width: 10px;
    height: 5px; 
}


::-webkit-scrollbar-thumb {
    background-color: rgb(96,96,96);
    border-radius: 100px; 
}
    </style>

<div class="cont_gen_ord">
    <!-- Header con título y barra de búsqueda -->
    <form class="cont_header_ord" action="ordenes.php" method="get">
        <h1>Órdenes</h1>
        <input type="text" id="search" placeholder="Busca por DNI" onkeyup="fetchSearchResults()"/>
    </form>

    <!-- Tabla de órdenes -->
    <div class="cont_body_ord">
        <!-- Encabezados de la tabla -->
        <div class="cont_secc_ord">
            <p>Documento</p>
            <p>Cantidad de libros</p>
            <p class="fecha">Fecha de pedido</p>
            <p>Retiro del libro</p>
        </div>

        <!-- Filas dinámicas generadas desde PHP -->
        <div class="cont_casos_ord" id="results">
           
        </div>
    </div>
</div>
<script>
       


       function fetchSearchResults() {
    const query = document.getElementById('search').value;
    fetch('ordenes.php', {
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
                if(item.estado == 'Sin retirar' || item.estado == 'Plazo vencido'){
                    const div = document.createElement('div');
                
               
                    div.innerHTML = ` <a class="caso_user_ord">
                    <p id="dni">${item.DNI}</p>
                    <p id="cant_lib">${item.cantidad}</p>
                    <p id="f_pedido"  class="fecha">${item.fecha_pedido}</p>
                    <p id="estado_retiro">${item.estado}</p>
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
