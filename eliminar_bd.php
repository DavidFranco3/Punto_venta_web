<?php
require_once 'conexion.php';

$codigo_barras = $_GET["codigo_barras"];

$sql = "DELETE FROM productos WHERE codigo_barras = '$codigo_barras'";
$resultado = $db->query($sql);

if ($resultado) {
    
    header("Location:index_productos.php");
}

else {
    echo "OCURRIO UN ERROR: " . $db->error;
}
?>