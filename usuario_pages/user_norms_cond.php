<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user_norms_conds.css">
    <title>Normas y condiciones</title>

</head>

<body>
    

    <div class='cont_principal-nc'>
    
        <div class='cont_side'>
        <img class="otto_log" src="../img/ottolog.webp" />

            <div class="user_button" id="usu_hidden" onclick="user_show()">
                <p>Usuario</p>
            </div>
            <div class="user_button" id="adm_open" onclick="admin_show()">
                <p>Administrador</p>
            </div>

        </div>
        <div class='inform'>
            <div class="titulo-nc">
                <h1>Normas y condiciones</h1>
            </div>

            <div class="cont_descrip_usu" id="cont_user">
                <div>
                    <h2>{titulo}</h2>
                    <p>{desc}</p>
                </div>


            </div>

            <div class="cont_descrip_adm" id="cont_adm">

                <div>
                    <p>{titulo}:</p>
                    <ul>
                        <li>desc_point</li>
                    </ul>
                </div>

                <div>
                    <p>{titulo}:</p>
                    <ul>
                        <li>desc_point</li>
                    </ul>
                </div>

                <div>
                    <p>{titulo}:</p>
                    <ul>
                        <li>desc_point</li>
                    </ul>
                </div>

                <div>
                    <p>{titulo}:</p>
                    <ul>
                        <li>desc_point</li>
                    </ul>
                </div>

                <div>
                    <p>{titulo}:</p>
                    <ul>
                        <li>desc_point</li>
                    </ul>
                </div>

            </div>

        </div>

    </div>
</body>

</html>

<script>
    const user_norms = document.querySelector(".cont_descrip_usu")
    const admin_norms = document.querySelector(".cont_descrip_adm")

    function user_show() {
        if (document.querySelector('.cont_descrip_usu.hidden')) {
            user_norms.classList.remove("hidden")
            admin_norms.classList.remove("open")
        } else { }
    }

    function admin_show() {
        if (document.querySelector('.cont_descrip_adm.open')) {
            
        } else { 
            admin_norms.classList.add("open")
            user_norms.classList.add("hidden")
        }
    }
</script>