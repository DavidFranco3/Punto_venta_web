<?php
require_once 'conexion.php';
$id_venta = $_GET["id_venta"];
$codigo_barras = "";

if (isset($_GET["codigo_barras"])) {
    $codigo_barras = $_GET["codigo_barras"];

    $consulta_producto = "SELECT * FROM productos WHERE codigo_barras = $codigo_barras";
    $resultado_producto = $db->query($consulta_producto);

    $id_producto = "";
    $precio_venta = "";
    $cantidad = "";
    $venta = "";
    
    while ($registro_producto = $resultado_producto->fetch_array()) {
        $id_producto = $registro_producto["id_producto"];
        $precio_venta = $registro_producto["precio_venta"];
        $cantidad = $registro_producto["cantidad"];
    }
    if ($cantidad >= 1) {
        $total = $precio_venta * 1;
        $sql = "INSERT INTO venta_detalle VALUES (DEFAULT, $id_venta, '$id_producto', 1, '$precio_venta', '$total', NOW())"
                . "
    ON DUPLICATE KEY UPDATE
    cantidad = cantidad + 1,
    total = $precio_venta * cantidad,
    fecha_modificacion = NOW()";
        $resultado_venta = $db->query($sql);
    } else {
        echo 'el producto esta agotado';

        //header("Location:agregar_venta.php");
    }
}
?>

<html>

    <head>
        <title>Punto de venta</title>
        <link rel="shortcut icon" href="imagenes/favicon.png">


        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="estilos/estilo.css" media="screen" />
    </head>

    <body>

        <div class="encabezado">
            <?php require_once("encabezado.html"); ?>
        </div>

        <div class="menu">
            <?php require_once("menu.html"); ?>
        </div>

        <div class="contenido">

            <form>


                <input type="hidden" name="id_venta" autofocus="autofocus" 
                       placeholder="Introduce el numero de venta" 
                       value="<?php echo $id_venta; ?>" />

                <label>Producto</label>
                <input type="text" name="codigo_barras" autofocus="autofocus" 
                       required="required" pattern="[0-9]{12}" minlength="12" maxlength="12" 
                       placeholder="Introduce el codigo de barras" title="Deben ser 12 n&uacute;meros."
                       value="<?php echo $codigo_barras; ?>" />
                <button type="submit" class="btn btn-primary mb-3" name="agregar">Agregar</button>

                <br/>

            </form>

            <h1>Venta nueva</h1>

            <table class="table table-bordered border-primary">
                <tr>
                    <th scope="col">Producto</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Total</th>
                    <th scope="col">Aumentar</th>
                    <th scope="col">Disminuir</th>
                </tr>



                <?php
                $sql = "SELECT venta_detalle.venta, venta_detalle.producto, venta_detalle.cantidad, productos.descripcion, venta_detalle.
                    precio_venta, venta_detalle.total
                    FROM venta_detalle
                    JOIN productos ON venta_detalle.producto = productos.id_producto
                    WHERE venta_detalle.venta='$id_venta'";

                $resultado = $db->query($sql);
                $total = 0;
                while ($registro = $resultado->fetch_array()) {

                    echo '<tr>';
                    echo '<td>' . $registro['cantidad'] . " " . $registro['descripcion'] . '</td>';
                    echo '<td>' . "$" . $registro['precio_venta'] . '</td>';
                    echo '<td>' . "$" . $registro['total'] . '</td>';
                    echo '<td><a href="agregar_producto.php?venta=' . $registro["venta"] . '&producto=' . $registro["producto"] . '"><img src="imagenes/plus-circle.svg" width="20" height="20"></a></td>';
                    echo '<td><a href="disminuir_producto.php?venta=' . $registro["venta"] . '&producto=' . $registro["producto"] . '"><img src="imagenes/dash-circle.svg" width="20" height="20"></a></td>';
                    echo '</tr>';
                    $total = $total + $registro['total'];
                }

                echo '<tfoot>';
                echo '<tr>';
                echo '<td colspan="5">' . "Total a pagar: $$total" . '</td>';
                echo '</tr>';
                echo '</tfoot>';
                ?>

            </table>

            <button type="button" class="btn btn-success"  onclick="location.href = 'index.php'" name="cancelar">Finalizar venta</button>


        </div>

        <div class="pie">

            <?php require_once 'pie.html'; ?>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>

    </body>

</html>