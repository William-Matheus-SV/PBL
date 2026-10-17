<?php $editando = !empty($os['id_os']); ?>

<form method="POST" action="OrdemServicoController.php?acao=<?= $acao_form ?>">

    <?php if ($editando): ?>
        <input type="hidden" name="id_os" value="<?= $os['id_os'] ?>">
    <?php endif; ?>

    <div class="row g-3">

        <?php if ($editando): ?>

            <div class="col-md-3">
                <label class="form-label">Nº da OS</label>
                <input type="text" class="form-control" disabled
                       value="<?= htmlspecialchars($os['numero_os']) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Cliente</label>
                <input type="text" class="form-control" disabled
                       value="<?= htmlspecialchars($os['nome_cliente']) ?>">
            </div>
            <div class="col-md-5">
                <label class="form-label">Equipamento</label>
                <input type="text" class="form-control" disabled
                       value="<?= htmlspecialchars(trim($os['tipo_equipamento'] . ' ' . ($os['marca'] ?? '') . ' ' . ($os['modelo'] ?? ''))) ?>">
            </div>

        <?php else: ?>

            <div class="col-md-12">
                <label class="form-label">Equipamento *</label>
                <select name="id_equipamento" class="form-select" required>
                    <option value="">Selecione...</option>
                    <?php foreach ($equipamentos as $e): ?>
                        <option value="<?= $e['id_equipamento'] ?>"
                                <?= ($os['id_equipamento'] ?? '') == $e['id_equipamento'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars(trim(($e['tipo'] ?? '') . ' ' . ($e['marca'] ?? '') . ' ' . ($e['modelo'] ?? '')) . ' — ' . $e['nome_cliente']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        <?php endif; ?>

        <div class="col-md-4">
            <label class="form-label">Técnico *</label>
            <select name="id_tecnico" class="form-select" required>
                <option value="">Selecione...</option>
                <?php foreach ($tecnicos as $t): ?>
                    <?php
                    $selecionado = ($os['id_tecnico'] ?? '') == $t['id_tecnico'];
                    $bloqueado   = $t['status'] !== 'Ativo' && !$selecionado;
                    ?>
                    <option value="<?= $t['id_tecnico'] ?>"
                            <?= $selecionado ? 'selected' : '' ?>
                            <?= $bloqueado ? 'disabled' : '' ?>>
                        <?= htmlspecialchars($t['nome']) ?><?= $t['status'] !== 'Ativo' ? ' (inativo)' : '' ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Prioridade</label>
            <select name="prioridade" class="form-select">
                <?php foreach ($prioridadeLista as $p): ?>
                    <option value="<?= $p ?>" <?= ($os['prioridade'] ?? 'Normal') === $p ? 'selected' : '' ?>>
                        <?= $p ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Previsão de entrega</label>
            <input type="date" name="data_previsao" class="form-control"
                   value="<?= htmlspecialchars($os['data_previsao'] ?? '') ?>">
        </div>

        <div class="col-md-2">
            <label class="form-label">Valor estimado</label>
            <input type="number" name="valor_estimado" class="form-control" step="0.01" min="0"
                   value="<?= htmlspecialchars($os['valor_estimado'] ?? '') ?>">
        </div>

        <div class="col-12">
            <label class="form-label">Problema relatado *</label>
            <textarea name="problema_relatado" class="form-control" rows="3" required><?= htmlspecialchars($os['problema_relatado'] ?? '') ?></textarea>
        </div>

        <?php if ($editando): ?>

            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <?php foreach ($statusLista as $s): ?>
                        <option value="<?= $s ?>" <?= ($os['status'] ?? '') === $s ? 'selected' : '' ?>>
                            <?= $s ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Data de conclusão</label>
                <input type="date" name="data_conclusao" class="form-control"
                       value="<?= htmlspecialchars($os['data_conclusao'] ?? '') ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label">Valor final</label>
                <input type="number" name="valor_final" class="form-control" step="0.01" min="0"
                       value="<?= htmlspecialchars($os['valor_final'] ?? '') ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label">Forma de pagamento</label>
                <select name="forma_pagamento" class="form-select">
                    <option value="">Não informada</option>
                    <?php foreach ($pagamentoLista as $f): ?>
                        <option value="<?= $f ?>" <?= ($os['forma_pagamento'] ?? '') === $f ? 'selected' : '' ?>>
                            <?= $f ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-12">
                <label class="form-label">Diagnóstico</label>
                <textarea name="diagnostico" class="form-control" rows="3"><?= htmlspecialchars($os['diagnostico'] ?? '') ?></textarea>
            </div>

            <div class="col-12">
                <label class="form-label">Serviço realizado</label>
                <textarea name="servico_realizado" class="form-control" rows="3"><?= htmlspecialchars($os['servico_realizado'] ?? '') ?></textarea>
            </div>

        <?php endif; ?>

        <div class="col-12">
            <label class="form-label">Observações</label>
            <textarea name="observacoes" class="form-control" rows="2"><?= htmlspecialchars($os['observacoes'] ?? '') ?></textarea>
        </div>

    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="OrdemServicoController.php?acao=listar" class="btn btn-secondary">Cancelar</a>
    </div>
</form>