<?php
echo "Controller abriu!<br>";

require "../../config/database.php";
echo "Database carregou!<br>";

require "../../models/Usuario.php";

echo "Model carregou!<br>";


$nome = "João Silva";
$email = "joao@gmail.com";
$senha = "123456";
$telefone = "81999999999";
$perfil = "funcionario";
$status = "ativo";

$usuarioModel = new Usuario($pdo);

$usuarioModel->criar(
    $nome,
    $email,
    $senha,
    $telefone,
    $perfil,
    $status
);

echo "Usuário cadastrado com sucesso!";