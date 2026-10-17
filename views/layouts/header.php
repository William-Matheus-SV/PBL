<?php
$bsTheme = (($_COOKIE['tema'] ?? 'light') === 'dark') ? 'dark' : 'light';
?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="<?= $bsTheme ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PBL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-body-tertiary">

<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand">PBL</span>
        <div class="d-flex align-items-center gap-2">

            <div class="form-check form-switch text-white mb-0 me-2">
                <input class="form-check-input" type="checkbox" role="switch" id="themeSwitch"
                       <?= $bsTheme === 'dark' ? 'checked' : '' ?>>
                <label class="form-check-label small" for="themeSwitch" id="themeLabel">
                    <?= $bsTheme === 'dark' ? 'Escuro' : 'Claro' ?>
                </label>
            </div>

            <a href="/PBL/controllers/authcontrollers/LogoutController.php" class="btn btn-sm btn-danger">Sair</a>
        </div>
    </div>
</nav>

<div class="d-flex">

<?php require "../views/layouts/sidebar.php"; ?>

<main class="flex-grow-1 p-4">

<?php if (!empty($_SESSION['erro'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['erro']) ?></div>
    <?php unset($_SESSION['erro']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['sucesso'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['sucesso']) ?></div>
    <?php unset($_SESSION['sucesso']); ?>
<?php endif; ?>