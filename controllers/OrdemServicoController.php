<?php

require "../middleware/auth.php";
require "../config/database.php";
require "../config/listas.php";
require "../models/OrdemServico.php";
require "../models/Equipamento.php";
require "../models/Tecnico.php";

$osModel          = new OrdemServico($pdo);
$equipamentoModel = new Equipamento($pdo);
$tecnicoModel     = new Tecnico($pdo);

$acao = $_GET['acao'] ?? 'listar';

switch ($acao) {

// Mostra a lista de ordens de serviço
case 'listar':
    $ordens = $osModel->listar();
    require "../views/ordens_servico/listar.php";
    break;


// Abre o formulário de nova OS (aceita ?id_equipamento=3 para já vir escolhido)
case 'form_criar':
    $os = ['id_equipamento' => (int) ($_GET['id_equipamento'] ?? 0)];
    $equipamentos = $equipamentoModel->listar();
    $tecnicos = $tecnicoModel->listar();
    require "../views/ordens_servico/criar.php";
    break;


// Recebe o formulário de nova OS e grava
case 'criar':
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: OrdemServicoController.php?acao=listar");
        exit();
    }

    $dados = [];
    foreach ($_POST as $campo => $valor) {
        $dados[$campo] = trim($valor);
    }

    $id_equipamento = (int) ($dados['id_equipamento'] ?? 0);
    $id_tecnico     = (int) ($dados['id_tecnico'] ?? 0);
    $voltar         = "OrdemServicoController.php?acao=form_criar&id_equipamento=" . $id_equipamento;

    if ($id_equipamento === 0 || $id_tecnico === 0 || empty($dados['problema_relatado'])) {
        $_SESSION['erro'] = "Escolha o equipamento e o técnico e descreva o problema relatado.";
        header("Location: " . $voltar);
        exit();
    }

    $equipamento = $equipamentoModel->buscarPorId($id_equipamento);
    if (!$equipamento) {
        $_SESSION['erro'] = "Equipamento não encontrado.";
        header("Location: " . $voltar);
        exit();
    }

    $tecnico = $tecnicoModel->buscarPorId($id_tecnico);
    if (!$tecnico) {
        $_SESSION['erro'] = "Técnico não encontrado.";
        header("Location: " . $voltar);
        exit();
    }

    if ($tecnico['status'] !== 'Ativo') {
        $_SESSION['erro'] = "Esse técnico está inativo. Escolha outro.";
        header("Location: " . $voltar);
        exit();
    }

    if (!in_array($dados['prioridade'] ?? '', $prioridadeLista)) {
        $_SESSION['erro'] = "Prioridade inválida.";
        header("Location: " . $voltar);
        exit();
    }

    if (!empty($dados['valor_estimado']) && (!is_numeric($dados['valor_estimado']) || $dados['valor_estimado'] < 0)) {
        $_SESSION['erro'] = "Valor estimado inválido.";
        header("Location: " . $voltar);
        exit();
    }

    // O cliente da OS é sempre o dono do equipamento
    $dados['id_cliente'] = $equipamento['id_cliente'];

    $numero = $osModel->criar($dados);
    $_SESSION['sucesso'] = "Ordem de serviço " . $numero . " aberta com sucesso.";
    header("Location: OrdemServicoController.php?acao=listar");
    exit();


// Abre o formulário de edição já preenchido
case 'form_editar':
    $id = (int) ($_GET['id'] ?? 0);
    $os = $osModel->buscarPorId($id);

    if (!$os) {
        $_SESSION['erro'] = "Ordem de serviço não encontrada.";
        header("Location: OrdemServicoController.php?acao=listar");
        exit();
    }

    $tecnicos = $tecnicoModel->listar();
    require "../views/ordens_servico/editar.php";
    break;


// Recebe o formulário de edição e atualiza
case 'editar':
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: OrdemServicoController.php?acao=listar");
        exit();
    }

    $id      = (int) ($_POST['id_os'] ?? 0);
    $osAtual = $osModel->buscarPorId($id);

    if (!$osAtual) {
        $_SESSION['erro'] = "Ordem de serviço não encontrada.";
        header("Location: OrdemServicoController.php?acao=listar");
        exit();
    }

    $dados = [];
    foreach ($_POST as $campo => $valor) {
        $dados[$campo] = trim($valor);
    }

    $id_tecnico = (int) ($dados['id_tecnico'] ?? 0);
    $voltar     = "OrdemServicoController.php?acao=form_editar&id=" . $id;

    if ($id_tecnico === 0 || empty($dados['problema_relatado'])) {
        $_SESSION['erro'] = "Escolha o técnico e descreva o problema relatado.";
        header("Location: " . $voltar);
        exit();
    }

    if (!in_array($dados['status'] ?? '', $statusLista) || !in_array($dados['prioridade'] ?? '', $prioridadeLista)) {
        $_SESSION['erro'] = "Status ou prioridade inválidos.";
        header("Location: " . $voltar);
        exit();
    }

    $tecnico = $tecnicoModel->buscarPorId($id_tecnico);
    if (!$tecnico) {
        $_SESSION['erro'] = "Técnico não encontrado.";
        header("Location: " . $voltar);
        exit();
    }

    // Técnico inativo só é aceito se já era o da OS
    if ($tecnico['status'] !== 'Ativo' && $id_tecnico != $osAtual['id_tecnico']) {
        $_SESSION['erro'] = "Esse técnico está inativo. Escolha outro.";
        header("Location: " . $voltar);
        exit();
    }

    foreach (['valor_estimado', 'valor_final'] as $campo) {
        if (!empty($dados[$campo]) && (!is_numeric($dados[$campo]) || $dados[$campo] < 0)) {
            $_SESSION['erro'] = "Valor inválido no campo " . str_replace('_', ' ', $campo) . ".";
            header("Location: " . $voltar);
            exit();
        }
    }

    // Concluída sem data de conclusão: usa a data de hoje
    if ($dados['status'] === 'Concluída' && empty($dados['data_conclusao'])) {
        $dados['data_conclusao'] = date('Y-m-d');
    }

    $osModel->atualizar($id, $dados);
    $_SESSION['sucesso'] = "Ordem de serviço atualizada com sucesso.";
    header("Location: OrdemServicoController.php?acao=listar");
    exit();


// Mostra os dados de uma OS, só para leitura
case 'visualizar':
    $id = (int) ($_GET['id'] ?? 0);
    $os = $osModel->buscarPorId($id);

    if (!$os) {
        $_SESSION['erro'] = "Ordem de serviço não encontrada.";
        header("Location: OrdemServicoController.php?acao=listar");
        exit();
    }

    require "../views/ordens_servico/visualizar.php";
    break;


// Exclui a OS
case 'excluir':
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: OrdemServicoController.php?acao=listar");
        exit();
    }

    $id = (int) ($_POST['id_os'] ?? 0);

    try {
        $osModel->excluir($id);
        $_SESSION['sucesso'] = "Ordem de serviço excluída com sucesso.";
    } catch (PDOException $e) {
        $_SESSION['erro'] = "Não foi possível excluir a ordem de serviço.";
    }

    header("Location: OrdemServicoController.php?acao=listar");
    exit();


// Qualquer ação desconhecida volta para a lista
default:
    header("Location: OrdemServicoController.php?acao=listar");
    exit();
}