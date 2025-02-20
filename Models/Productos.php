<?php
    require_once "../Connection/Conexion.php";
    class Productos extends Conexion{
        public function Crear($data){
            try {
                $query = "INSERT INTO productos(
                    nom_producto,
                    descripcion,
                    precio_venta,
                    cantidad
                ) VALUES(?,?,?,?)";
                $stmt = $this->Conectar()->prepare($query);
                $stmt->bindParam(1, $data["nom_producto"], PDO::PARAM_STR);
                $stmt->bindParam(2, $data["descripcion"], PDO::PARAM_STR);
                $stmt->bindParam(3, $data["precio_venta"], PDO::PARAM_STR);
                $stmt->bindParam(4, $data["cantidad"], PDO::PARAM_STR);
                $stmt->execute();
                // return true;
                echo "producto agregado correctamente";
            } catch (PDOException $th) {
                echo $th;
                // return false;
            }
        }
        public function Leer(){}
        public function Actualizar(){}
    }