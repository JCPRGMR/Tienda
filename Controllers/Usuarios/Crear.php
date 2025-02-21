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

    if($validar){
        echo json_encode([
            "message" => "Ese usuario ya existe!"
        ]);
        exit();
    }

    $empleado_repetido = $empleados->Identificacion_repetida($post);    // $empleado_repetido = (1 - N) : false

    if(!$empleado_repetido){
        // Creacion de empleado
        $empleados->Crear($post);
        $id_empleado = $empleados->Ultimo_empleado();
        $post["id_fk_empleado"] = $id_empleado;
    }

    if($empleado_repetido && $usuarios->Usuario_asignado([$post["identificacion"] => $empleado_repetido])){
        echo json_encode([
            "message" => "Ese empleado ya posee un usuario"
        ]);
        exit();
    }

    $post["id_fk_empleado"] = $empleado_repetido;


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