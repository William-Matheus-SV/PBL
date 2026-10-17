<?php

class Usuario
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarPorEmail(string $email): ?array
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':email' => $email
        ]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        return $usuario ?: null;
    }

    public function criar(
        string $nome,
        string $email,
        string $senha,
        string $telefone,
        string $perfil,
        string $status
    ): bool {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios
                (nome, email, senha, telefone, perfil, status)
                VALUES
                (:nome, :email, :senha, :telefone, :perfil, :status)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nome'     => $nome,
            ':email'    => $email,
            ':senha'    => $senhaHash,
            ':telefone' => $telefone,
            ':perfil'   => $perfil,
            ':status'   => $status
        ]);
    }
}