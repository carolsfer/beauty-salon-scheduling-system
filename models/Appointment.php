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
}