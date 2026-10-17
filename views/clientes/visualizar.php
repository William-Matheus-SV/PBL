<?php require "../views/layouts/header.php"; ?>

<h2 class="mb-4">Cliente: <?= htmlspecialchars($cliente['nome']) ?></h2>

<ul class="list-group mb-4">
    <li class="list-group-item"><strong>CPF/CNPJ:</strong> <?= htmlspecialchars($cliente['cpf_cnpj']) ?></li>
    <li class="list-group-item"><strong>E-mail:</strong> <?= htmlspecialchars($cliente['email']) ?></li>
    <li class="list-group-item"><strong>Telefone:</strong> <?= htmlspecialchars($cliente['telefone'] ?? '') ?></li>
    <li class="list-group-item"><strong>Telefone secundário:</strong> <?= htmlspecialchars($cliente['telefone_secundario'] ?? '') ?></li>
    <li class="list-group-item"><strong>Endereço:</strong>
        <?= htmlspecialchars($cliente['logradouro'] ?? '') ?>,
        <?= htmlspecialchars($cliente['numero'] ?? '') ?> -
        <?= htmlspecialchars($cliente['bairro'] ?? '') ?>,
        <?= htmlspecialchars($cliente['cidade'] ?? '') ?>/<?= htmlspecialchars($cliente['estado'] ?? '') ?>
        - CEP <?= htmlspecialchars($cliente['cep'] ?? '') ?>
    </li>
    <li class="list-group-item"><strong>Cadastrado em:</strong> <?= htmlspecialchars($cliente['data_cadastro']) ?></li>
    <li class="list-group-item"><strong>Status:</strong> <?= htmlspecialchars($cliente['status']) ?></li>
</ul>

<a href="ClienteController.php?acao=form_editar&id=<?= $cliente['id_cliente'] ?>" class="btn btn-warning">Editar</a>
<a href="ClienteController.php?acao=listar" class="btn btn-secondary">Voltar</a>

<?php require "../views/layouts/footer.php"; ?>