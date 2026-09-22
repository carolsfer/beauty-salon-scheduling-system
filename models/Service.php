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

    public function exists(int $serviceId): bool
    {
        $statement = $this->pdo->prepare(
            'SELECT 1
            FROM services
            WHERE id = :id'
        );

        $statement->execute([
            'id' => $serviceId
        ]);

        return (bool) $statement->fetchColumn();
    }

    public function validateIds(array $serviceIds): ?array
    {
        if (empty($serviceIds)) {
            return null;
        }

        $serviceIds = array_unique(
            array_map('intval', $serviceIds)
        );

        foreach ($serviceIds as $serviceId) {
            if ($serviceId <= 0 || !$this->exists($serviceId)) {
                return null;
            }
        }

        return $serviceIds;
    }
}