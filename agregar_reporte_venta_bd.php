<?php
require_once 'conexion.php';

$sql = "INSERT INTO venta VALUES (DEFAULT, NOW(), DEFAULT)";
$resultado = $db->query($sql);
?>

<html>

    <head>
        <title>Mi sistema</title>
        <link rel="stylesheet" type="text/css" href="estilos/estilo.css" media="screen" />

    </head>

    <?php
    if ($resultado)
        header("Location:index.php");
    ?>

</html>