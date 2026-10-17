<?php

require "../views/layouts/header.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Equipamentos</h2>
    <a href="EquipamentoController.php?acao=form_criar" class="btn btn-primary">Novo equipamento</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Tipo</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Nº de série</th>
            <th>Patrimônio</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($equipamentos)): ?>
            <tr>
                <td colspan="7" class="text-center">Nenhum equipamento cadastrado.</td>
            </tr>
        <?php endif; ?>

        <?php foreach ($equipamentos as $e): ?>
            <tr>
                <td><?= htmlspecialchars($e['nome_cliente']) ?></td>
                <td><?= htmlspecialchars($e['tipo']) ?></td>
                <td><?= htmlspecialchars($e['marca'] ?? '') ?></td>
                <td><?= htmlspecialchars($e['modelo'] ?? '') ?></td>
                <td><?= htmlspecialchars($e['numero_serie'] ?? '') ?></td>
                <td><?= htmlspecialchars($e['patrimonio'] ?? '') ?></td>
                <td>
                    <a href="EquipamentoController.php?acao=visualizar&id=<?= $e['id_equipamento'] ?>"
                       class="btn btn-info btn-sm">Ver</a>
                    <a href="EquipamentoController.php?acao=form_editar&id=<?= $e['id_equipamento'] ?>"
                       class="btn btn-warning btn-sm">Editar</a>

                    <form method="POST"
                          action="EquipamentoController.php?acao=excluir"
                          onsubmit="return confirm('Excluir este equipamento?');"
                          style="display:inline;">
                        <input type="hidden" name="id_equipamento" value="<?= $e['id_equipamento'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require "../views/layouts/footer.php"; ?>