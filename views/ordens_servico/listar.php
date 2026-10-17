<?php require "../views/layouts/header.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Ordens de serviço</h2>
    <a href="OrdemServicoController.php?acao=form_criar" class="btn btn-primary">Nova OS</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Nº</th>
            <th>Cliente</th>
            <th>Equipamento</th>
            <th>Técnico</th>
            <th>Prioridade</th>
            <th>Status</th>
            <th>Abertura</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($ordens)): ?>
            <tr>
                <td colspan="8" class="text-center">Nenhuma ordem de serviço cadastrada.</td>
            </tr>
        <?php endif; ?>

        <?php foreach ($ordens as $o): ?>
            <tr>
                <td><?= htmlspecialchars($o['numero_os']) ?></td>
                <td><?= htmlspecialchars($o['nome_cliente']) ?></td>
                <td><?= htmlspecialchars(trim($o['tipo_equipamento'] . ' ' . ($o['marca'] ?? '') . ' ' . ($o['modelo'] ?? ''))) ?></td>
                <td><?= htmlspecialchars($o['nome_tecnico']) ?></td>
                <td><?= htmlspecialchars($o['prioridade']) ?></td>
                <td><?= htmlspecialchars($o['status']) ?></td>
                <td><?= date('d/m/Y', strtotime($o['data_abertura'])) ?></td>
                <td>
                    <a href="OrdemServicoController.php?acao=visualizar&id=<?= $o['id_os'] ?>"
                       class="btn btn-info btn-sm">Ver</a>
                    <a href="OrdemServicoController.php?acao=form_editar&id=<?= $o['id_os'] ?>"
                       class="btn btn-warning btn-sm">Editar</a>

                    <form method="POST"
                          action="OrdemServicoController.php?acao=excluir"
                          onsubmit="return confirm('Excluir esta ordem de serviço?');"
                          style="display:inline;">
                        <input type="hidden" name="id_os" value="<?= $o['id_os'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require "../views/layouts/footer.php"; ?>