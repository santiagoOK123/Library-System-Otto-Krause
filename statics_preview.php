<?php include("./template/nav.php"); ?>




<link rel="stylesheet" href="./css/statics_preview_style.css"/>

    <div class="cont_gen_statics_preview">

        <div class="cont_header_statics_preview">
            <h1>Estadísticas</h1>
            <input type="text" placeholder="buscar libro especifico">
        </div>
        
        <h2>Libros más demandados</h2>
        <div class="cont_lib_statics_preview">

            <img src="./img/portadas/Portada_4.png" alt="" onclick="to_statics_result()">

            <img src="./img/portadas/Portada_12.png" alt="" onclick="to_statics_result()">

            <img src="./img/portadas/Portada_13.png" alt="" onclick="to_statics_result()">

            <img src="./img/portadas/Portada_6.png" alt="" onclick="to_statics_result()">

            <img src="./img/portadas/Portada_9.png" alt="" onclick="to_statics_result()">

            <img src="./img/portadas/Portada_21.png" alt="" onclick="to_statics_result()">

        </div>
    </div>


    <script>
        function to_statics_result() {
            window.location.href = 'statics_result.php'; // Cambia 'pagina.php' por la URL a la que deseas redirigir

        }

        const maxHeight = Math.max(
        document.body.scrollHeight,
        document.documentElement.scrollHeight
        );
        document.documentElement.style.setProperty('--max-height', `${maxHeight}px`);
    </script>

<?php include("./template/pie_pag.php"); ?>