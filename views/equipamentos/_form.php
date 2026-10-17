<?php $editando = !empty($equipamento['id_equipamento']); ?>

<form method="POST" action="EquipamentoController.php?acao=<?= $acao_form ?>">

    <?php if ($editando): ?>
        <input type="hidden" name="id_equipamento" value="<?= $equipamento['id_equipamento'] ?>">
    <?php endif; ?>

    <div class="row g-3">
        <div class="col-md-8">
            <label class="form-label">Cliente *</label>
            <?php if ($editando): ?>
                <!-- O dono não muda na edição: só mostra o nome -->
                <input type="text" class="form-control" disabled
                       value="<?= htmlspecialchars($equipamento['nome_cliente'] ?? '') ?>">
            <?php else: ?>
                <select name="id_cliente" class="form-select" required>
                    <option value="">Selecione o cliente</option>
                    <?php foreach ($clientes as $c): ?>
                        <option value="<?= $c['id_cliente'] ?>"
                            <?= ((int) $c['id_cliente'] === (int) $id_cliente_selecionado) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tipo *</label>
            <input type="text" name="tipo" class="form-control" required
                   value="<?= htmlspecialchars($equipamento['tipo'] ?? '') ?>">
        </div>

        <div class="col-md-4">
            <label class="form-label">Marca</label>
            <input type="text" name="marca" class="form-control"
                   value="<?= htmlspecialchars($equipamento['marca'] ?? '') ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Modelo</label>
            <input type="text" name="modelo" class="form-control"
                   value="<?= htmlspecialchars($equipamento['modelo'] ?? '') ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Sistema operacional</label>
            <input type="text" name="sistema_operacional" class="form-control"
                   value="<?= htmlspecialchars($equipamento['sistema_operacional'] ?? '') ?>">
        </div>

        <div class="col-md-6">
            <label class="form-label">Número de série</label>
            <input type="text" name="numero_serie" class="form-control"
                   value="<?= htmlspecialchars($equipamento['numero_serie'] ?? '') ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Patrimônio</label>
            <input type="text" name="patrimonio" class="form-control"
                   value="<?= htmlspecialchars($equipamento['patrimonio'] ?? '') ?>">
        </div>

        <div class="col-md-12">
            <label class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" rows="3"><?= htmlspecialchars($equipamento['descricao'] ?? '') ?></textarea>
        </div>

        <div class="col-md-6">
            <label class="form-label">Senha de acesso do equipamento</label>
            <input type="text" name="senha_acesso" class="form-control" autocomplete="off"
                   value="<?= htmlspecialchars($equipamento['senha_acesso'] ?? '') ?>">
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="EquipamentoController.php?acao=listar" class="btn btn-secondary">Cancelar</a>
    </div>
</form>