<?php
require_once 'conexion.php';

$codigo_barras = $_GET["codigo_barras"];

$sql = "SELECT * FROM productos WHERE codigo_barras = '$codigo_barras'";
$resultado = $db->query($sql);

while ($registro = $resultado->fetch_array()) {

    $descripcion = $registro["descripcion"];
    $cantidad = $registro["cantidad"];
    $precio_venta = $registro["precio_venta"];
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

            <h1>Modificar producto</h1>

            <form action="modificar_bd.php" >

                <label>Codigo de Barras</label>
                <input type="text" name="codigo_barras" autofocus="autofocus" 
                       required="required" pattern="[0-9]{12}" minlength="12" maxlength="12" 
                       placeholder="Introduce la el codigo de barras" title="Deben ser 12 n&uacute;meros."
                       readonly="" value="<?php echo $codigo_barras; ?>" />

                <br/>

                <label>Descripcion</label>
                <input type="text" name="descripcion" required="required" 
                       pattern="[a-zA-Z0-9.ñ ]*" minlength="1" maxlength="30"
                       placeholder="Introduce el nombre" title="Deben ser solo caracteres de la A a la Z."
                       value="<?php echo $descripcion; ?>" />

                <br/>

                <label>Cantidad</label>
                <input type="number" name="cantidad" min="1" max="300"
                       placeholder="Introduce la cantidad de productos" 
                       title="Deben ser entre 1 y 300." required="required"
                       value="<?php echo $cantidad; ?>" />

                <br/>

                <label>Precio de venta</label>
                <input type="number" name="precio_venta" step=0.01 min="1" max="300"
                       placeholder="Introduce el precio de venta" 
                       title="Deben ser entre 1 y 300." required="required"
                       value="<?php echo $precio_venta; ?>" />

                <br/><br/>

                <button type="button" class="btn btn-danger"  onclick="location.href = 'index_productos.php'" name="cancelar">Cancelar</button>
                <button type="submit" class="btn btn-success"   <button type="button" class="btn btn-success">Guardar datos</button>


            </form>
        </div>

        <div class="pie">

            <?php require_once 'pie.html'; ?>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>

    </body>

</html>