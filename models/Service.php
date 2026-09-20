<?php

class Service
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $statement = $this->pdo->query(
            'SELECT id, name FROM services ORDER BY id'
        );

        return $statement->fetchAll();
    }
}