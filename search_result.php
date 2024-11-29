<?php require "./config/config.php"?>
<?php  require "./libs/App.php"?>

<?php 
$app = new App;
if (isset($_GET['id_libro'])){
    $id_libro = $_GET['id_libro'];
    $query = "SELECT * FROM libro WHERE id_libro='$id_libro'";
    $one = $app->selectOne($query);

    if(isset($_POST['submit'])){
        $dni = $_POST['dni'];
        $desde = $_POST['desde'];
        $hasta = $_POST['hasta'];

        $query_check_dni = "SELECT * FROM usuario WHERE DNI='$dni'";

        
        if($app->checkEmailExists($query_check_dni) == true){

            if($one->disponible > 0){
                $app->insertPrest($dni,$desde,$hasta,$id_libro);

                echo'<script type="text/javascript">
                alert("Libro prestado con exito");
                </script>';
                
            }else{
                echo'<script type="text/javascript">
                alert("Ese libro no tiene stock");
                </script>';
            }
            


           
       
            

        }else{
            echo'<script type="text/javascript">
            alert("No existe ese DNI en la bd");
            </script>';
        }
        

    }
}


?>


<?php include("./template/nav.php"); ?>

<link rel="stylesheet" href="./css/search_result_style.css"/>
<div class="cont_gen_search_result">

    <div class="cont_header_search_result">
        <h1>Área administrativa</h1>
        
    </div>

    <div class="cont_princ_search_result">

        
        <img class="cont_port_search_result" src="./img/portadas/<?php echo $one->portada?>" alt="">
        

        <div class="cont_side_search_result">

            <div class="cont_info_lib_search_result">
                <p>Título: <?php echo $one->titulo?></p>
                <p>Autor: <?php echo $one->autor?></p>
                <p>Editorial: CCH Editorial</p>
                <p>Número de edición: <?php echo $one->numero_edicion; ?></p>
                <p>Lugar de edición: Argentina</p>
                <p>Idioma: Español</p>
                <p>ISBN: <?php echo $one->ISBN; ?></p>
                <p>Ubicación: <?php echo $one->ubicacion; ?></p>
                <p>Descriptores temáticos:</p>
                <p>Primario: Química</p>
                <p>Secundario: Materia; Partículas; Hierro; Ciencia; Energía; Sustancias; Mezclas.</p>


            </div>
            <form class="cont_inputs_search_result" action="search_result.php?id_libro=<?php echo $id_libro?>" method="POST">
                <input class="ing_dni_search_result" type="number" required placeholder="ingresar DNI" name="dni">

                <div class="cont_period_search_result">
                    <input class="desde_search_result" type="date" required placeholder="Desde" name="desde">
                    <input class="hasta_search_result" type="date" required placeholder="Hasta" name="hasta">

                </div>

                <button class="prest_button_search_result" type="submit" name="submit">Prestar ahora</button>
                
            </form>
            

            </div>

        </div>

    </div>

</div>


<script>

    

</script>



<?php include("./template/pie_pag.php"); ?>