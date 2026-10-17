<?php require "../views/layouts/header.php"; ?>

<h2 class="mb-4">Ordem de serviço <?= htmlspecialchars($os['numero_os']) ?></h2>

<ul class="list-group mb-4">
    <li class="list-group-item"><strong>Cliente:</strong> <?= htmlspecialchars($os['nome_cliente']) ?></li>
    <li class="list-group-item"><strong>Equipamento:</strong>
        <?= htmlspecialchars(trim($os['tipo_equipamento'] . ' ' . ($os['marca'] ?? '') . ' ' . ($os['modelo'] ?? ''))) ?>
    </li>
    <li class="list-group-item"><strong>Técnico:</strong> <?= htmlspecialchars($os['nome_tecnico']) ?></li>
    <li class="list-group-item"><strong>Status:</strong> <?= htmlspecialchars($os['status']) ?></li>
    <li class="list-group-item"><strong>Prioridade:</strong> <?= htmlspecialchars($os['prioridade']) ?></li>
    <li class="list-group-item"><strong>Abertura:</strong> <?= date('d/m/Y H:i', strtotime($os['data_abertura'])) ?></li>
    <li class="list-group-item"><strong>Previsão de entrega:</strong>
        <?= !empty($os['data_previsao']) ? date('d/m/Y', strtotime($os['data_previsao'])) : '' ?>
    </li>
    <li class="list-group-item"><strong>Conclusão:</strong>
        <?= !empty($os['data_conclusao']) ? date('d/m/Y', strtotime($os['data_conclusao'])) : '' ?>
    </li>
    <li class="list-group-item"><strong>Problema relatado:</strong> <?= nl2br(htmlspecialchars($os['problema_relatado'] ?? '')) ?></li>
    <li class="list-group-item"><strong>Diagnóstico:</strong> <?= nl2br(htmlspecialchars($os['diagnostico'] ?? '')) ?></li>
    <li class="list-group-item"><strong>Serviço realizado:</strong> <?= nl2br(htmlspecialchars($os['servico_realizado'] ?? '')) ?></li>
    <li class="list-group-item"><strong>Valor estimado:</strong> R$ <?= number_format($os['valor_estimado'], 2, ',', '.') ?></li>
    <li class="list-group-item"><strong>Valor final:</strong> R$ <?= number_format($os['valor_final'], 2, ',', '.') ?></li>
    <li class="list-group-item"><strong>Forma de pagamento:</strong> <?= htmlspecialchars($os['forma_pagamento'] ?? '') ?></li>
    <li class="list-group-item"><strong>Observações:</strong> <?= nl2br(htmlspecialchars($os['observacoes'] ?? '')) ?></li>
</ul>

<a href="OrdemServicoController.php?acao=form_editar&id=<?= $os['id_os'] ?>" class="btn btn-warning">Editar</a>
<a href="OrdemServicoController.php?acao=listar" class="btn btn-secondary">Voltar</a>

<?php require "../views/layouts/footer.php"; ?>