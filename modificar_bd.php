<?php
require_once 'conexion.php';

$codigo_barras = $_GET["codigo_barras"];
$descripcion = $_GET["descripcion"];
$cantidad = $_GET["cantidad"];
$precio_venta = $_GET["precio_venta"];

$sql = "UPDATE productos SET descripcion = '$descripcion', "
        . "cantidad = '$cantidad', precio_venta = '$precio_venta', "
        . "fecha_modificacion = NOW() "
        . "WHERE codigo_barras = '$codigo_barras'";
$resultado = $db->query($sql);

if ($resultado) {
    
    header("Location:index_productos.php");
}

else {
    echo "OCURRIO UN ERROR: " . $db->error;
}
?>