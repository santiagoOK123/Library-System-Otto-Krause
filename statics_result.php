<?php include("./template/nav.php"); ?>



<link rel="stylesheet" href="./css/statics_result_style.css"/>

<div class="cont_gen_statics_res">

        <div class="cont_header_statics_res">
            <h1>Estadísticas</h1>
            <input type="text">
        </div>

        <div class="cont_princ_statics_res">

            <div class="cont_port_statics_res">
                <h2>En el ultimo mes</h2>
                <img src="./img/portadas/Portada_16.png" alt="">
            </div>

            <div class="cont_info_statics_res">
                
                <button class="config_modal_statics_res"><img src="./img/config_icon_w.png" alt=""></button>
                <div class="cont_grafico_statics_res">

                    <p>Placeholder</p>
                    
                </div>

                <div class="cont_datos_statics_res">
                    <p>Cantidad de prestados: 97</p>
                    <p>Materia que más lo demanda: Lengua y Literatura</p>
                    <p>Especialidad que más lo demanda: Mecánica</p>

                </div>



            </div>




        </div>

</div>


<div class="overlay_modal_statics_res">
    <div class="modal_statics_res">
        <div class="modal_header_statics_res">
            <h1>Modificar parámetros</h1>
            <button class="close_modal_statics_res">X</button>
        </div>
        <div class="cont_select_statics_res">
            <label for="select_statics_res">Tiempo de bloqueo:</label>
            <select  id="select_statics_res">
                <option value="60">60 días</option>
                <option value="30">30 días</option>
        </select>
             
        </div>
       
        <p>Para los usuarios que no hayan devuelto este libro en el tiempo establecido.</p>

        <div class="cont_perm_apla_statics_res">
            <p>Permitir aplazo:</p>

            <button class="yes_apl_statics_res">Sí</button>
            <button class="no_apl_statics_res">No</button>

        </div>
        <p>Para los usuarios que no puedan entregarlo en el día pactado y tengan la posibilidad de aplazar la entrega.</p>

    </div>
     
</div>


<script>
    const modal_statics_res = document.querySelector(".overlay_modal_statics_res")
    const openModal_statics_res = document.querySelector(".config_modal_statics_res")
    const closeModal_statics_res = document.querySelector(".close_modal_statics_res")

    const yes_check_statics_res = document.querySelector(".yes_apl_statics_res")
    const no_check_statics_res = document.querySelector(".no_apl_statics_res")

    openModal_statics_res.addEventListener("click",()=>{
        modal_statics_res.classList.add("open")
    })

    closeModal_statics_res.addEventListener("click",()=>{
        modal_statics_res.classList.remove("open")
    })

    yes_check_statics_res.addEventListener("click",()=>{
        if (document.querySelector('.yes_apl_statics_res.pressed')) {
            yes_check_statics_res.classList.remove('pressed')
            no_check_statics_res.classList.add('pressed')
        }else{
            yes_check_statics_res.classList.add('pressed')
            no_check_statics_res.classList.remove('pressed')
        }
    })

    no_check_statics_res.addEventListener("click",()=>{
        if (document.querySelector('.no_apl_statics_res.pressed')) {
            yes_check_statics_res.classList.add('pressed')
            no_check_statics_res.classList.remove('pressed')
        }else{
            yes_check_statics_res.classList.remove('pressed')
            no_check_statics_res.classList.add('pressed')
        }
    })

    

</script>




<?php include("./template/pie_pag.php"); ?>