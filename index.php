<?php

header("Location: controllers/DashboardController.php");
exit();

?>
/*date_default_timezone_set("America/Sao_Paulo");
session_start();

if (!isset($_SESSION["usuario_id"])) {

    header("Location: login.php");
    exit;

}

$hora = (int) date("H");

if ($hora < 12) {
    $saudacao = "Bom dia";
} elseif ($hora < 18) {
    $saudacao = "Boa tarde";
} else {
    $saudacao = "Boa noite";
}

$bsTheme = 
(($_COOKIE["tema"] ?? "light") === "dark") ? "dark" : "light";

?>

<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="<?php echo $bsTheme; ?>">


<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Painel</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        // PÁGINA
        body { background: linear-gradient(135deg,#1e3c72,#2a5298); }
    </style>

</head>

<body>
    <main class="container">
        <div class="row min-vh-100 d-flex justify-content-center align-items-center">
             <div class="col-md-8 col-lg-6">
                 <div class="card shadow position-relative">

                    <div class="position-absolute top-0 end-0 m-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="themeSwitch">
                        <label class="form-check-label small fw-bold" for="themeSwitch" id="themeLabel">Escuro</label>
                    </div>

                    <div class="card-body p-4">
                        <h1>Área Restrita</h1>

                        <div class="alert alert-primary">

                            <h2 class="h5 mb-1"> 
                                <?php echo $saudacao; ?>
                                <?php echo htmlspecialchars($_SESSION["usuario_nome"]); ?>!
                            </h2>
                            <p class = "mb-0">Você está autenticado no sistema.</p>

                        </div>

                        <!-- Informações -->
                        <h3 class="h6 mb-2" style="color: #1e3c72;">Informações do usuário</h3>

                        <ul class="list-group mb-4">

                            <li class="list-group-item">

                                <strong>ID:</strong>

                                <?php echo htmlspecialchars($_SESSION["usuario_id"]); ?>

                            </li>

                            <li class="list-group-item">

                                <strong>Nome:</strong>

                                <?php echo htmlspecialchars($_SESSION["usuario_nome"]); ?>

                            </li>

                            <li class="list-group-item">

                                <strong>E-mail:</strong>

                                <?php echo htmlspecialchars($_SESSION["usuario_email"]); ?>

                            </li>

                        </ul>

                        <!-- Botões -->
                        <div class="d-flex justify-content-between">
                            <a href="/PBL/controllers/ClienteController.php" class="btn btn-primary btn-sm px-4">Clientes</a>
                            <a href="controllers/authcontrollers/LogoutController.php" class="btn btn-danger btn-sm px-4"> Sair </a>
                        </div>

                    </div>

                    <div class="card-footer text-center text-muted small">Sistema de Autenticação PHP</div>

                </div>

            </div>

        </div>

    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para alterar o tema instantaneamente -->
    <script>
    const themeSwitch = document.getElementById('themeSwitch');
    const themeLabel = document.getElementById('themeLabel');

    function aplicarTema(tema) {
        document.documentElement.setAttribute('data-bs-theme', tema);
        themeSwitch.checked = (tema === 'dark');
        themeLabel.textContent = (tema === 'dark') ? 'Escuro' : 'Claro';
    }

    // Começa com o tema que o PHP já colocou no <html> (vindo do cookie)
    aplicarTema(document.documentElement.getAttribute('data-bs-theme'));

    themeSwitch.addEventListener('change', () => {
        const novoTema = themeSwitch.checked ? 'dark' : 'light';
        aplicarTema(novoTema);
        document.cookie = 'tema=' + novoTema + '; path=/; max-age=2592000';
    });
</script>
</body>

</html>
*/