<?php

require "../middleware/auth.php";
require "../config/database.php";
require "../config/listas.php";
require "../models/Dashboard.php";

date_default_timezone_set("America/Sao_Paulo");

$dashboardModel = new Dashboard($pdo);

$resumo    = $dashboardModel->resumo();
$porStatus = $dashboardModel->osPorStatus();
$ultimasOS = $dashboardModel->ultimasOS();

// Perfil de quem está logado (gravado na sessão no login)
$perfil  = $_SESSION["usuario_perfil"] ?? "";
$ehAdmin = ($perfil === "administrador");

// Filtro de ordens: só o administrador usa, e só ele tem os dados buscados
$ordensFiltradas  = [];
$filtroStatus     = '';
$filtroPrioridade = '';

if ($ehAdmin) {
    $filtroStatus     = $_GET['status'] ?? '';
    $filtroPrioridade = $_GET['prioridade'] ?? '';

    // Valor que não está na lista vira "sem filtro"
    if (!in_array($filtroStatus, $statusLista)) {
        $filtroStatus = '';
    }
    if (!in_array($filtroPrioridade, $prioridadeLista)) {
        $filtroPrioridade = '';
    }

    $ordensFiltradas = $dashboardModel->filtrarOS($filtroStatus, $filtroPrioridade);
}

$hora = (int) date("H");

if ($hora < 12) {
    $saudacao = "Bom dia";
} elseif ($hora < 18) {
    $saudacao = "Boa tarde";
} else {
    $saudacao = "Boa noite";
}

require "../views/dashboard/index.php";