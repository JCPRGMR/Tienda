<?php
    require_once "../Connection/Conexion.php";
    class Usuarios extends Conexion{
        public function VerificarUsuarios($data){
            try {
                $query = "SELECT ";
            } catch (PDOException $th) {
                die ("Error: " . $th);
            }
        }
    }