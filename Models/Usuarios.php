<?php
    // require_once "../Connection/Conexion.php";
    class Usuarios extends Conexion{
        public function Crear($data){
            try {
                $query = "INSERT INTO usuarios(
                    nom_usuario,
                    clave,
                    rol,
                    id_fk_empleado
                ) VALUES(?,?,?,?)";
                $data["clave"] = password_hash($data["clave"], PASSWORD_DEFAULT);
                $stmt = $this->Conectar()->prepare($query);
                $stmt->bindParam(1, $data["nom_usuario"], PDO::PARAM_STR);
                $stmt->bindParam(2, $data["clave"], PDO::PARAM_STR);
                $stmt->bindParam(3, $data["rol"], PDO::PARAM_STR);
                $stmt->bindParam(4, $data["id_fk_empleado"], PDO::PARAM_STR);
                $stmt->execute();
                return "Usuario Creado exitosamente";
            } catch (PDOException $th) {
                die ("Error de escritura: " . $th->getMessage());
            }
        }
        public function Leer(){
            try {
                $query = "SELECT * FROM view_empleados_usuarios";
                $stmt = $this->Conectar()->prepare($query);
                $stmt->execute();
                $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } catch (PDOException $th) {
                die ("Error de lectura: " . $th->getMessage());
            }
        }
        public function Actualizar($data){
            try {
                $query = "UPDATE usuarios 
                SET nom_usuario = ?,
                SET clave = ?,
                SET rol = ?,
                SET estado = ?,
                WHERE id_usuario = ?";
                $stmt = $this->Conectar()->prepare($query);
                $stmt->bindParam(1, $data["nom_usuario"], PDO::PARAM_STR);
                $stmt->bindParam(2, $data["clave"], PDO::PARAM_STR);
                $stmt->bindParam(3, $data["rol"], PDO::PARAM_STR);
                $stmt->bindParam(4, $data["estado"], PDO::PARAM_INT);
                $stmt->bindParam(5, $data["id_usuario"], PDO::PARAM_INT);
                $stmt->execute();
                return "Usuario actualizado correctamente";
            } catch (PDOException $th) {
                die ("Error de actualizacion: " . $th->getMessage());
            }
        }
        public function Eliminar($data){
            try {
                $query = "DELETE FROM usuarios WHERE id_usuario = ?";
                $stmt = $this->Conectar()->prepare($query);
                $stmt->bindParam(1, $data["id_usuario"], PDO::PARAM_INT);
                $stmt->execute();
                return "Usuario elimniado Correctamente";
            } catch (PDOException $th) {
                echo ("Error de eliminacion: " . $th);
            }
        }
        public function EsRepetido($data){
            try {
                $query = "SELECT * FROM usuarios WHERE nom_usuario = ?";
                $stmt = $this->Conectar()->prepare($query);
                $stmt->bindParam(1, $data["nom_usuario"], PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return ($resultado) ? true : false ;
            } catch (PDOException $th) {
                die ("Error de repeticion: " . $th->getMessage());
            }
        }
        public function Desactivar($data){
            try {
                $query = "UPDATE usuarios SET estado = ? WHERE id_usuario = ?";
                $stmt = $this->Conectar()->prepare($query);
                $stmt->bindParam(1, $data["estado"], PDO::PARAM_STR);
                $stmt->bindParam(2, $data["id_usuario"], PDO::PARAM_INT);
                $stmt->execute();
                return "Usuario inhabilitado Correctamente";
            } catch (PDOException $th) {
                echo ("Error de desactivacion: " . $th);
            }
        }
        public function VerificarUsuarios($data){
            try {
                $query = "SELECT * FROM view_empleados_usuarios WHERE nom_usuario = ?";
                $stmt = $this->Conectar()->prepare($query);
                $stmt->bindParam(1, $data["nom_usuario"], PDO::PARAM_STR);
                // $stmt->bindParam(1, $data["clave"], PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                if($resultado && password_verify($data["clave"], $resultado["clave"])){
                    return $resultado;
                }else{
                    die ("Usuario no encontrado");
                }
            } catch (PDOException $th) {
                die ("Error de verificacion: " . $th->getMessage());
            }
        }
        public function Usuario_asignado($data){
            try {
                $query = "SELECT id_fk_empleado FROM view_empleados_usuarios WHERE identificacion = ?";
                $stmt = $this->Conectar()->prepare($query);
                $stmt->bindParam(1, $data["identificacion"], PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetchColumn();
                return $resultado;
            } catch (PDOException $th) {
                die ("Error de verifiacion de asignacion: " . $th);
            }
        }
    }