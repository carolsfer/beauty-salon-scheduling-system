<?php

class Appointment
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(int $clientId, string $appointmentDatetime): int
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO appointments (client_id, appointment_datetime)
             VALUES (:client_id, :appointment_datetime)'
        );

        $statement->execute([
            'client_id' => $clientId,
            'appointment_datetime' => $appointmentDatetime
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function addService(int $appointmentId, int $serviceId): void
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO appointment_services (appointment_id, service_id)
             VALUES (:appointment_id, :service_id)'
        );

        $statement->execute([
            'appointment_id' => $appointmentId,
            'service_id' => $serviceId
        ]);
    }

    public function findServices(int $appointmentId): array
    {
        $statement = $this->pdo->prepare(
            'SELECT s.id, s.name
            FROM services s
            JOIN appointment_services aps
                ON aps.service_id = s.id
            WHERE aps.appointment_id = :appointment_id
            ORDER BY s.id'
        );

        $statement->execute([
            'appointment_id' => $appointmentId
        ]);

        return $statement->fetchAll();
    }

    public function findById(int $appointmentId): ?array
    {
        $statement = $this->pdo->prepare(
            'SELECT
                a.id,
                a.client_id,
                a.appointment_datetime,
                a.status,
                c.name AS client_name,
                c.phone AS client_phone
            FROM appointments a
            JOIN clients c ON c.id = a.client_id
            WHERE a.id = :id'
        );

        $statement->execute([
            'id' => $appointmentId
        ]);

        $appointment = $statement->fetch();

        return $appointment ?: null;
    }

    public function findByClientAndPeriod(
        int $clientId,
        string $startDate,
        string $endDate
    ): array {
        $statement = $this->pdo->prepare(
            'SELECT id, appointment_datetime, status
            FROM appointments
            WHERE client_id = :client_id
            AND appointment_datetime >= :start_date
            AND appointment_datetime <= :end_date
            ORDER BY appointment_datetime'
        );

        $statement->execute([
            'client_id' => $clientId,
            'start_date' => $startDate . ' 00:00:00',
            'end_date' => $endDate . ' 23:59:59'
        ]);

        return $statement->fetchAll();
    }
}