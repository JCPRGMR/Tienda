<?php
    class Conexion{
        // private string $localhost = "localhost";
        private string $localhost = "172.30.158.100";
        private string $database = "tienda";
        // private string $username = "root";
        // private string $password = "";
        private string $username = "Mastevale2";
        private string $password = "Ikaros1@";

        public function Conectar (){
            try {
                $pdo = "mysql:host={$this->localhost};dbname={$this->database}";
                $stmt = new PDO($pdo, $this->username, $this->password);
                $stmt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $stmt;
                // return "Conexion Correcta";
            } catch (PDOException $th) {
                die ("Erro de conexion: " . $th) ;
            }
        }
    }

    // $conexion = new Conexion();
    // echo $conexion->Conectar();