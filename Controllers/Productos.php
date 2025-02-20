<?php
    include_once "../Models/Productos.php";
    $productos = new Productos();

    echo $productos->Crear($_POST);

    header("Location: ../Public/Views/Productos/Crear.php");