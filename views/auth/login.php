<?php
    session_start();

    $erro = $_SESSION["erro"] ?? null;
    unset($_SESSION["erro"]);
?>

<!doctype html>
<html lang="en" data-bs-theme="<?= 
    (($_COOKIE['tema'] ?? 'light') === 'dark') ? 'dark' : 'light' ?>">
    <head>
        <title>Login</title>

        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- Bootstrap CSS v5.3.8 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
        

        body {
            
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            
        }

    </style>
    </head>

    <body>

    <main class="container">
        <div class="row min-vh-100 d-flex justify-content-center align-items-center">
            <div class="col-md-6 col-lg-4">

                <div class="card shadow">
                    <div class="card-body p-4">

                        <h1 class="text-center mb-4" style="color:#1e3c72;">Login</h1>

                        <?php if ($erro): ?>
                            <div class="alert alert-danger text-center">
                                <?php echo htmlspecialchars($erro); ?>
                            </div>
                        <?php endif; ?>

                        <form action="../../controllers/authcontrollers/LoginController.php" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail:</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="Digite seu e-mail"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha:</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="senha"
                                    name="senha"
                                    placeholder="Digite sua senha"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Entrar
                            </button>

                            <div class="text-center mt-3">
                                <a href="cadastro.php">Não é um cliente? Cadastre-se</a>
                            </div>
                            <p class="text-center text-muted mt-3 mb-0">
                                 Assistência Técnica - Recife
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>