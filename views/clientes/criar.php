<?php
$cliente = [];
$acao_form = "criar";

require "../views/layouts/header.php";
?>

<h2 class="mb-4">Novo cliente</h2>

<?php require "../views/clientes/_form.php"; ?>

<?php require "../views/layouts/footer.php"; ?>