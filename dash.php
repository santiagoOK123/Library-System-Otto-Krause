
<?php require "./config/config.php"?>
<?php  require "./libs/App.php"?>
<?php
   

   
   $app = new App;
   $query_prest = "SELECT * FROM orden WHERE estado IN ('En curso', 'Sin devolver')";
   $prest_list = $app->selectAll($query_prest);

   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $search = $_POST['search'];
   
    $query_search = "SELECT * FROM orden WHERE  DNI LIKE ? AND estado IN ('En curso', 'Sin devolver', 'Finalizado')";
    
    $results = $app->select_all_like($query_search, $search);
    echo json_encode($results);
    exit;
    
}
   

?>

<?php include("./template/nav.php"); ?>

<link rel="stylesheet" href="./css/dash.css"/>

<div class="cont_gen_dash">
    
  

    <form class="cont_header_dash" action="dash.php" method="get">
        <h1>Panel de control</h1>
        <input type="text" id="search" placeholder="Busca por DNI" onkeyup="fetchSearchResults()"/>

    </form>

    <div class="cont_body_dash">
        <div class="cont_secc_dash">
            <p>Documento</p>
            <p>Cantidad de libros</p>
            <p>Fecha de retiro</p>
            <p>Fecha de devolución</p>
            <p>Estado</p>
            <p>Codigo Reserva</p>

        </div>

        <div class="cont_casos_dash" id="results">
            
           
            

            
            


        </div>

    </div>


</div>




<script>
        const maxHeight = Math.max(
        document.body.scrollHeight,
        document.documentElement.scrollHeight
        );
        document.documentElement.style.setProperty('--max-height', `${maxHeight}px`);





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
                const div = document.createElement('div');
                
               
                div.innerHTML = ` <a class="caso_user" href="dash_user.php?id_orden=${item.id_orden} ">
                <p id="dni">${item.DNI}</p>
                <p id="cant_lib">${item.cantidad}</p>
                <p id="f_ret">${item.fecha_retiro}</p>
                <p id="f_dev">${item.fecha_devolucion}</p>
                <p id="estado">${item.estado}</p>
                <p id="estado">${item.codigo_reserva}</p>
                </a>`;
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