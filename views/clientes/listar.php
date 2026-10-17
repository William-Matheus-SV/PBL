<?php 

require "../views/layouts/header.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Clientes</h2>
    <a href="ClienteController.php?acao=form_criar" class="btn btn-primary">Novo cliente</a>
</div>


<form method="GET" action="ClienteController.php" class="row g-2 mb-3">
    <input type="hidden" name="acao" value="listar">
    <div class="col-md-6">
        <input type="text" name="busca" class="form-control"
               placeholder="Pesquisar por nome, CPF/CNPJ ou e-mail"
               value="<?= htmlspecialchars($busca ?? '') ?>">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Pesquisar</button>
        <a href="ClienteController.php?acao=listar" class="btn btn-secondary">Limpar</a>
    </div>
</form>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Nome</th>
            <th>CPF/CNPJ</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($clientes)): ?>
            <tr>
                <td colspan="6" class="text-center">Nenhum cliente cadastrado.</td>
            </tr>
        <?php endif; ?>

        <?php foreach ($clientes as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['nome']) ?></td>
                <td><?= htmlspecialchars($c['cpf_cnpj']) ?></td>
                <td><?= htmlspecialchars($c['email']) ?></td>
                <td><?= htmlspecialchars($c['telefone'] ?? '') ?></td>
                <td><?= htmlspecialchars($c['status']) ?></td>
                <td>
                    <a href="ClienteController.php?acao=visualizar&id=<?= $c['id_cliente'] ?>"
                       class="btn btn-info btn-sm">Ver</a>
                    <a href="ClienteController.php?acao=form_editar&id=<?= $c['id_cliente'] ?>"
                       class="btn btn-warning btn-sm">Editar</a>

                    <form method="POST"
                          action="ClienteController.php?acao=excluir"
                          onsubmit="return confirm('Excluir este cliente?');"
                          style="display:inline;">
                        <input type="hidden" name="id_cliente" value="<?= $c['id_cliente'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require "../views/layouts/footer.php"; ?>