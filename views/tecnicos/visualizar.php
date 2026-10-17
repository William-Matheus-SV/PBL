<?php require "../views/layouts/header.php"; ?>

<h2 class="mb-4">Técnico: <?= htmlspecialchars($tecnico['nome']) ?></h2>

<ul class="list-group mb-4">
    <li class="list-group-item"><strong>CPF:</strong> <?= htmlspecialchars($tecnico['cpf']) ?></li>
    <li class="list-group-item"><strong>E-mail:</strong> <?= htmlspecialchars($tecnico['email']) ?></li>
    <li class="list-group-item"><strong>Telefone:</strong> <?= htmlspecialchars($tecnico['telefone'] ?? '') ?></li>
    <li class="list-group-item"><strong>Especialidade:</strong> <?= htmlspecialchars($tecnico['especialidade'] ?? '') ?></li>
    <li class="list-group-item"><strong>Nível:</strong> <?= htmlspecialchars($tecnico['nivel'] ?? '') ?></li>
    <li class="list-group-item"><strong>Data de admissão:</strong>
        <?= !empty($tecnico['data_admissao']) ? date('d/m/Y', strtotime($tecnico['data_admissao'])) : '' ?>
    </li>
    <li class="list-group-item"><strong>Status:</strong> <?= htmlspecialchars($tecnico['status']) ?></li>
    <li class="list-group-item"><strong>Observações:</strong> <?= nl2br(htmlspecialchars($tecnico['observacoes'] ?? '')) ?></li>
</ul>

<a href="TecnicoController.php?acao=form_editar&id=<?= $tecnico['id_tecnico'] ?>" class="btn btn-warning">Editar</a>
<a href="TecnicoController.php?acao=listar" class="btn btn-secondary">Voltar</a>

<?php require "../views/layouts/footer.php"; ?>