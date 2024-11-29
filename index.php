<?php include("./template/nav.php");?>

            <link rel="stylesheet" href="./css/home_style.css">
                <div class='cont_principal_adh'>
                    <h1>Área administrativa</h1>

                    <div class='search_adh'>
                        
                        <input type="text" placeholder="Buscar libro por nombre, código, ISBN o palabras clave" onclick="to_search_preview()"/>
                        
                       
                    </div>

                    <div class='cont_ing_codigo_adh'>

                        <a href="codigo_reserva.php" class='cod_reser_adh'>Codigo de reserva</a>
                        <a href="codigo_devol.php" >Codigo de devolucion</a>

                    </div>

                    <div class='cont_modif_lib_as_adh'>
                            <div class='cont_agregar_adh'>
                                <a href="agregar_libro.php"><img src="./img/plus.png" alt="" /></a>
                                <p>Agregar libro</p>
                            </div>
                            <div class='cont_delete_adh'>
                                <a href="eliminar_libro_preview.php"><img src="./img/cubo_b.png" alt=""/></a>
                                <p>Eliminar libro</p>
                            </div>
                            <div class='cont_modif_adh'>
                                <a href="modif_libro_preview.php"><img src="./img/modicon.webp" alt=""/></a>
                                <p>Modificar libro</p>


                            </div>
                    </div>

                   
                </div>


<script>
    function to_search_preview() {
           
            window.location.href = 'search_preview.php'; 
        }
        const maxHeight = Math.max(
    document.body.scrollHeight,
    document.documentElement.scrollHeight
    );
    document.documentElement.style.setProperty('--max-height', `${maxHeight}px`);
</script>

<?php include("./template/pie_pag.php");?>