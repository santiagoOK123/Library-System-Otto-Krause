
<?php require "./config/config.php"?>
<?php  require "./libs//App.php"?>


<?php
session_start();
$app = new App;
if (isset($_GET['id_libro'])){
    $id_libro = $_GET['id_libro'];

    $query_lib = "SELECT * FROM libro WHERE id_libro='$id_libro'";
    $lib = $app->selectOne($query_lib);


    $_SESSION['id_libro'] = $id_libro;
    

}

if (isset($_POST['submit'])){
    $id_libro = $_GET['id_libro'];

    $query_ord_lib = "SELECT * FROM orden_libro WHERE id_libro = $id_libro";
    if($app->checkEmailExists($query_ord_lib) == true){
       
        $ord_lib = $app->selectOne($query_ord_lib);
        $id_orden = $ord_lib->id_orden;
        
        $update_ord = "UPDATE orden SET cantidad = cantidad - 1 WHERE cantidad > 1 AND id_orden = '$id_orden'";
        $app->update($update_ord);
        $app->delete_book( $id_libro,$id_orden);
        
    }else{
        $app->delete_book_sin_ord( $id_libro);
    }
    
   
   
   
    

    

}

?>


    <?php include("./template/nav.php");?>


    <link rel="stylesheet" href="./css/eliminar_libro_style.css">

    <div class="cont_gen_delete_lib">
        <div class="cont_header_delete_lib">
            <h1>Eliminar libro</h1>
        </div>
        

        <form method="POST" class="cont_princ_delete_lib">

            <div class="cont_port_delete_lib">
                    <img src="./img/portadas/<?php echo $lib->portada?>" alt="">
            </div>
        
            <div class="cont_gen_datos_delete_lib">
                <div class="cont_datos_llenar_delete_lib">

                    <div class="cont_datos_1_delete_lib">

                        <div class="cont_titulo_delete_lib">
                            <p>Titulo del libro o revista</p>
                            <?php echo "<input type='text' placeholder='$lib->titulo' disabled/>" ?>
                        </div>

                        <div class="cont_edito_delete_lib">
                            <p>Editorial</p>
                            <?php echo "<input type='text' placeholder='$lib->id_editorial' disabled/>" ?>
                        </div>


                        <div class="cont_id_añ_delete_li">

                            <div class="cont_año_delete_lib">
                                <p>Año</p>
                                <?php echo "<input type='text' placeholder='$lib->anio_edicion' disabled/>" ?>                        </div>

                            <div class="cont_idiom_delete_lib">
                                <p>Idioma</p>
                                <?php echo "<input type='text' placeholder='$lib->idioma' disabled/>" ?>                        </div>
                        </div>

                        <div class="cont_isb_iss_delete_lib">
                            <div class="cont_isbn_delete_lib">
                                <p>ISBN</p>
                                <?php echo "<input type='text' placeholder='$lib->ISBN' disabled/>" ?>                        </div>

                            <div class="cont_issn_delete_lib">
                                <p>ISSN</p>
                                <?php echo "<input type='text' placeholder='$lib->ISSN' disabled/>" ?>                        </div>

                        </div>

                        <div class="cont_desc_tem_delete_lib">
                            <p>Descriptor temático primario</p>
                            <?php echo "<input type='text' placeholder='$lib->descriptor_primario' disabled/>" ?>                    </div>

                        <div class="cont_checkb_delete_lib">
                            <div class="cont_lite_delete_lib">
                                <p>Lieratura</p>
                                <button class="lit_check" disabled></button>
                            </div>

                            <div class="cont_teory_delete_lib">
                                <p>Teoría</p>
                                <button class="teory_check" disabled></button>
                                
                            </div>

                        </div>



                    </div>

                    <div class="cont_datos_2_delete_lib">

                        <div class="cont_autor_delete_lib">
                            <p>Autor</p>
                            <?php echo "<input type='text' placeholder='$lib->autor' disabled/>" ?>
                        </div>

                        <div class="cont_edi_delete_lib">
                            <div class="cont_nedi_delete_lib">
                                <p>N° de edición</p>
                                <?php echo "<input type='text' placeholder='$lib->numero_edicion' disabled/>" ?>                        </div>

                            <div class="cont_lug_edi_delete_lib">
                                <p>Lugar de edición</p>
                                <?php echo "<input type='text' value='$lib->lugar_edicion' disabled/>" ?>
                                
                            </div>

                        </div>

                        <div class="cont_num_ejem_delete_lib">
                            <p>N° de ejemplares</p>
                            <?php echo "<input type='number' value='$lib->cantidad_ejemplares' disabled/>" ?>
                        </div>


                        <div class="cont_ubi_bi_delete_lib">
                            <p>Ubicacion en la biblioteca</p>
                            <?php echo "<input type='text' placeholder=''$lib->ubicacion' disabled/>" ?>                    </div>

                        <div class="cont_desc_tem_sec_delete_lib">
                            <p>Descriptores tematicos secundarios</p>
                            <?php echo "<input type='text' placeholder='$lib->descriptor_secundario' disabled/>" ?>                    </div>
                        
                        <input class="cont_mat_rel_lib" disabled placeholder="placeholder"></input>    
                        
                    </div>

                </div>
                <div class="cont_notas_delete_lib">
                    <p>Notas</p>
                    <textarea rows="0" disabled>Placeholder</textarea >
                    
                </div>
                
                <button type="button" class="cont_button_delete_lib">Eliminar</button>
            </div>
        </form>
    </div>

    <div class="overlay_delete_lib">
        <div class="modal_delete_lib">
        <form action="eliminar_libro.php?id_libro=<?php echo $id_libro?>"   method="POST">
            <h1>¿Estás seguro de querer eliminar este libro?</h1>
            <div class="cont_buttons_modal_delete_lib">
                <button type="submit" name="submit" class="conf_modal_delete_lib">Confirmar</button>
                <button class="cancel_modal_delete_lib">Cancelar</button>
            </div>
        </form>

        </div>
        
    </div>

    <script>
        const modalDeleteLib = document.querySelector(".overlay_delete_lib");
        const openModalDeleteLib = document.querySelector(".cont_button_delete_lib");
        const cancelModalDeleteLib = document.querySelector(".cancel_modal_delete_lib");
        const confModalDeleteLib = document.querySelector(".conf_modal_delete_lib");

        openModalDeleteLib.addEventListener('click', (e) => {
            e.preventDefault();
            modalDeleteLib.classList.add('open');
        });

        cancelModalDeleteLib.addEventListener('click', (e) => {
            e.preventDefault();
            modalDeleteLib.classList.remove('open');
        });

        confModalDeleteLib.addEventListener('click', (e) => {
           

            
            
            modalDeleteLib.classList.remove('open');
        });
    </script>
    <!-- <div class="overlay_delete_lib">
        <div class="modal_delete_lib">
            <h1>¿Estas seguro de querer eliminar este libro?</h1>
            <div class="cont_buttons_modal_delete_lib">
                <button class="conf_modal_delete_lib">Confirmar</button>
                <button class="cancel_modal_delete_lib">Cancelar</button>

            </div>
            
        </div>
    </div>


    <script>
        const modal_delete_lib = document.querySelector(".overlay_delete_lib")
        const openModal_delete_lib = document.querySelector(".cont_button_delete_lib")
        const cancelModal_delete_lib = document.querySelector(".cancel_modal_delete_lib")
        const confModal_delete_lib = document.querySelector(".conf_modal_delete_lib")

        openModal_delete_lib.addEventListener('click', (e) => {
            e.preventDefault();
            modal_delete_lib.classList.add('open');
        })

        cancelModal_delete_lib.addEventListener('click', (e) => {
            e.preventDefault();
            modal_delete_lib.classList.remove('open');
        })

        confModal_delete_lib.addEventListener('click', (e) => {
            e.preventDefault();
            modal_delete_lib.classList.remove('open');
        })



    </script> -->


    <?php include("./template/pie_pag.php");?>