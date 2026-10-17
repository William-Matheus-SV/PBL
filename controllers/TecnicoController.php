<?php

require "../middleware/auth.php";
require "../config/database.php";
require "../models/Tecnico.php";

$tecnicoModel = new Tecnico($pdo);
$acao = $_GET['acao'] ?? 'listar';

switch($acao) {

//Mostra a lista de tecnicos
case 'listar':
    $tecnicos = $tecnicoModel -> listar();
    require "../views/tecnicos/listar.php";
    break;


//Abre o formulário de cadastro
case 'form_criar':
    require "../views/tecnicos/criar.php";
    break;


//Recebe o formulário de cadastro e grava
case 'criar':
    if($_SERVER['REQUEST_METHOD']!== 'POST'){
        header("Location: TecnicoController.php?acao=listar");
        exit();
    }

    $dados = [];
    foreach ($_POST as $campo => $valor){
        $dados[$campo]= trim($valor);
    }

    if (empty($dados['nome'])|| empty($dados['cpf']) ||  empty($dados['email'])) {
            $_SESSION['erro'] = "Preencha nome, CPF e e-mail.";
            header("Location: TecnicoController.php?acao=form_criar");
            exit();
    }
    
    if ($tecnicoModel->buscarPorCpf($dados['cpf'])) {
            $_SESSION['erro'] = "Já existe um tecnico com esse CPF.";
            header("Location: TecnicoController.php?acao=form_criar");
            exit();
    }

    $tecnicoModel->criar($dados);
    $_SESSION['sucesso'] = "Tecnico cadastrado com sucesso.";
    header("Location: TecnicoController.php?acao=listar");
    exit();

// Abre o formulário de edição já preenchido
case 'form_editar':
    $id = (int) ($_GET['id'] ?? 0);
    $tecnico = $tecnicoModel->buscarPorId($id);

    if (!$tecnico) {
        $_SESSION['erro'] = "Tecnico não encontrado.";
        header("Location: TecnicoController.php?acao=listar");
        exit();
    }

    require "../views/tecnicos/editar.php";
    break;

// Recebe o formulário de edição e atualiza
case 'editar':
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: TecnicoController.php?acao=listar");
        exit();
    }

    $id = (int) ($_POST['id_tecnico'] ?? 0);

    $dados = [];
    foreach ($_POST as $campo => $valor) {
        $dados[$campo] = trim($valor);
    }

    if (empty($dados['nome']) || empty($dados['cpf']) || empty($dados['email'])) {
        $_SESSION['erro'] = "Preencha CPF, nome e e-mail.";
         header("Location: TecnicoController.php?acao=form_editar&id=" . $id);
        exit();
    }


 // O CPF pode já existir, mas só se for do próprio tecnico
        $existente = $tecnicoModel->buscarPorCpf($dados['cpf']);
        if ($existente && $existente['id_tecnico'] != $id) {
            $_SESSION['erro'] = "Esse CPF já pertence a outro tecnico.";
            header("Location: TecnicoController.php?acao=form_editar&id=" . $id);
            exit();
        }

        $tecnicoModel->atualizar($id, $dados);
        $_SESSION['sucesso'] = "Tecnico atualizado com sucesso.";
        header("Location: TecnicoController.php?acao=listar");
        exit();

// Mostra os dados de um tecnico, só para leitura
case 'visualizar':
    $id = (int) ($_GET['id'] ?? 0);
    $tecnico = $tecnicoModel->buscarPorId($id);

    if (!$tecnico) {
        $_SESSION['erro'] = "Tecnico não encontrado.";
        header("Location: TecnicoController.php?acao=listar");
        exit();
    }

    require "../views/tecnicos/visualizar.php";
    break;

// Exclui o tecnico
case 'excluir':
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: TecnicoController.php?acao=listar");
        exit();
    }

    $id = (int) ($_POST['id_tecnico'] ?? 0);
    
    try {
        $tecnicoModel->excluir($id);
        $_SESSION['sucesso'] = "Tecnico excluído com sucesso.";
    } catch (PDOException $e) {
        $_SESSION['erro'] = "Não foi possível excluir: o tecnico está ligado a ordens de serviço.";
    }

    header("Location: TecnicoController.php?acao=listar");
    exit();

// Qualquer ação desconhecida volta para a lista
default:
    header("Location: TecnicoController.php?acao=listar");
    exit();

}