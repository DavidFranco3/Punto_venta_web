<?php
if (isset($_GET["fecha_inicial"])) {

    $fecha_inicial = $_GET["fecha_inicial"];
    $fecha_final = $_GET["fecha_final"];
} else {

    $fecha_inicial = Date("Y-m-d");
    $fecha_final = Date("Y-m-d");
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

                <label>Rango de fechas</label>
                <input type="date" name="fecha_inicial" autofocus="autofocus" 
                       placeholder="Introduce una fecha" 
                       value="<?php echo $fecha_inicial; ?>" />
                <label>-</label>
                <input type="date" name="fecha_final" 
                       placeholder="Introduce una fecha" 
                       value="<?php echo $fecha_final; ?>" />

                <button type="submit" class="btn btn-primary mb-3" name="buscar">Buscar</button>

                <br/>

            </form>

            <h1>Reporte de venta</h1>

            <table class="table table-bordered border-primary">

                <tr>
                    <th scope="col">Venta</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Total</th>
                    <th scope="col">Modificar</th>
                </tr>



                <?php
                require_once 'conexion.php';

                $sql = "SELECT * FROM venta
                    WHERE fecha_venta >= '$fecha_inicial 00:00:00' AND fecha_venta <= '$fecha_final 23:59:59' ORDER BY venta.fecha_venta DESC";
                $resultado = $db->query($sql);
                $total = 0;

                while ($registro = $resultado->fetch_array()) {
                    echo '<tr>';
                    echo '<td>' . $registro['id_venta'] . '</td>';
                    echo '<td>' . $registro['fecha_venta'] . '</td>';
                    echo '<td>' . "$" . $registro['total'] . '</td>';
                    echo '<td><a href="agregar_venta.php?id_venta=' . $registro["id_venta"] . '"><img src="imagenes/file-earmark-text.svg" width="20" height="20"></a></td>';
                    echo '</tr>';
                    $total = $total + $registro['total'];
                }

                echo '<tfoot>';
                echo '<tr>';
                echo '<td colspan="5">' . "Total: $$total" . '</td>';
                echo '</tr>';
                echo '</tfoot>';
                ?>

            </table>

            <form action="agregar_reporte_venta_bd.php">

                <button type="submit" class="btn btn-primary mb-3">Agregar venta</button>


            </form>



        </div>

        <div class="pie">

            <?php require_once 'pie.html'; ?>

        </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    </body>

</html>