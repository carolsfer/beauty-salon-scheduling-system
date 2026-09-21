<?php

class Client
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function findByPhone(string $phone): ?array
    {
        $statement = $this->pdo->prepare(
            'SELECT id, name, phone FROM clients WHERE phone = :phone'
        );

        $statement->execute([
            'phone' => $phone
        ]);

        $client = $statement->fetch();

        return $client ?: null;
    }

    public function normalizePhone(string $phone): string
    {
        return preg_replace('/\D/', '', $phone);
    }
    
    public function create(string $name, string $phone): int
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO clients (name, phone) VALUES (:name, :phone)'
        );

        $statement->execute([
            'name' => $name,
            'phone' => $phone
        ]);

        return (int) $this->pdo->lastInsertId();
    }
}