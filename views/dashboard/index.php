<?php require "../views/layouts/header.php"; ?>

<div class="alert alert-primary">
    <h2 class="h5 mb-1"><?= $saudacao ?>, <?= htmlspecialchars($_SESSION["usuario_nome"]) ?>!</h2>
    <p class="mb-0">Resumo do que está acontecendo no sistema.</p>
</div>

<div class="row g-3 mb-4">

    <div class="col-sm-6 col-lg-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="text-muted small">Clientes</div>
                <div class="display-6 fw-bold"><?= $resumo['total_clientes'] ?></div>
                <a href="ClienteController.php" class="small stretched-link">Ver clientes</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="text-muted small">Equipamentos</div>
                <div class="display-6 fw-bold"><?= $resumo['total_equipamentos'] ?></div>
                <a href="EquipamentoController.php" class="small stretched-link">Ver equipamentos</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="text-muted small">Técnicos ativos</div>
                <div class="display-6 fw-bold"><?= $resumo['tecnicos_ativos'] ?></div>
                <a href="TecnicoController.php" class="small stretched-link">Ver técnicos</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="text-muted small">OS em aberto</div>
                <div class="display-6 fw-bold"><?= $resumo['os_em_aberto'] ?></div>
                <a href="OrdemServicoController.php" class="small stretched-link">Ver ordens de serviço</a>
            </div>
        </div>
    </div>

</div>

<div class="row g-3">

    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">Ordens de serviço por status</div>
            <ul class="list-group list-group-flush">
                <?php if (empty($porStatus)): ?>
                    <li class="list-group-item text-center">Nenhuma ordem de serviço ainda.</li>
                <?php endif; ?>

                <?php foreach ($porStatus as $s): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= htmlspecialchars($s['status']) ?>
                        <span class="badge text-bg-primary rounded-pill"><?= $s['total'] ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Últimas ordens de serviço</span>
                <a href="OrdemServicoController.php?acao=form_criar" class="btn btn-primary btn-sm">Nova OS</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Cliente</th>
                            <th>Equipamento</th>
                            <th>Status</th>
                            <th>Abertura</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($ultimasOS)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Nenhuma ordem de serviço ainda.</td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($ultimasOS as $o): ?>
                            <tr>
                                <td><?= htmlspecialchars($o['numero_os']) ?></td>
                                <td><?= htmlspecialchars($o['nome_cliente']) ?></td>
                                <td><?= htmlspecialchars(trim($o['tipo_equipamento'] . ' ' . ($o['marca'] ?? '') . ' ' . ($o['modelo'] ?? ''))) ?></td>
                                <td><?= htmlspecialchars($o['status']) ?></td>
                                <td><?= date('d/m/Y', strtotime($o['data_abertura'])) ?></td>
                                <td>
                                    <a href="OrdemServicoController.php?acao=visualizar&id=<?= $o['id_os'] ?>"
                                       class="btn btn-info btn-sm">Ver</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<?php if ($ehAdmin): ?>

<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Filtrar ordens de serviço</span>
        <span class="badge text-bg-secondary">Administrador</span>
    </div>

    <div class="card-body">
        <form method="GET" action="DashboardController.php" class="row g-3 align-items-end">

            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Todos</option>
                    <?php foreach ($statusLista as $s): ?>
                        <option value="<?= $s ?>" <?= $filtroStatus === $s ? 'selected' : '' ?>>
                            <?= $s ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Prioridade</label>
                <select name="prioridade" class="form-select">
                    <option value="">Todas</option>
                    <?php foreach ($prioridadeLista as $p): ?>
                        <option value="<?= $p ?>" <?= $filtroPrioridade === $p ? 'selected' : '' ?>>
                            <?= $p ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="DashboardController.php" class="btn btn-secondary">Limpar</a>
            </div>

        </form>
    </div>

    <div class="card-footer text-muted small">
        <?= count($ordensFiltradas) ?> ordem(ns) encontrada(s)
    </div>

    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>Cliente</th>
                    <th>Equipamento</th>
                    <th>Técnico</th>
                    <th>Prioridade</th>
                    <th>Status</th>
                    <th>Previsão</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($ordensFiltradas)): ?>
                    <tr>
                        <td colspan="8" class="text-center">Nenhuma ordem de serviço com esses filtros.</td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($ordensFiltradas as $o): ?>
                    <tr>
                        <td><?= htmlspecialchars($o['numero_os']) ?></td>
                        <td><?= htmlspecialchars($o['nome_cliente']) ?></td>
                        <td><?= htmlspecialchars(trim($o['tipo_equipamento'] . ' ' . ($o['marca'] ?? '') . ' ' . ($o['modelo'] ?? ''))) ?></td>
                        <td><?= htmlspecialchars($o['nome_tecnico']) ?></td>
                        <td><?= htmlspecialchars($o['prioridade']) ?></td>
                        <td><?= htmlspecialchars($o['status']) ?></td>
                        <td><?= !empty($o['data_previsao']) ? date('d/m/Y', strtotime($o['data_previsao'])) : '' ?></td>
                        <td>
                            <a href="OrdemServicoController.php?acao=visualizar&id=<?= $o['id_os'] ?>"
                               class="btn btn-info btn-sm">Ver</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php endif; ?>

<?php require "../views/layouts/footer.php"; ?>