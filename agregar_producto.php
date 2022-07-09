<?php

require_once 'conexion.php';
if (isset($_GET["venta"]) && isset($_GET["producto"])) {

        $id_venta = $_GET["venta"];
        $id_producto = $_GET["producto"];
    
    $consulta_producto = "SELECT * FROM productos WHERE id_producto = $id_producto";
    $resultado_producto = $db->query($consulta_producto);

    $cantidad = "";

    while ($registro_producto = $resultado_producto->fetch_array()) {
        $cantidad = $registro_producto["cantidad"];
    }
    if ($cantidad > 0) {
        

        $sql = "UPDATE venta_detalle SET "
                . "cantidad = cantidad + 1, "
                . "total = cantidad * precio_venta, "
                . "fecha_modificacion = NOW()"
                . "WHERE venta = '$id_venta' AND producto = '$id_producto' ";
        $resultado = $db->query($sql);

        if ($resultado) {
            header("Location:agregar_venta.php?id_venta=" . $id_venta);
        } else {
            echo "OCURRIO UN ERROR: " . $db->error;
        }
    } else {
        echo "el producto esta agotado";
    }
}
?>