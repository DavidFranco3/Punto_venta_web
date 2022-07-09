<?php
require_once 'conexion.php';

$codigo_barras = $_GET["codigo_barras"];
$descripcion = $_GET["descripcion"];
$cantidad = $_GET["cantidad"];
$precio_venta = $_GET["precio_venta"];

$sql = "INSERT INTO productos VALUES (DEFAULT, '$codigo_barras', '$descripcion', '$cantidad', '$precio_venta', NOW())"
        
     . "
    ON DUPLICATE KEY UPDATE
    descripcion='$descripcion',
    cantidad = cantidad + '$cantidad',
    precio_venta = '$precio_venta',
    fecha_modificacion = NOW()";
$resultado = $db->query($sql);


if ($resultado) {
    
    header("Location:index_productos.php");
}

else {
    echo "OCURRIO UN ERROR: " . $db->error;
}
?>
