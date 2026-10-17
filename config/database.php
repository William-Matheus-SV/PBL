<?php 

    $servidor = 'localhost';
    $banco = 'PBL';
    $usuario = 'root';
    $senha = '';

    try{
        $pdo = new PDO(
            "mysql:host=$servidor;dbname=$banco;charset=utf8mb4",
            $usuario,
            $senha,
            [
                PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
            ]
        );
    } catch (PDOException $e){
        die("Erro ao conectar!" .$e->getMessage());
    }