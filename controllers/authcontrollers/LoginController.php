<?php
    session_start();
    require "../../config/database.php";
    require "../../models/Usuario.php";


    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../views/auth/login.php");
    exit();
    }

    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if(empty($email) || empty($senha)){
        $_SESSION["erro"] = "Preencha o email e a senha";
        header("Location: ../../views/auth/login.php");
        exit();
    }

   $usuarioModel = new Usuario($pdo);
   $usuario = $usuarioModel->buscarPorEmail($email);

    if ($usuario && password_verify($senha, $usuario['senha'])){
        session_regenerate_id(true);
        $_SESSION["usuario_id"] = $usuario['id_usuario'];
        $_SESSION["usuario_nome"] = $usuario['nome'];
        $_SESSION["usuario_email"] = $usuario['email'];
        $_SESSION["usuario_perfil"] = $usuario['perfil'];

        header("Location: ../../index.php");
        exit();

    }else {
        $_SESSION["erro"] = "Email ou senha inválidos.";

        header("Location: ../../views/auth/login.php");
        exit();
    }
?>