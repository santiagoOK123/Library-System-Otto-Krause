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
$id_libro = $_SESSION['id_libro'];
if (isset($_POST['submit'])){

    $id_editorial = $_POST['id_editorial'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $idioma = $_POST['idioma'];
    
    $numero_edicion = $_POST['numero_edicion'];
    $lugar_edicion = $_POST['lugar_edicion'];
    $anio_edicion = $_POST['anio_edicion'];
    $descriptor_primario = $_POST['descriptor_primario'];
    $descriptor_secundario = $_POST['descriptor_secundario'];
    $ISBN = $_POST['ISBN'];
    $ISSN = $_POST['ISSN'];
    $cantidad_ejemplares = $_POST['cantidad_ejemplares'];
    $ubicacion = $_POST['ubicacion'];

    
    
    $app->update_lib($id_libro,$titulo,$autor,$id_editorial,$anio_edicion,$idioma, 
    $ISBN, $ISSN,$descriptor_primario,$descriptor_secundario,$numero_edicion,$ubicacion,$cantidad_ejemplares);


}
?>

<?php include("./template/nav.php");?>

<link rel="stylesheet" href="./css/modif_libro_style.css">

<div class="cont_gen_modif_lib">
    <div class="cont_header_modif_lib">
        <h1>Modificar libro</h1>
    </div>
   
    <form action="modif_libro.php?id_libro=<?php echo $_SESSION['id_libro']?>" method="POST" class="cont_princ_modif_lib">

        <div class="cont_port_modif_lib">
            <label class="file_input_modif_lib" for="file-upload">Cambiar portada</label>
            <input  id="file-upload"  type="file">
                <img src="./img/portadas/<?php echo $lib->portada?>" alt="">
        </div>
       
        <div class="cont_gen_datos_modif_lib">
            <div class="cont_datos_llenar_modif_lib">

                <div class="cont_datos_1_modif_lib">
                    
                    <input type="hidden" name="id_libro" value="<?php echo $lib->id_libro; ?>" />

                    <div class="cont_titulo_modif_lib">
                        <p>Titulo del libro o revista</p>
                        <?php echo "<input type='text' value='$lib->titulo' name='titulo' />" ?>
                    </div>

                    <div class="cont_edito_modif_lib">
                        <p>Editorial</p>
                        <?php echo "<input type='text' value='$lib->id_editorial' name='id_editorial'/>" ?>
                    </div>


                    <div class="cont_id_añ_modif_li">

                        <div class="cont_año_modif_lib">
                            <p>Año</p>
                            <?php echo "<input type='text' value='$lib->anio_edicion' name='anio_edicion' />" ?>
                        </div>

                        <div class="cont_idiom_modif_lib">
                            <p>Idioma</p>
                            <?php echo "<input type='text' value='$lib->idioma' name='idioma'/>" ?>
                        </div>
                    </div>

                    <div class="cont_isb_iss_modif_lib">
                        <div class="cont_isbn_modif_lib">
                            <p>ISBN</p>
                            <?php echo "<input type='text' value='$lib->ISBN' name='ISBN'/>" ?>
                        </div>

                        <div class="cont_issn_modif_lib">
                            <p>ISSN</p>
                            <?php echo "<input type='text' value='$lib->ISSN' name='ISSN'/>" ?>
                        </div>

                    </div>

                    <div class="cont_desc_tem_modif_lib">
                        <p>Descriptor temático primario</p>
                        <?php echo "<input type='text' value='$lib->descriptor_primario' name='descriptor_primario'/>" ?>
                    </div>

                    <div class="cont_checkb_modif_lib">
                        <div class="cont_lite_modif_lib">
                            <p>Lieratura</p>
                            <button class="lit_check" ></button>
                        </div>

                        <div class="cont_teory_modif_lib">
                            <p>Teoría</p>
                            <button class="teory_check" ></button>
                            
                        </div>

                    </div>



                </div>

                <div class="cont_datos_2_modif_lib">

                    <div class="cont_autor_modif_lib">
                        <p>Autor</p>
                        <?php echo "<input type='text' value='$lib->autor' name='autor'/>" ?>
                    </div>

                    <div class="cont_edi_modif_lib">
                        <div class="cont_nedi_modif_lib">
                            <p>N° de edición</p>
                            <?php echo "<input type='text' value='$lib->numero_edicion' name='numero_edicion'/>" ?>
                        </div>

                        <div class="cont_lug_edi_modif_lib">
                            <p>Lugar de edición</p>
                           
                            <?php echo "<input type='text' value='$lib->lugar_edicion' name='lugar_edicion'/>" ?>
                        </div>

                    </div>

                    <div class="cont_num_ejem_modif_lib">
                        <p>N° de ejemplares</p>
                       
                        <?php echo "<input type='number' value='$lib->cantidad_ejemplares' name='cantidad_ejemplares'/>" ?>
                    </div>


                    <div class="cont_ubi_bi_modif_lib">
                        <p>Ubicacion en la biblioteca</p>
                        <?php echo "<input type='text' value='$lib->ubicacion' name='ubicacion'/>" ?>
                    </div>

                    <div class="cont_desc_tem_sec_modif_lib">
                        <p>Descriptores tematicos secundarios</p>
                        <?php echo "<input type='text' value='$lib->descriptor_secundario' name='descriptor_secundario'/>" ?>
                    </div>

                    <select class="cont_mat_rel_lib" value="Lieratura" name="" id="" >
                        <option value="">Materia relacionada</option>
                        <option value="">Lieratura</option>
                        <option value="">Matematica</option>
                        <option value="">Ciencia</option>
                        <option value="">Fisica</option>
                    </select>
                    
                
                   
                    
                </div>

            </div>
            <div class="cont_notas_modif_lib">
                <p>Notas</p>
                <textarea rows="0" >Placeholder</textarea >
                
            </div>


            
            <button type="submit" name="submit" class="cont_button_modif_lib">Actualizar</button>

        </div>




    </form>
</div>

<div class="overlay_modif_overlay"></div>

<script>
    const stop_modif = document.querySelector('.overlay_modif_overlay')
    const lit_button = document.querySelector('.lit_check')
    const teory_button = document.querySelector('.teory_check')

    const act_button = document.querySelector('.cont_button_modif_lib')

  /*   act_button.addEventListener('click', (e) =>{
        e.preventDefault();
        if (document.querySelector('.cont_button_modif_lib.pressed')) {
            
        }else{
            alert('el libro se ha actualizado')
            act_button.classList.add('pressed')
            stop_modif.classList.add('open')
        }

    }) */

/*     lit_button.addEventListener('click', (e) =>{
        e.preventDefault();
        if (document.querySelector('.lit_check.check')) {
            lit_button.classList.remove('check')
        }else{
            lit_button.classList.add('check')
            teory_button.classList.remove('check')
        }
        
    }) */

/*     teory_button.addEventListener('click', (e) =>{
        e.preventDefault();
        if (document.querySelector('.teory_check.check')) {
            teory_button.classList.remove('check')
        }else{
            teory_button.classList.add('check')
            lit_button.classList.remove('check')
        }
        
    }) */
</script>




<?php include("./template/pie_pag.php");?>