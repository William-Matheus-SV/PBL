<?php

class OrdemServico
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Abre a OS e devolve o número gerado (ex.: OS-2026-00001)
    public function criar(array $dados): string
    {
        $sql = "INSERT INTO ordens_servico
                (id_cliente, id_equipamento, id_tecnico, numero_os, data_previsao,
                 problema_relatado, prioridade, valor_estimado, observacoes)
                VALUES
                (:id_cliente, :id_equipamento, :id_tecnico, :numero_os, :data_previsao,
                 :problema_relatado, :prioridade, :valor_estimado, :observacoes)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_cliente'        => $dados['id_cliente'],
            ':id_equipamento'    => $dados['id_equipamento'],
            ':id_tecnico'        => $dados['id_tecnico'],
            ':numero_os'         => uniqid('TMP'), // provisório, troca logo abaixo
            ':data_previsao'     => !empty($dados['data_previsao']) ? $dados['data_previsao'] : null,
            ':problema_relatado' => $dados['problema_relatado'],
            ':prioridade'        => $dados['prioridade'] ?? 'Normal',
            ':valor_estimado'    => !empty($dados['valor_estimado']) ? $dados['valor_estimado'] : 0,
            ':observacoes'       => $dados['observacoes'] ?? null
        ]);

        $id_os  = $this->pdo->lastInsertId();
        $numero = 'OS-' . date('Y') . '-' . str_pad($id_os, 5, '0', STR_PAD_LEFT);

        $stmt = $this->pdo->prepare("UPDATE ordens_servico SET numero_os = :numero_os WHERE id_os = :id_os");
        $stmt->execute([':numero_os' => $numero, ':id_os' => $id_os]);

        return $numero;
    }

    public function listar(): array
    {
        $sql = "SELECT o.*, c.nome AS nome_cliente, t.nome AS nome_tecnico,
                       e.tipo AS tipo_equipamento, e.marca, e.modelo
                FROM ordens_servico o
                INNER JOIN clientes c ON c.id_cliente = o.id_cliente
                INNER JOIN equipamentos e ON e.id_equipamento = o.id_equipamento
                INNER JOIN tecnicos t ON t.id_tecnico = o.id_tecnico
                ORDER BY o.data_abertura DESC";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId(int $id_os): ?array
    {
        $sql = "SELECT o.*, c.nome AS nome_cliente, t.nome AS nome_tecnico,
                       e.tipo AS tipo_equipamento, e.marca, e.modelo
                FROM ordens_servico o
                INNER JOIN clientes c ON c.id_cliente = o.id_cliente
                INNER JOIN equipamentos e ON e.id_equipamento = o.id_equipamento
                INNER JOIN tecnicos t ON t.id_tecnico = o.id_tecnico
                WHERE o.id_os = :id_os";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_os' => $id_os]);

        $os = $stmt->fetch(PDO::FETCH_ASSOC);

        return $os ?: null;
    }

    public function atualizar($id_os, $dados)
    {
        $sql = "UPDATE ordens_servico SET
                    id_tecnico = :id_tecnico,
                    data_previsao = :data_previsao,
                    data_conclusao = :data_conclusao,
                    problema_relatado = :problema_relatado,
                    diagnostico = :diagnostico,
                    servico_realizado = :servico_realizado,
                    status = :status,
                    prioridade = :prioridade,
                    valor_estimado = :valor_estimado,
                    valor_final = :valor_final,
                    forma_pagamento = :forma_pagamento,
                    observacoes = :observacoes
                WHERE id_os = :id_os";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id_tecnico'        => $dados['id_tecnico'],
            ':data_previsao'     => !empty($dados['data_previsao']) ? $dados['data_previsao'] : null,
            ':data_conclusao'    => !empty($dados['data_conclusao']) ? $dados['data_conclusao'] : null,
            ':problema_relatado' => $dados['problema_relatado'],
            ':diagnostico'       => $dados['diagnostico'] ?? null,
            ':servico_realizado' => $dados['servico_realizado'] ?? null,
            ':status'            => $dados['status'],
            ':prioridade'        => $dados['prioridade'],
            ':valor_estimado'    => !empty($dados['valor_estimado']) ? $dados['valor_estimado'] : 0,
            ':valor_final'       => !empty($dados['valor_final']) ? $dados['valor_final'] : 0,
            ':forma_pagamento'   => !empty($dados['forma_pagamento']) ? $dados['forma_pagamento'] : null,
            ':observacoes'       => $dados['observacoes'] ?? null,
            ':id_os'             => $id_os
        ]);
    }

    public function excluir($id_os)
    {
        $sql = "DELETE FROM ordens_servico WHERE id_os = :id_os";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([':id_os' => $id_os]);
    }
}