<?php 

require "../middleware/auth.php";
require "../config/database.php";
require "../models/Cliente.php";

$clienteModel = new Cliente($pdo);
$acao = $_GET['acao'] ?? 'listar';

switch ($acao) {

//Mostra a lista de clientes
case 'listar':
    $busca = trim($_GET['busca'] ?? '');
    $clientes = $busca !== '' ? $clienteModel->buscar($busca) : $clienteModel->listar();
    require "../views/clientes/listar.php";
    break;


//Abre o formulário de cadastro
case 'form_criar':
    require "../views/clientes/criar.php";
    break;


//Recebe o formulário de cadastro e grava
case 'criar':
    if($_SERVER['REQUEST_METHOD']!== 'POST'){
        header("Location: ClienteController.php?acao=listar");
        exit();
    }

    $dados = [];
    foreach ($_POST as $campo => $valor){
        $dados[$campo]= trim($valor);
    }

    if (empty($dados['cpf_cnpj'])|| empty($dados['nome']) ||  empty($dados['email'])) {
            $_SESSION['erro'] = "Preencha CPF/CNPJ, nome e e-mail.";
            header("Location: ClienteController.php?acao=form_criar");
            exit();
    }
    
    if ($clienteModel->buscarPorCpfCnpj($dados['cpf_cnpj'])) {
            $_SESSION['erro'] = "Já existe um cliente com esse CPF/CNPJ.";
            header("Location: ClienteController.php?acao=form_criar");
            exit();
    }

    $clienteModel->criar($dados);
    $_SESSION['sucesso'] = "Cliente cadastrado com sucesso.";
    header("Location: ClienteController.php?acao=listar");
    exit();


    // Abre o formulário de edição já preenchido
case 'form_editar':
    $id = (int) ($_GET['id'] ?? 0);
    $cliente = $clienteModel->buscarPorId($id);

    if (!$cliente) {
        $_SESSION['erro'] = "Cliente não encontrado.";
        header("Location: ClienteController.php?acao=listar");
        exit();
    }

    require "../views/clientes/editar.php";
    break;

// Recebe o formulário de edição e atualiza
case 'editar':
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ClienteController.php?acao=listar");
        exit();
    }

    $id = (int) ($_POST['id_cliente'] ?? 0);

    $dados = [];
    foreach ($_POST as $campo => $valor) {
        $dados[$campo] = trim($valor);
    }

    if (empty($dados['cpf_cnpj']) || empty($dados['nome']) || empty($dados['email'])) {
        $_SESSION['erro'] = "Preencha CPF/CNPJ, nome e e-mail.";
         header("Location: ClienteController.php?acao=form_editar&id=" . $id);
        exit();
    }


 // O CPF/CNPJ pode já existir, mas só se for do próprio cliente
        $existente = $clienteModel->buscarPorCpfCnpj($dados['cpf_cnpj']);
        if ($existente && $existente['id_cliente'] != $id) {
            $_SESSION['erro'] = "Esse CPF/CNPJ já pertence a outro cliente.";
            header("Location: ClienteController.php?acao=form_editar&id=" . $id);
            exit();
        }

        $clienteModel->atualizar($id, $dados);
        $_SESSION['sucesso'] = "Cliente atualizado com sucesso.";
        header("Location: ClienteController.php?acao=listar");
        exit();

// Mostra os dados de um cliente, só para leitura
case 'visualizar':
    $id = (int) ($_GET['id'] ?? 0);
    $cliente = $clienteModel->buscarPorId($id);

    if (!$cliente) {
        $_SESSION['erro'] = "Cliente não encontrado.";
        header("Location: ClienteController.php?acao=listar");
        exit();
    }

    require "../views/clientes/visualizar.php";
    break;

// Exclui o cliente
case 'excluir':
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ClienteController.php?acao=listar");
        exit();
    }

    $id = (int) ($_POST['id_cliente'] ?? 0);
    
    try {
        $clienteModel->excluir($id);
        $_SESSION['sucesso'] = "Cliente excluído com sucesso.";
    } catch (PDOException $e) {
        $_SESSION['erro'] = "Não foi possível excluir: o cliente tem equipamentos ou ordens de serviço.";
    }

    header("Location: ClienteController.php?acao=listar");
    exit();

// Qualquer ação desconhecida volta para a lista
default:
    header("Location: ClienteController.php?acao=listar");
    exit();
}