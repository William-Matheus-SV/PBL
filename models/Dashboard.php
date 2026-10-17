<?php

class Dashboard
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Totais dos cartões
    public function resumo(): array
    {
        $sql = "SELECT
                    (SELECT COUNT(*) FROM clientes) AS total_clientes,
                    (SELECT COUNT(*) FROM equipamentos) AS total_equipamentos,
                    (SELECT COUNT(*) FROM tecnicos WHERE status = 'Ativo') AS tecnicos_ativos,
                    (SELECT COUNT(*) FROM ordens_servico
                        WHERE status IN ('Aberta', 'Em andamento', 'Aguardando peça')) AS os_em_aberto";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Quantas OS existem em cada status
    public function osPorStatus(): array
    {
        $sql = "SELECT status, COUNT(*) AS total
                FROM ordens_servico
                GROUP BY status
                ORDER BY total DESC";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // DESAFIO Adicionar histórico de alterações das ordens (Coloquei as 5 mais recentes, mas só vão aparecer duas kkk pq só criei essas)
    public function ultimasOS(): array
    {
        $sql = "SELECT o.id_os, o.numero_os, o.status, o.data_abertura,
                c.nome AS nome_cliente,
                e.tipo AS tipo_equipamento, e.marca, e.modelo
                FROM ordens_servico o
                INNER JOIN clientes c ON c.id_cliente = o.id_cliente
                INNER JOIN equipamentos e ON e.id_equipamento = o.id_equipamento
                ORDER BY o.data_abertura DESC
                LIMIT 5";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        // Lista as OS filtrando por status e/ou prioridade ('' = sem filtro)
    public function filtrarOS(string $status, string $prioridade): array
    {
        $sql = "SELECT o.id_os, o.numero_os, o.status, o.prioridade,
                       o.data_abertura, o.data_previsao,
                       c.nome AS nome_cliente, t.nome AS nome_tecnico,
                       e.tipo AS tipo_equipamento, e.marca, e.modelo
                FROM ordens_servico o
                INNER JOIN clientes c ON c.id_cliente = o.id_cliente
                INNER JOIN equipamentos e ON e.id_equipamento = o.id_equipamento
                INNER JOIN tecnicos t ON t.id_tecnico = o.id_tecnico
                WHERE 1 = 1";

        $parametros = [];

        if ($status !== '') {
            $sql .= " AND o.status = :status";
            $parametros[':status'] = $status;
        }

        if ($prioridade !== '') {
            $sql .= " AND o.prioridade = :prioridade";
            $parametros[':prioridade'] = $prioridade;
        }

        $sql .= " ORDER BY o.data_abertura DESC LIMIT 50";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($parametros);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}