<!DOCTYPE html>
<html lang="es/ES">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../Css/Productos/Crear.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver productos</title>
</head>
<body>
    <form action="../../../Controllers/Productos.php" method="post">
        <div class="caja">
            <label for="">NOMBRE</label>
            <input type="text" name="nom_producto" id="" placeholder="Nombre">
        </div>
        <div class="caja">
            <label for="">DESCRIPCION</label>
            <input type="text" name="descripcion" id="" placeholder="Descripcion">
        </div>
        <div class="caja">
            <label for="">PRECIO DE VENTA</label>
            <input type="text" name="precio_venta" id="" placeholder="Precio de venta">
        </div>
        <div class="caja">
            <label for="">CANTIDAD</label>
            <input type="number" name="cantidad" id="" placeholder="Cantidad">
        </div>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>