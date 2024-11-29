<?php
session_start();
session_unset(); // Eliminar todas las variables de sesión
session_destroy(); // Destruir la sesión
header("Location: ../usuario_pages/user_home.php"); // Redirigir a la página de login
exit;
?>