<?php $pagina = $_SERVER['SCRIPT_NAME']; ?>
<aside class="bg-body border-end p-3 flex-shrink-0" style="width: 220px; min-height: calc(100vh - 56px);"> 

    <nav class="nav nav-pills flex-column gap-1">

        <a class="nav-link <?= str_contains($pagina, 'DashboardController') ? 'active' : '' ?>"
            href="/PBL/controllers/DashboardController.php">Dashboard</a>

        <a class="nav-link <?= str_contains($pagina, 'ClienteController') ? 'active' : '' ?>"
           href="/PBL/controllers/ClienteController.php">Clientes</a>

        <a class="nav-link <?= str_contains($pagina, 'EquipamentoController') ? 'active' : '' ?>"
           href="/PBL/controllers/EquipamentoController.php">Equipamentos</a>

        <a class="nav-link <?= str_contains($pagina, 'OrdemServicoController') ? 'active' : '' ?>"
           href="/PBL/controllers/OrdemServicoController.php">Ordens de Serviço</a>

        <a class="nav-link <?= str_contains($pagina, 'TecnicoController') ? 'active' : '' ?>"
           href="/PBL/controllers/TecnicoController.php">Técnicos</a>

    </nav>
</aside>