<?php
    // require_once "../Connection/Conexion.php";

    class Empleados extends Conexion{
        public function Crear($data){
            try {
                $query = "INSERT INTO empleados(
                    identificacion,
                    nom_empleado,
                    ape_empleado,
                    celular,
                    foto_empleado
                ) VALUES(?,?,?,?,?)";
                $stmt = $this->Conectar()->prepare($query);
                $stmt->bindParam(1, $data["identificacion"], PDO::PARAM_STR);
                $stmt->bindParam(2, $data["nom_empleado"], PDO::PARAM_STR);
                $stmt->bindParam(3, $data["ape_empleado"], PDO::PARAM_STR);
                $stmt->bindParam(4, $data["celular"], PDO::PARAM_STR);
                $stmt->bindParam(5, $data["foto_empleado"], PDO::PARAM_STR);
                $stmt->execute();
                return "Empleado creado correctamente";
            } catch (PDOException $th) {
                die ("Error: " . $th);
            }
        }
        public function Ultimo_empleado(){
            try {
                $query = "SELECT id_empleado FROM empleados ORDER BY empleado_create DESC";
                $stmt = $this->Conectar()->prepare($query);
                $stmt->execute();
                $resultado = $stmt->fetchColumn();
                return $resultado;
            } catch (PDOException $th) {
                die ("Error: " . $th);
            }
        }
        public function Identificacion_repetida($data){
            try {
                $query = "SELECT identificacion FROM empleados WHERE identificacion = ?";
                $stmt = $this->Conectar()->prepare($query);
                $stmt->bindParam(1, $data["identificacion"], PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchColumn();
            } catch (PDOException $th) {
                die ("Error: " . $th);
            }
        }
    }