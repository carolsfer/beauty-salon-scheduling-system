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

    public function removeServices(int $appointmentId): void
    {
        $statement = $this->pdo->prepare(
            'DELETE FROM appointment_services
            WHERE appointment_id = :appointment_id'
        );

        $statement->execute([
            'appointment_id' => $appointmentId
        ]);
    }

    public function update(
        int $appointmentId,
        string $appointmentDatetime
    ): void {
        $statement = $this->pdo->prepare(
            'UPDATE appointments
            SET appointment_datetime = :appointment_datetime
            WHERE id = :id'
        );

        $statement->execute([
            'appointment_datetime' => $appointmentDatetime,
            'id' => $appointmentId
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

    public function findAll(): array
    {
        $statement = $this->pdo->query(
            'SELECT
                a.id,
                a.appointment_datetime,
                a.status,
                c.name AS client_name,
                c.phone AS client_phone
            FROM appointments a
            JOIN clients c ON c.id = a.client_id
            ORDER BY a.appointment_datetime'
        );

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

    public function canBeEditedByClient(string $appointmentDatetime): bool
    {
        $appointmentDate = new DateTime($appointmentDatetime);
        $today = new DateTime('today');

        $limitDate = (clone $appointmentDate)
            ->setTime(0, 0)
            ->modify('-2 days');

        return $today <= $limitDate;
    }

    public function findInSameWeek(
        int $clientId,
        string $appointmentDatetime
    ): ?array {
        $date = new DateTime($appointmentDatetime);

        $weekStart = (clone $date)
            ->modify('monday this week')
            ->setTime(0, 0, 0);

        $weekEnd = (clone $date)
            ->modify('sunday this week')
            ->setTime(23, 59, 59);

        $statement = $this->pdo->prepare(
            'SELECT id, appointment_datetime, status
            FROM appointments
            WHERE client_id = :client_id
            AND appointment_datetime BETWEEN :week_start AND :week_end
            AND appointment_datetime > NOW()
            ORDER BY appointment_datetime
            LIMIT 1'
        );

        $statement->execute([
            'client_id' => $clientId,
            'week_start' => $weekStart->format('Y-m-d H:i:s'),
            'week_end' => $weekEnd->format('Y-m-d H:i:s')
        ]);

        $appointment = $statement->fetch();

        return $appointment ?: null;
    }

    public function isDatetimeInFuture(string $appointmentDatetime): bool
    {
        $appointmentDate = new DateTime($appointmentDatetime);
        $now = new DateTime();

        return $appointmentDate > $now;
    }

    public function isValidDatetime(
        string $date,
        string $time
    ): bool {
        $datetime = DateTime::createFromFormat(
            'Y-m-d H:i',
            $date . ' ' . $time
        );

        return $datetime !== false
            && $datetime->format('Y-m-d H:i') === $date . ' ' . $time;
    }

    public function hasService(
        int $appointmentId,
        int $serviceId
    ): bool {
        $statement = $this->pdo->prepare(
            'SELECT 1
            FROM appointment_services
            WHERE appointment_id = :appointment_id
            AND service_id = :service_id'
        );

        $statement->execute([
            'appointment_id' => $appointmentId,
            'service_id' => $serviceId
        ]);

        return (bool) $statement->fetch();
    }
}