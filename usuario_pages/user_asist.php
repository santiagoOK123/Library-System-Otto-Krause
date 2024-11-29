<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user_asist_style.css">
    <title>Asistencia</title>
</head>

<body>
    <div
        class='cont_principal'>
        <div class="cont_secc">
            <img class="otto_log" src="../img/ottolog.webp" />
            <p>Busqueda</p>
            <p>Filtros</p>
            <p>Reserva</p>
            <p>Posesion de libros</p>
            <p>Calendario</p>
            <p>Notificaciones</p>
            <p>Lista de espera</p>
            <p>Carrito</p>
            <p>Lista de deseos</p>
            <p>Descriptores Temá....</p>
        </div>

        <div class='cont_desc'>
            <div class="titulo">
                <img class="desc_icon" src="../img/arrow.webp" onclick="to_login()" />
                <h1 class="h1_txt">Asistencia al usuario</h1>
            </div>

            <div>

                <div class="tit_secc">
                    <img class="desc_icon" src={icono}/>
                    <h2>{titulo}</h2>
                </div>
                        
                <p>{desc}</p>
                
            </div>








        </div>

    </div>
</body>

</html>

<script>
    function to_login() {
            window.location.href = 'user_login.php'; 
        }
</script>