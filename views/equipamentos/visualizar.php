<?php require "../views/layouts/header.php"; ?>

<h2 class="mb-4">Equipamento: <?= htmlspecialchars($equipamento['tipo']) ?></h2>

<ul class="list-group mb-4">
    <li class="list-group-item"><strong>Cliente:</strong>
        <a href="ClienteController.php?acao=visualizar&id=<?= $equipamento['id_cliente'] ?>">
            <?= htmlspecialchars($equipamento['nome_cliente']) ?>
        </a>
    </li>
    <li class="list-group-item"><strong>Tipo:</strong> <?= htmlspecialchars($equipamento['tipo']) ?></li>
    <li class="list-group-item"><strong>Marca:</strong> <?= htmlspecialchars($equipamento['marca'] ?? '') ?></li>
    <li class="list-group-item"><strong>Modelo:</strong> <?= htmlspecialchars($equipamento['modelo'] ?? '') ?></li>
    <li class="list-group-item"><strong>Número de série:</strong> <?= htmlspecialchars($equipamento['numero_serie'] ?? '') ?></li>
    <li class="list-group-item"><strong>Patrimônio:</strong> <?= htmlspecialchars($equipamento['patrimonio'] ?? '') ?></li>
    <li class="list-group-item"><strong>Sistema operacional:</strong> <?= htmlspecialchars($equipamento['sistema_operacional'] ?? '') ?></li>
    <li class="list-group-item"><strong>Descrição:</strong> <?= nl2br(htmlspecialchars($equipamento['descricao'] ?? '')) ?></li>
    <li class="list-group-item"><strong>Senha de acesso:</strong> <?= htmlspecialchars($equipamento['senha_acesso'] ?? '') ?></li>
</ul>

<a href="EquipamentoController.php?acao=form_editar&id=<?= $equipamento['id_equipamento'] ?>" class="btn btn-warning">Editar</a>
<a href="EquipamentoController.php?acao=listar" class="btn btn-secondary">Voltar</a>

<?php require "../views/layouts/footer.php"; ?>