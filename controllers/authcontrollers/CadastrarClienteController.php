<?php
session_start();
require "../../config/database.php";
require "../../models/Cliente.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../views/auth/cadastro.php");
    exit();
}

$dados = [];
foreach ($_POST as $campo => $valor) {
    $dados[$campo] = trim($valor);
}

if (empty($dados['nome']) || empty($dados['cpf_cnpj']) || empty($dados['email'])) {
    $_SESSION["erro"] = "Preencha nome, CPF/CNPJ e e-mail.";
    $_SESSION["old"]  = $dados;
    header("Location: ../../views/auth/cadastro.php");
    exit();
}

if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION["erro"] = "Digite um e-mail válido.";
    $_SESSION["old"]  = $dados;
    header("Location: ../../views/auth/cadastro.php");
    exit();
}

$clienteModel = new Cliente($pdo);

if ($clienteModel->buscarPorCpfCnpj($dados['cpf_cnpj'])) {
    $_SESSION["erro"] = "Já existe um cadastro com esse CPF/CNPJ.";
    $_SESSION["old"]  = $dados;
    header("Location: ../../views/auth/cadastro.php");
    exit();
}

$clienteModel->criar($dados);

$_SESSION["sucesso"] = "Cadastro realizado com sucesso!";
header("Location: ../../views/auth/cadastro.php");
exit();