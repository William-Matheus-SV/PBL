<?php
session_start();

$erro = $_SESSION["erro"] ?? null;
$sucesso = $_SESSION["sucesso"] ?? null;
$old = $_SESSION["old"] ?? [];
unset($_SESSION["erro"], $_SESSION["sucesso"], $_SESSION["old"]);
?>


<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="<?=
 (($_COOKIE['tema'] ?? 'light') === 'dark') ? 'dark' : 'light' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #1e3c72, #2a5298); }
    </style>
</head>
<body>
    <main class="container">
        <div class="row min-vh-100 d-flex justify-content-center align-items-center py-4">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <div class="pt-3">
                            <a href="login.php" 
                                class="btn btn-secondary rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px; padding: 0;"
                                title="Voltar para o Login">
                                    <img src="../../imagens/voltar.png" alt="Voltar" width="24" height="24" style="filter: brightness(0) invert(1);">
                            </a>
                        </div>
                        <h1 class="text-center mb-4" style="color:#1e3c72;">Cadastro de Cliente</h1>

                        <?php if ($erro): ?>
                            <div class="alert alert-danger text-center">
                                <?php echo htmlspecialchars($erro); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($sucesso): ?>
                            <div class="alert alert-success text-center">
                                <?php echo htmlspecialchars($sucesso); ?>
                            </div>
                        <?php endif; ?>

                        <form action="../../controllers/authcontrollers/CadastrarClienteController.php" method="POST">
                            
                            <div class="row g-3">
                            
                                <div class="col-md-8">
                                    <label for="nome" class="form-label">Nome *</label>
                                    <input type="text" class="form-control" id="nome" name="nome"
                                           maxlength="150" required
                                           value="<?php echo htmlspecialchars($old['nome'] ?? ''); ?>">
                                </div>

                                <div class="col-md-4">
                                    <label for="cpf_cnpj" class="form-label">CPF/CNPJ *</label>
                                    <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj"
                                           maxlength="18" required
                                           value="<?php echo htmlspecialchars($old['cpf_cnpj'] ?? ''); ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">E-mail *</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           maxlength="150" required
                                           value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>">
                                </div>

                                <div class="col-md-3">
                                    <label for="telefone" class="form-label">Telefone *</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone"
                                           maxlength="20"
                                           value="<?php echo htmlspecialchars($old['telefone'] ?? ''); ?>">
                                </div>

                                <div class="col-md-3">
                                    <label for="telefone_secundario" class="form-label">Telefone secundário</label>
                                    <input type="text" class="form-control" id="telefone_secundario" name="telefone_secundario" placeholder="opcional"
                                           maxlength="20"
                                           value="<?php echo htmlspecialchars($old['telefone_secundario'] ?? ''); ?>">
                                </div>

                                <div class="col-md-8">
                                    <label for="logradouro" class="form-label">Logradouro</label>
                                    <input type="text" class="form-control" id="logradouro" name="logradouro" placeholder ="Exemplo: Av: Rua:"
                                           maxlength="200"
                                           value="<?php echo htmlspecialchars($old['logradouro'] ?? ''); ?>">
                                </div>

                                <div class="col-md-2">
                                    <label for="numero" class="form-label">Número</label>
                                    <input type="text" class="form-control" id="numero" name="numero"
                                           maxlength="10"
                                           value="<?php echo htmlspecialchars($old['numero'] ?? ''); ?>">
                                </div>

                                <div class="col-md-2">
                                    <label for="cep" class="form-label">CEP</label>
                                    <input type="text" class="form-control" id="cep" name="cep"
                                           maxlength="10"
                                           value="<?php echo htmlspecialchars($old['cep'] ?? ''); ?>">
                                </div>

                                <div class="col-md-4">
                                    <label for="bairro" class="form-label">Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro"
                                           maxlength="100"
                                           value="<?php echo htmlspecialchars($old['bairro'] ?? ''); ?>">
                                </div>

                                <div class="col-md-5">
                                    <label for="cidade" class="form-label">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade"
                                           maxlength="100"
                                           value="<?php echo htmlspecialchars($old['cidade'] ?? ''); ?>">
                                </div>

                                <div class="col-md-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <input type="text" class="form-control" id="estado" name="estado"
                                           maxlength="50"
                                           value="<?php echo htmlspecialchars($old['estado'] ?? ''); ?>">
                                </div>

                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary btn-sm px-4">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center text-muted small">
                        Os campos com * são obrigatórios
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>