<?php
    class Equipamento
    {
        private PDO $pdo;

        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }

        public function criar(array $dados): bool
        {
            $sql = "INSERT INTO equipamentos
            (id_cliente, tipo, marca, modelo, numero_serie, patrimonio, descricao, sistema_operacional, senha_acesso)
            VALUES
            (:id_cliente, :tipo, :marca, :modelo, :numero_serie, :patrimonio, :descricao, :sistema_operacional, :senha_acesso)";

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([ 
                ':id_cliente'          => $dados['id_cliente'],
                ':tipo'                => $dados['tipo'],
                ':marca'               => $dados['marca'],
                ':modelo'              => $dados['modelo'],
                ':numero_serie'        => $dados['numero_serie'],
                ':patrimonio'          => $dados['patrimonio'],
                ':descricao'           => $dados['descricao'],
                ':sistema_operacional' => $dados['sistema_operacional'],
                ':senha_acesso'        => $dados['senha_acesso']
            ]);
        }
        // Lista geral: traz o nome do dono. A senha_acesso fica de fora de propósito.
        public function listar(): array
        {
            $sql = "SELECT e.id_equipamento, e.id_cliente, e.tipo, e.marca, e.modelo,
                    e.numero_serie, e.patrimonio, e.sistema_operacional,
                    c.nome AS nome_cliente
                    FROM equipamentos e
                    INNER JOIN clientes c ON c.id_cliente = e.id_cliente
                    ORDER BY e.tipo";

            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //Listar por ID aqui a senha_acesso é necessária
        public function buscarPorId (int $id_equipamento) :? array
        {
            $sql = "SELECT e.*, c.nome AS nome_cliente
                    FROM equipamentos e
                    INNER JOIN clientes c ON c.id_cliente = e.id_cliente
                    WHERE e.id_equipamento = :id_equipamento";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id_equipamento'=> $id_equipamento]);

            $equipamento = $stmt->fetch(PDO::FETCH_ASSOC);
            return $equipamento ?: null;
        }

        //Esse é usado na tela Ver do Cliente
        public function listarPorCliente()
        {
            $sql = "SELECT id_equipamento, id_cliente, tipo, marca, modelo,
                    numero_serie, patrimonio, sistema_operacional
                    FROM equipamentos
                    WHERE id_cliente = :id_cliente
                    ORDER BY tipo";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id_cliente' => $id_cliente]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        }

        public function atualizar($id_equipamento, $dados)
        {
            $sql = "UPDATE equipamentos SET
                tipo= :tipo,
                marca = :marca,
                modelo  = :modelo,
                numero_serie  = :numero_serie,
                patrimonio = :patrimonio,
                descricao = :descricao,
                sistema_operacional = :sistema_operacional,
                senha_acesso = :senha_acesso

                WHERE id_equipamento = :id_equipamento";

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':tipo'                => $dados['tipo'],
                ':marca'               => $dados['marca'] ?? null,
                ':modelo'              => $dados['modelo'] ?? null,
                ':numero_serie'        => $dados['numero_serie'] ?? null,
                ':patrimonio'          => $dados['patrimonio'] ?? null,
                ':descricao'           => $dados['descricao'] ?? null,
                ':sistema_operacional' => $dados['sistema_operacional'] ?? null,
                ':senha_acesso'        => $dados['senha_acesso'] ?? null,
                ':id_equipamento'      => $dados['id_equipamento']

            ]);
        }

        public function excluir(int $id_equipamento): bool
        {
            $sql= "DELETE FROM equipamentos WHERE id_equipamento = :id_equipamento";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['id_equipamento'=>$id_equipamento]);
        }
}