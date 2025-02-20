<?php
    require_once "../Connection/Conexion.php";

    class Empleados extends Conexion{
        public function Crear($data){
            try {
                $query = "INSERT INTO empleados(
                    nom_empleado,
                    ape_empleado,
                    celular,
                    foto_empleado
                ) VALUES(?,?,?,?)";
                $stmt = $this->Conectar()->prepare($query);
                $stmt->bindParam(1, $data["nom_empleado"], PDO::PARAM_STR);
                $stmt->bindParam(2, $data["ape_empleado"], PDO::PARAM_STR);
                $stmt->bindParam(3, $data["celular"], PDO::PARAM_STR);
                $stmt->bindParam(4, $data["foto_empleado"], PDO::PARAM_STR);
                $stmt->execute();
                return "Empleado creado correctamente";
            } catch (PDOException $th) {
                die ("Error: " . $th);
            }
        }
    }