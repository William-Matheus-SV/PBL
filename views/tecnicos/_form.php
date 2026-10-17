<form method="POST" action="TecnicoController.php?acao=<?= $acao_form ?>">

    <?php if (!empty($tecnico['id_tecnico'])): ?>
        <input type="hidden" name="id_tecnico" value="<?= $tecnico['id_tecnico'] ?>">
    <?php endif; ?>

    <div class="row g-3">

        <div class="col-md-8">
            <label class="form-label">Nome *</label>
            <input type="text" name="nome" class="form-control" maxlength="150" required
                   value="<?= htmlspecialchars($tecnico['nome'] ?? '') ?>">
        </div>

        <div class="col-md-4">
            <label class="form-label">CPF *</label>
            <input type="text" name="cpf" class="form-control" maxlength="14" required
                   value="<?= htmlspecialchars($tecnico['cpf'] ?? '') ?>">
        </div>

        <div class="col-md-8">
            <label class="form-label">E-mail *</label>
            <input type="email" name="email" class="form-control" maxlength="150" required
                   value="<?= htmlspecialchars($tecnico['email'] ?? '') ?>">
        </div>

        <div class="col-md-4">
            <label class="form-label">Telefone</label>
            <input type="text" name="telefone" class="form-control" maxlength="20"
                   value="<?= htmlspecialchars($tecnico['telefone'] ?? '') ?>">
        </div>

        <div class="col-md-5">
            <label class="form-label">Especialidade</label>
            <input type="text" name="especialidade" class="form-control" maxlength="100"
                   value="<?= htmlspecialchars($tecnico['especialidade'] ?? '') ?>">
        </div>

        <div class="col-md-3">
            <label class="form-label">Nível</label>
            <input type="text" name="nivel" class="form-control" maxlength="50"
                   value="<?= htmlspecialchars($tecnico['nivel'] ?? '') ?>">
        </div>

        <div class="col-md-4">
            <label class="form-label">Data de admissão</label>
            <input type="date" name="data_admissao" class="form-control"
                   value="<?= htmlspecialchars($tecnico['data_admissao'] ?? '') ?>">
        </div>

        <?php if (!empty($tecnico['id_tecnico'])): ?>
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="Ativo" <?= ($tecnico['status'] ?? '') === 'Ativo' ? 'selected' : '' ?>>Ativo</option>
                    <option value="Inativo" <?= ($tecnico['status'] ?? '') === 'Inativo' ? 'selected' : '' ?>>Inativo</option>
                </select>
            </div>
        <?php endif; ?>

        <div class="col-12">
            <label class="form-label">Observações</label>
            <textarea name="observacoes" class="form-control" rows="3"><?= htmlspecialchars($tecnico['observacoes'] ?? '') ?></textarea>
        </div>

    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="TecnicoController.php?acao=listar" class="btn btn-secondary">Cancelar</a>
    </div>
</form>