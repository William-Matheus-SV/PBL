<?php
    class Cliente
    {
        private PDO $pdo;

        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }

        public function buscarPorEmail (string $email): ?array
        {
            $sql = "SELECT * FROM clientes WHERE email = :email";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':email' => $email
            ]);

            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

            return $cliente ?: null;
        }
        
        public function criar( array $dados): bool 
        {

            $sql = "INSERT INTO clientes
                    (cpf_cnpj, nome, email, telefone, telefone_secundario,
                logradouro, numero, bairro, cidade, estado, cep)
                VALUES
                (:cpf_cnpj, :nome, :email, :telefone, :telefone_secundario,
                :logradouro, :numero, :bairro, :cidade, :estado, :cep)";

            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute([
            ':cpf_cnpj'            => $dados['cpf_cnpj'],
            ':nome'                => $dados['nome'],
            ':email'               => $dados['email'],
            ':telefone'            => $dados['telefone'] ?? null,
            ':telefone_secundario' => $dados['telefone_secundario'] ?? null,
            ':logradouro'          => $dados['logradouro'] ?? null,
            ':numero'              => $dados['numero'] ?? null,
            ':bairro'              => $dados['bairro'] ?? null,
            ':cidade'              => $dados['cidade'] ?? null,
            ':estado'              => $dados['estado'] ?? null,
            ':cep'                 => $dados['cep'] ?? null
            ]);
        }

        public function listar(): array
        {
            $sql = "SELECT * FROM clientes ORDER BY nome";

            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function buscarPorId(int $id_cliente) :?array
        {
            $sql = "SELECT * FROM clientes WHERE id_cliente = :id_cliente";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id_cliente'=> $id_cliente]);

            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

            return $cliente ?: null;
        }

        public function buscarPorCpfCnpj(string $cpf_cnpj): ?array
        {
            $sql = "SELECT * FROM clientes WHERE cpf_cnpj = :cpf_cnpj";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':cpf_cnpj' => $cpf_cnpj]);

            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

            return $cliente ?: null;
        }

        public function atualizar($id_cliente, $dados)
        {
            $sql = "UPDATE clientes SET
                cpf_cnpj = :cpf_cnpj,
                nome = :nome,
                email = :email,
                telefone = :telefone,
                telefone_secundario = :telefone_secundario,
                logradouro = :logradouro,
                numero = :numero,
                bairro = :bairro,
                cidade = :cidade,
                estado = :estado,
                cep = :cep

            WHERE id_cliente = :id_cliente";

            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute([
                ':cpf_cnpj'            => $dados['cpf_cnpj'],
                ':nome'                => $dados['nome'],
                ':email'               => $dados['email'],
                ':telefone'            => $dados['telefone'] ?? null,
                ':telefone_secundario' => $dados['telefone_secundario'] ?? null,
                ':logradouro'          => $dados['logradouro'] ?? null,
                ':numero'              => $dados['numero'] ?? null,
                ':bairro'              => $dados['bairro'] ?? null,
                ':cidade'              => $dados['cidade'] ?? null,
                ':estado'              => $dados['estado'] ?? null,
                ':cep'                 => $dados['cep'] ?? null,
                ':id_cliente'          => $id_cliente
            ]);
        }

        //Desafio Pesquisa de clientes por Nome, CPF/CNPJ ou e-mail. 
        public function excluir($id_cliente)
        {
            $sql = "DELETE FROM clientes WHERE id_cliente = :id_cliente";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([':id_cliente'=>$id_cliente]);
        }

        public function buscar(string $termo): array
        {
        $sql = "SELECT * FROM clientes
                WHERE nome LIKE :busca_nome
                OR REPLACE(REPLACE(REPLACE(cpf_cnpj, '.', ''), '-', ''), '/', '') LIKE :busca_doc
                OR email LIKE :busca_email
                ORDER BY nome";

        $like = '%' . $termo . '%';

        // Se parecer um CPF/CNPJ vai compara somente os dígitos
        $doc = preg_match('/^[\d.\-\/\s]+$/', $termo)
            ? '%' . preg_replace('/\D/', '', $termo) . '%'
            : $like;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':busca_nome'  => $like,
            ':busca_doc'   => $doc,
            ':busca_email' => $like
        ]);

         return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }       
}
