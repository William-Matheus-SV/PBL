<form method="POST" action="ClienteController.php?acao=<?= $acao_form ?>">

    <?php if (!empty($cliente['id_cliente'])): ?>
        <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">
    <?php endif; ?>

    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">CPF/CNPJ *</label>
            <input type="text" name="cpf_cnpj" class="form-control" maxlength="18" required
                   value="<?= htmlspecialchars($cliente['cpf_cnpj'] ?? '') ?>">
        </div>
        <div class="col-md-8">
            <label class="form-label">Nome *</label>
            <input type="text" name="nome" class="form-control" maxlength="150" required
                   value="<?= htmlspecialchars($cliente['nome'] ?? '') ?>">
        </div>

        <div class="col-md-6">
            <label class="form-label">E-mail *</label>
            <input type="email" name="email" class="form-control" maxlength="150" required
                   value="<?= htmlspecialchars($cliente['email'] ?? '') ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Telefone</label>
            <input type="text" name="telefone" class="form-control" maxlength="20"
                   value="<?= htmlspecialchars($cliente['telefone'] ?? '') ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Telefone secundário</label>
            <input type="text" name="telefone_secundario" class="form-control" maxlength="20"
                   value="<?= htmlspecialchars($cliente['telefone_secundario'] ?? '') ?>">
        </div>

        <div class="col-md-8">
            <label class="form-label">Logradouro</label>
            <input type="text" name="logradouro" class="form-control" maxlength="200"
                   value="<?= htmlspecialchars($cliente['logradouro'] ?? '') ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">Número</label>
            <input type="text" name="numero" class="form-control" maxlength="10"
                   value="<?= htmlspecialchars($cliente['numero'] ?? '') ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">CEP</label>
            <input type="text" name="cep" class="form-control" maxlength="10"
                   value="<?= htmlspecialchars($cliente['cep'] ?? '') ?>">
        </div>

        <div class="col-md-4">
            <label class="form-label">Bairro</label>
            <input type="text" name="bairro" class="form-control" maxlength="100"
                   value="<?= htmlspecialchars($cliente['bairro'] ?? '') ?>">
        </div>
        <div class="col-md-5">
            <label class="form-label">Cidade</label>
            <input type="text" name="cidade" class="form-control" maxlength="100"
                   value="<?= htmlspecialchars($cliente['cidade'] ?? '') ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Estado</label>
            <input type="text" name="estado" class="form-control" maxlength="50"
                   value="<?= htmlspecialchars($cliente['estado'] ?? '') ?>">
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="ClienteController.php?acao=listar" class="btn btn-secondary">Cancelar</a>
    </div>
</form>