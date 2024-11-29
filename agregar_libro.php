<?php require "./config/config.php"?>
<?php  require "./libs/App.php"?>


<?php 
session_start();
    $app = new App;

    if(isset ($_POST['submit'])){

        $id_editorial = $_POST['id_editorial'];
        $titulo = $_POST['titulo'];
        $autor = $_POST['autor'];
        $idioma = $_POST['idioma'];
        $paginas = $_POST['paginas'];
        $numero_edicion = $_POST['numero_edicion'];
        $lugar_edicion = $_POST['lugar_edicion'];
        $anio_edicion = $_POST['anio_edicion'];
        $descriptor_primario = $_POST['descriptor_primario'];
        $descriptor_secundario = $_POST['descriptor_secundario'];
        $ISBN = $_POST['ISBN'];
        $ISSN = $_POST['ISSN'];
        $notas = $_POST['notas'];
        $cantidad_ejemplares = $_POST['cantidad_ejemplares'];
        $ubicacion = $_POST['ubicacion'];

        $portada = $_FILES['portada']['name'];

        $dir = "./img/" . basename($portada);

        $sql = "INSERT INTO libro (id_editorial, titulo, autor, idioma, paginas, numero_edicion, lugar_edicion, anio_edicion, descriptor_primario, descriptor_secundario, ISBN, ISSN, notas, cantidad_ejemplares, ubicacion, portada) 
            VALUES (:id_editorial, :titulo, :autor, :idioma, :paginas, :numero_edicion, :lugar_edicion, :anio_edicion, :descriptor_primario, :descriptor_secundario, :ISBN, :ISSN, :notas, :cantidad_ejemplares, :ubicacion, :portada)";

        $arr = [
            ":id_editorial" => $id_editorial,
            ":titulo" =>$titulo,
            ":autor" =>$autor,
            ":idioma" =>$idioma, 
            ":paginas" =>$paginas, 
            ":numero_edicion" =>$numero_edicion,
            ":lugar_edicion" =>$lugar_edicion, 
            ":anio_edicion" =>$anio_edicion, 
            ":descriptor_primario" =>$descriptor_primario,
            ":descriptor_secundario" =>$descriptor_secundario,
            ":ISBN" =>$ISBN,
            ":ISSN" =>$ISSN,
            ":notas" =>$notas, 
            ":cantidad_ejemplares" =>$cantidad_ejemplares, 
            ":ubicacion" =>$ubicacion,
            ":portada" => $portada,

        ];

        $path = "libro_public_advice.php";

        if(move_uploaded_file($_FILES['portada']['tmp_name'], $dir)){
            $app->register($sql, $arr, $path);
        }else{
            $arr = [
                ":id_editorial" => $id_editorial,
                ":titulo" =>$titulo,
                ":autor" =>$autor,
                ":idioma" =>$idioma, 
                ":paginas" =>$paginas, 
                ":numero_edicion" =>$numero_edicion,
                ":lugar_edicion" =>$lugar_edicion, 
                ":anio_edicion" =>$anio_edicion, 
                ":descriptor_primario" =>$descriptor_primario,
                ":descriptor_secundario" =>$descriptor_secundario,
                ":ISBN" =>$ISBN,
                ":ISSN" =>$ISSN,
                ":notas" =>$notas, 
                ":cantidad_ejemplares" =>$cantidad_ejemplares, 
                ":ubicacion" =>$ubicacion,
                ":portada" => 'portada_deafult.jpg',
    
            ];
            $app->register($sql, $arr, $path);
        }
    }


?>

<?php include("./template/nav.php"); ?>



<link rel="stylesheet" href="./css/add_lib_style.css">

<div class="cont_gen_add_lib">
    <div class="cont_header_add_lib">
        <h1>Agregar libro</h1>
    </div>

    <form action="agregar_libro.php" method="POST" class="cont_princ_add_lib" enctype="multipart/form-data">

        <div class="cont_port_add_lib">
            <p>Elegi una portada (Opcional)</p>
            <div class="port_add_lib">
                <label class="file_input_add_lib" for="file-upload"> <img src="./img/upload_img.png" alt=""></label>
                <input  id="file-upload"  type="file" name="portada">
            </div>
        </div>
       
        <div class="cont_gen_datos_add_lib">
            <div class="cont_datos_llenar_add_lib">

                <div class="cont_datos_1_add_lib">

                    <div class="cont_titulo_add_lib">
                        <p>Titulo del libro o revista</p>
                        <input type="text" name="titulo" required>
                    </div>

                    <div class="cont_edito_add_lib">
                        <p>Editorial</p>
                        <input type="number" name="id_editorial">
                    </div>


                    <div class="cont_id_añ_add_li">

                        <div class="cont_año_add_lib">
                            <p>Año</p>
                            <input type="number" name="anio_edicion" >
                        </div>

                        <div class="cont_idiom_add_lib">
                            <p>Idioma</p>
                            <input type="text" name="idioma" >
                        </div>
                    </div>

                    <div class="cont_isb_iss_add_lib">
                        <div class="cont_isbn_add_lib">
                            <p>ISBN(opcional)</p>
                            <input type="text" name="ISBN">
                        </div>

                        <div class="cont_issn_add_lib">
                            <p>ISSN(opcional)</p>
                            <input type="text" name="ISSN">
                        </div>

                    </div>

                    <div class="cont_desc_tem_add_lib">
                        <p>Descriptor temático primario</p>
                        <input type="text"  name="descriptor_primario">
                    </div>

                    <div class="cont_checkb_add_lib">
                        <div class="cont_lite_add_lib">
                            <p>Literatura</p>
                            <button class="lit_check" ></button>
                        </div>

                        <div class="cont_teory_add_lib">
                            <p>Teoría</p>
                            <button class="teory_check"></button>
                            
                        </div>

                    </div>



                </div>

                <div class="cont_datos_2_add_lib">

                    <div class="cont_autor_add_lib">
                        <p>Autor</p>
                        <input type="text" name="autor" required>
                    </div>

                    <div class="cont_edi_add_lib">
                        <div class="cont_nedi_add_lib">
                            <p>N° de edición</p>
                            <input type="number" name="numero_edicion" >
                        </div>

                        <div class="cont_lug_edi_add_lib">
                            <p>Lugar de edición</p>
                            <input type="text" name="lugar_edicion" >
                        </div>

                    </div>

                    <div class="cont_num_ejem_add_lib">
                        <p>N° de ejemplares</p>
                        <input type="number" name="cantidad_ejemplares" >
                    </div>


                    <div class="cont_ubi_bi_add_lib">
                        <p>Ubicacion en la biblioteca</p>
                        <input type="text" name="ubicacion" >
                    </div>

                    <div class="cont_desc_tem_sec_add_lib">
                        <p>Descriptores tematicos secundarios</p>
                        <input type="text" name="descriptor_secundario" >
                    </div>

                    <select class="cont_mat_rel_lib" value="" name="" id="" >
                        <option value="">Materia relacionada</option>
                        <option value="">Lieratura</option>
                        <option value="">Matematica</option>
                        <option value="">Ciencia</option>
                        <option value="">Fisica</option>
                    </select>

                    <div class="cont_paginas_add_lib">
                        <p>Número de páginas</p>
                        <input type="number" name="paginas" >
                    </div>
                    
                </div>

            </div>
            <div class="cont_notas_add_lib">
                <p>Notas</p>
                <textarea rows="0" name="notas"></textarea >
                
            </div>

            
            <button type="submit" name="submit" class="cont_button_add_lib">Publicar</button>

        </div>




    </form>
</div>

<script>
    const maxHeight = Math.max(
    document.body.scrollHeight,
    document.documentElement.scrollHeight
    );
    document.documentElement.style.setProperty('--max-height', `${maxHeight}px`);
    const lit_button = document.querySelector('.lit_check')
    const teory_button = document.querySelector('.teory_check')

    lit_button.addEventListener('click', (e) =>{
        e.preventDefault();
        if (document.querySelector('.lit_check.check')) {
            lit_button.classList.remove('check')
            teory_button.classList.add('check')
        }else{
            lit_button.classList.add('check')
            teory_button.classList.remove('check')
        }
        
    })

    teory_button.addEventListener('click', (e) =>{
        e.preventDefault();
        if (document.querySelector('.teory_check.check')) {
            teory_button.classList.remove('check')
            lit_button.classList.add('check')
        }else{
            teory_button.classList.add('check')
            lit_button.classList.remove('check')
        }
        
    })

    function to_public_advice() {
           
           window.location.href = 'libro_public_advice.php'; 
       }
</script>


<?php include("./template/pie_pag.php"); ?>