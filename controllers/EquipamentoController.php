<?php

require "../middleware/auth.php";
require "../config/database.php";
require "../models/Equipamento.php";
require "../models/Cliente.php";

$equipamentoModel = new Equipamento($pdo);
$clienteModel = new Cliente($pdo);
$acao = $_GET['acao'] ?? 'listar';

switch ($acao) {
    // Mostra a lista de equipamentos
    case 'listar':
        $equipamentos = $equipamentoModel->listar();
        require "../views/equipamentos/listar.php";
        break;

    // Abre o formulário de cadastro
    case 'form_criar':
        $clientes = $clienteModel->listar();
        // Vem preenchido quando o usuário chega pelo atalho da tela do cliente
        $id_cliente_selecionado = (int) ($_GET['id_cliente'] ?? 0);
        require "../views/equipamentos/criar.php";
        break;

    // Recebe o formulário de cadastro e grava
    case 'criar':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: EquipamentoController.php?acao=listar");
            exit();
        }

        $dados = [];
        foreach ($_POST as $campo => $valor) {
            $dados[$campo] = trim($valor);
        }

        if (empty($dados['id_cliente']) || empty($dados['tipo'])) {
            $_SESSION['erro'] = "Selecione o cliente e informe o tipo do equipamento.";
            header("Location: EquipamentoController.php?acao=form_criar&id_cliente=" . (int) ($dados['id_cliente'] ?? 0));
            exit();
        }

        // O id_cliente vem do formulário e pode ser adulterado: confere se o cliente existe
        if (!$clienteModel->buscarPorId((int) $dados['id_cliente'])) {
            $_SESSION['erro'] = "Cliente não encontrado.";
            header("Location: EquipamentoController.php?acao=form_criar");
            exit();
        }

        $equipamentoModel->criar($dados);
        $_SESSION['sucesso'] = "Equipamento cadastrado com sucesso.";
        header("Location: EquipamentoController.php?acao=listar");
        exit();

    // Abre o formulário de edição
    case 'form_editar':
        $id = (int) ($_GET['id'] ?? 0);
        $equipamento = $equipamentoModel->buscarPorId($id);

        if (!$equipamento) {
            $_SESSION['erro'] = "Equipamento não encontrado.";
            header("Location: EquipamentoController.php?acao=listar");
            exit();
        }

        require "../views/equipamentos/editar.php";
        break;

    // Recebe o formulário de edição e atualiza
    case 'editar':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: EquipamentoController.php?acao=listar");
            exit();
        }

        $id = (int) ($_POST['id_equipamento'] ?? 0);

        $dados = [];
        foreach ($_POST as $campo => $valor) {
            $dados[$campo] = trim($valor);
        }

        if (!$equipamentoModel->buscarPorId($id)) {
            $_SESSION['erro'] = "Equipamento não encontrado.";
            header("Location: EquipamentoController.php?acao=listar");
            exit();
        }

        // O dono não muda na edição, então só o tipo é obrigatório
        if (empty($dados['tipo'])) {
            $_SESSION['erro'] = "Informe o tipo do equipamento.";
            header("Location: EquipamentoController.php?acao=form_editar&id=" . $id);
            exit();
        }

        $equipamentoModel->atualizar($id, $dados);
        $_SESSION['sucesso'] = "Equipamento atualizado com sucesso.";
        header("Location: EquipamentoController.php?acao=listar");
        exit();

    // Mostra os dados de um equipamento, só para leitura
    case 'visualizar':
        $id = (int) ($_GET['id'] ?? 0);
        $equipamento = $equipamentoModel->buscarPorId($id);

        if (!$equipamento) {
            $_SESSION['erro'] = "Equipamento não encontrado.";
            header("Location: EquipamentoController.php?acao=listar");
            exit();
        }

        require "../views/equipamentos/visualizar.php";
        break;

    // Exclui o equipamento
    case 'excluir':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: EquipamentoController.php?acao=listar");
            exit();
        }

        $id = (int) ($_POST['id_equipamento'] ?? 0);

        try {
            $equipamentoModel->excluir($id);
            $_SESSION['sucesso'] = "Equipamento excluído com sucesso.";
        } catch (PDOException $e) {
            $_SESSION['erro'] = "Não foi possível excluir: este equipamento possui ordens de serviço.";
        }

        header("Location: EquipamentoController.php?acao=listar");
        exit();

    // Qualquer ação desconhecida volta para a lista
    default:
        header("Location: EquipamentoController.php?acao=listar");
        exit();
}