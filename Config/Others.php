<?php
    require_once "../Connection/Conexion.php";

    function tablas(){
        $conexion = new Conexion();
        $query = "SHOW TABLES";
        $stmt = $conexion->Conectar()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    foreach (tablas() as $tabla) {
        $archivo = fopen("../App/Controllers/" . ucfirst($tabla["Tables_in_tienda"]).".php", "w");
        $archivo2 = fopen("../App/Models/" . ucfirst($tabla["Tables_in_tienda"]).".php", "w");
        fwrite($archivo, "<?php\n\t");
        fwrite($archivo2, "<?php\n\t");
        fclose($archivo);
        fclose($archivo2);
    }