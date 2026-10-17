<?php
    class Tecnico
    {
        private PDO $pdo;

        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }

        public function criar (array $dados): bool
        {
            $sql = "INSERT INTO tecnicos (
            nome, cpf, email, telefone, especialidade, nivel, data_admissao, observacoes)
            VALUES (:nome, :cpf, :email, :telefone, :especialidade, :nivel, :data_admissao, :observacoes)";

            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute([
            ':nome'          => $dados['nome'],
            ':cpf'           => $dados['cpf'],
            ':email'         => $dados['email'],
            ':telefone'      => $dados['telefone'] ?? null,
            ':especialidade' => $dados['especialidade'] ?? null,
            ':nivel'         => $dados['nivel'] ?? null,
            ':data_admissao' => !empty($dados['data_admissao']) ? $dados['data_admissao'] : null,
            ':observacoes'   => $dados['observacoes'] ?? null
            ]);
        }

        public function listar(): array
        {
            $sql = "SELECT * FROM tecnicos ORDER BY nome";

            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function buscarPorId(int $id_tecnico): ?array
        {
            $sql = "SELECT * FROM tecnicos WHERE id_tecnico = :id_tecnico";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id_tecnico' => $id_tecnico]);

            $tecnico = $stmt->fetch(PDO::FETCH_ASSOC);

            return $tecnico ?: null;
        }

        public function buscarPorCpf(string $cpf): ?array
        {
            $sql = "SELECT * FROM tecnicos WHERE cpf = :cpf";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':cpf' => $cpf]);

            $tecnico = $stmt->fetch(PDO::FETCH_ASSOC);
            return $tecnico ?: null;
        }

        public function atualizar($id_tecnico, $dados)
        {
            $sql = "UPDATE tecnicos SET
            nome = :nome,
            cpf = :cpf,
            email = :email,
            telefone = :telefone,
            especialidade = :especialidade,
            nivel = :nivel,
            data_admissao = :data_admissao,
            status = :status,
            observacoes = :observacoes
            WHERE id_tecnico = :id_tecnico";

            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute([
            ':nome'          => $dados['nome'],
            ':cpf'           => $dados['cpf'],
            ':email'         => $dados['email'],
            ':telefone'      => $dados['telefone'] ?? null,
            ':especialidade' => $dados['especialidade'] ?? null,
            ':nivel'         => $dados['nivel'] ?? null,
            ':data_admissao' => !empty($dados['data_admissao']) ? $dados['data_admissao'] : null,
            ':status'        => $dados['status'] ?? 'Ativo',
            ':observacoes'   => $dados['observacoes'] ?? null,
            ':id_tecnico'    => $id_tecnico
            ]);
        }

        public function excluir ($id_tecnico)
        {
            $sql = "DELETE FROM tecnicos WHERE id_tecnico = :id_tecnico";
            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute([':id_tecnico'=>$id_tecnico]);
        }
    }