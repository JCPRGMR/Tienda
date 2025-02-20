<?php
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");

    require_once "../../Connection/Conexion.php";
    require_once "../../Models/Usuarios.php";
    require_once "../../Models/Empleados.php";

    if($_SERVER["REQUEST_METHOD"] !== "POST"){
        http_response_code(405);
        json_encode([
            "Error" => "Metodo de entrada no permitido"
        ]);
        exit();
    }
    
    // Lectura de json
    $post = json_decode(file_get_contents("php://input"), true);

    if (!$post) {
        http_response_code(400);
        echo json_encode(["message" => "Datos JSON inválidos"]);
        exit();
    }

    $usuarios = new Usuarios();
    $empleados = new Empleados();
    $validar = $usuarios->EsRepetido($post);

    echo json_encode ([
        "message" => $validar ? "Usuario repetido" : "Usuario no repetido"
    ]);