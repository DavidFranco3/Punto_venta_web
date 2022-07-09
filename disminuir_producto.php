<?php

require_once 'conexion.php';

if (isset($_GET["venta"]) && isset($_GET["producto"])) {

    $id_venta = $_GET["venta"];
    $id_producto = $_GET["producto"];

    $sql = "UPDATE venta_detalle SET "
            . "cantidad = cantidad - 1,"
            . "total = cantidad * precio_venta,"
            . "fecha_modificacion = NOW() "
            . "WHERE venta = '$id_venta' AND producto = '$id_producto' AND cantidad>=1";
    $resultado = $db->query($sql);

    if ($resultado) {

        header("Location:agregar_venta.php?id_venta=" . $id_venta);
    } else {
        echo "OCURRIO UN ERROR: " . $db->error;
    }
    $sql = "DELETE FROM venta_detalle WHERE cantidad = 0";
    $resultado = $db->query($sql);

    if ($resultado) {

        header("Location:agregar_venta.php?id_venta=" . $id_venta);
    } else {
        echo "OCURRIO UN ERROR: " . $db->error;
    }
} 
?>