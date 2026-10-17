<?php

require "../views/layouts/header.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Técnicos</h2>
    <a href="TecnicoController.php?acao=form_criar" class="btn btn-primary">Novo técnico</a>
</div>

<div class="table-responsive">
<table class="table table-striped align-middle text-nowrap">
    <thead>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Especialidade</th>
            <th>Nível</th>
            <th>Status</th>
            <th>Data de Admissão</th>
            <th>Observações</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($tecnicos)): ?>
            <tr>
                <td colspan="10" class="text-center">Nenhum técnico cadastrado.</td>
            </tr>
        <?php endif; ?>

        <?php foreach ($tecnicos as $t): ?>
            <tr>
                <td>
                    <span class="d-inline-block text-truncate" style="max-width: 160px;"
                          title="<?= htmlspecialchars($t['nome'], ENT_QUOTES) ?>">
                        <?= htmlspecialchars($t['nome']) ?>
                    </span>
                </td>
                <td><?= htmlspecialchars($t['cpf']) ?></td>
                <td>
                    <span class="d-inline-block text-truncate" style="max-width: 200px;"
                          title="<?= htmlspecialchars($t['email'], ENT_QUOTES) ?>">
                        <?= htmlspecialchars($t['email']) ?>
                    </span>
                </td>
                <td><?= htmlspecialchars($t['telefone'] ?? '') ?></td>
                <td>
                    <span class="d-inline-block text-truncate" style="max-width: 160px;"
                          title="<?= htmlspecialchars($t['especialidade'] ?? '', ENT_QUOTES) ?>">
                        <?= htmlspecialchars($t['especialidade'] ?? '') ?>
                    </span>
                </td>
                <td><?= htmlspecialchars($t['nivel'] ?? '') ?></td>
                <td><?= htmlspecialchars($t['status']) ?></td>
                <td><?= htmlspecialchars($t['data_admissao']) ?></td>
                <td>
                    <?php if (!empty($t['observacoes'])): ?>
                        <button type="button" class="btn btn-link p-0"
                                data-bs-toggle="modal" data-bs-target="#modalObservacao"
                                data-titulo="<?= htmlspecialchars($t['nome'], ENT_QUOTES) ?>"
                                data-texto="<?= htmlspecialchars($t['observacoes'], ENT_QUOTES) ?>">
                            ...
                        </button>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="TecnicoController.php?acao=visualizar&id=<?= $t['id_tecnico'] ?>"
                       class="btn btn-info btn-sm">Ver</a>
                    <a href="TecnicoController.php?acao=form_editar&id=<?= $t['id_tecnico'] ?>"
                       class="btn btn-warning btn-sm">Editar</a>

                    <form method="POST"
                          action="TecnicoController.php?acao=excluir"
                          onsubmit="return confirm('Excluir este técnico?');"
                          style="display:inline;">
                        <input type="hidden" name="id_tecnico" value="<?= $t['id_tecnico'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>

<!-- Modal único, reaproveitado por todas as linhas -->
<div class="modal fade" id="modalObservacao" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalObservacaoTitulo">Observações</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body" id="modalObservacaoTexto" style="white-space: pre-wrap;"></div>
        </div>
    </div>
</div>

<script>
document.getElementById('modalObservacao').addEventListener('show.bs.modal', function (event) {
    var botao = event.relatedTarget;
    document.getElementById('modalObservacaoTitulo').textContent = 'Observações - ' + botao.getAttribute('data-titulo');
    document.getElementById('modalObservacaoTexto').textContent = botao.getAttribute('data-texto');
});
</script>

<?php require "../views/layouts/footer.php"; ?>