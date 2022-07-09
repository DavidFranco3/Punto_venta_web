<?php
if (isset($_GET["texto_buscar"])) {

    $texto_buscar = $_GET["texto_buscar"];
} else {

    $texto_buscar = "";
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

                <label>Buscar</label>
                <input type="text" name="texto_buscar" autofocus="autofocus" 
                       placeholder="Introduce codigo de barras o descripcion" 
                       value="<?php echo $texto_buscar; ?>" />
                <button type="submit" class="btn btn-primary mb-3" name="buscar">Buscar</button>

                <br/>

            </form>

            <h1>Lista de productos</h1>

            <table class="table table-bordered border-primary">
                <tr>
                    <th scope="col">Codigo de barras</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio de venta</th>
                    <th scope="col">Modificar</th>
                    <th scope="col">Eliminar</th>
                    
                </tr>

                <?php
                require_once 'conexion.php';

                $sql = "SELECT * FROM productos 
                    WHERE codigo_barras like '%$texto_buscar%' 
                        OR descripcion like '%$texto_buscar%'";
                $resultado = $db->query($sql);

                while ($registro = $resultado->fetch_array()) {

                    echo '<tr>';
                    echo '<td>' . $registro['codigo_barras'] . '</td>';
                    echo '<td>' . $registro['descripcion'] . '</td>';
                    echo '<td>' . $registro['cantidad'] . '</td>';
                    echo '<td>' . $registro['precio_venta'] . '</td>';
                    echo '<td><a href="modificar.php?codigo_barras=' . $registro["codigo_barras"] . '"><img src="imagenes/file-earmark-text.svg" width="20" height="20"></a></td>';
                    echo '<td><a href="eliminar.php?codigo_barras=' . $registro["codigo_barras"] . '"><img src="imagenes/x-circle.svg" width="20" height="20"></a></td>';
                    echo '</tr>';
                }
                ?>

            </table>

            <button type="submit" class="btn btn-primary mb-3" onclick="location.href = 'agregar.php'">Agregar producto</button>

        </div>

        <div class="pie">

            <?php require_once 'pie.html'; ?>

        </div>


        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    </body>

</html>