<?php
session_start();
if ($_SESSION['us_tipo'] == 2) {

?>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>Tecnico</title>
    </head>

    <body>
        <h1>Hola Tecnico</h1>
        <a href="../controlador/Logout.php">Cerrar sesion</a>

    </body>

    </html>
<?php
} else {
    header('Location: ../index.php');
}
?>