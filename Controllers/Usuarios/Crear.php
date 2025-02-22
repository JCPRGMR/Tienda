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
        exit(json_encode(["Error" => "Metodo de entrada no permitido"]));
    }

    // Read json
    $post = json_decode(file_get_contents("php://input"), true);

    if (!$post) {
        http_response_code(400);
        exit(json_encode(["message" => "Datos JSON inválidos"]));
    }

    // Instaciacion
    $usuarios = new Usuarios();
    $empleados = new Empleados();

    // nom_usuario ??
    if($usuarios->EsRepetido($post)){
        exit(json_encode(["message" => "Ese usuario ya existe!"]));
    }

    // Empleado con usuario
    if ($usuarios->Usuario_asignado($post)) {
        exit(json_encode(["message" => "Ese empleado ya posee un usuario"]));
    }

    // Id_fk_empleado
    $post["id_fk_empleado"] = $empleados->Identificacion_repetida($post);
    if(!$post["id_fk_empleado"]){
        $empleados->Crear($post);
        $post["id_fk_empleado"] = $empleados->Ultimo_empleado();
    }

    try {
        $usuarios->Crear($post);
        echo json_encode([
            "message" => "Usuario creado correctamente"
        ]);
    } catch (PDOException $th) {
        echo json_encode([
            "message" => $th->getMessage()
        ]);
    }