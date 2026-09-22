<?php

date_default_timezone_set('America/Sao_Paulo');

$pdo = require __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../models/Appointment.php';

$appointmentModel = new Appointment($pdo);

function checkTest(
    string $description,
    bool $condition
): void {
    if ($condition) {
        echo "[PASS] $description" . PHP_EOL;
    } else {
        echo "[FAIL] $description" . PHP_EOL;
    }
}

echo PHP_EOL;
echo "=== Appointment Tests ===" . PHP_EOL;
echo PHP_EOL;

// Client editing rule

$today = new DateTime('today');

$threeDaysFromNow = (clone $today)
    ->modify('+3 days')
    ->format('Y-m-d H:i:s');

$tomorrow = (clone $today)
    ->modify('+1 day')
    ->format('Y-m-d H:i:s');

$twoDaysFromNow = (clone $today)
    ->modify('+2 days')
    ->format('Y-m-d H:i:s');

checkTest(
    'Appointment more than 2 days away can be edited',
    $appointmentModel->canBeEditedByClient($threeDaysFromNow)
);

checkTest(
    'Appointment less than 2 days away cannot be edited',
    !$appointmentModel->canBeEditedByClient($tomorrow)
);

checkTest(
    'Appointment exactly 2 days away can be edited',
    $appointmentModel->canBeEditedByClient($twoDaysFromNow)
);

// Datetime validation

$oneHourFromNow = (new DateTime())
    ->modify('+1 hour')
    ->format('Y-m-d H:i:s');

$oneHourAgo = (new DateTime())
    ->modify('-1 hour')
    ->format('Y-m-d H:i:s');

checkTest(
    'Future datetime is accepted',
    $appointmentModel->isDatetimeInFuture($oneHourFromNow)
);

checkTest(
    'Past datetime is rejected',
    !$appointmentModel->isDatetimeInFuture($oneHourAgo)
);

checkTest(
    'Valid date and time format is accepted',
    $appointmentModel->isValidDatetime(
        '2026-10-15',
        '14:30'
    )
);

checkTest(
    'Invalid date is rejected',
    !$appointmentModel->isValidDatetime(
        '2026-02-30',
        '14:30'
    )
);

checkTest(
    'Invalid time is rejected',
    !$appointmentModel->isValidDatetime(
        '2026-10-15',
        '25:30'
    )
);

// Appointment statuses

checkTest(
    'PENDING is an allowed status',
    in_array(
        Appointment::STATUS_PENDING,
        Appointment::ALLOWED_STATUSES,
        true
    )
);

checkTest(
    'CONFIRMED is an allowed status',
    in_array(
        Appointment::STATUS_CONFIRMED,
        Appointment::ALLOWED_STATUSES,
        true
    )
);

checkTest(
    'COMPLETED is an allowed status',
    in_array(
        Appointment::STATUS_COMPLETED,
        Appointment::ALLOWED_STATUSES,
        true
    )
);

checkTest(
    'Unknown status is rejected',
    !in_array(
        'CANCELLED',
        Appointment::ALLOWED_STATUSES,
        true
    )
);

// Same-week suggestion

try {
    $pdo->beginTransaction();

    $phone = '99' . substr((string) time(), -9);

    $statement = $pdo->prepare(
        'INSERT INTO clients (name, phone)
         VALUES (:name, :phone)'
    );

    $statement->execute([
        'name' => 'Test Client',
        'phone' => $phone
    ]);

    $clientId = (int) $pdo->lastInsertId();

    $nextMonday = (new DateTime('monday next week'))
        ->setTime(10, 0, 0);

    $sameWeekAppointment = (clone $nextMonday)
        ->modify('+1 day')
        ->setTime(14, 0, 0);

    $requestedDate = (clone $nextMonday)
        ->modify('+3 days')
        ->setTime(16, 0, 0);

    $sameWeekAppointmentId = $appointmentModel->create(
        $clientId,
        $sameWeekAppointment->format('Y-m-d H:i:s')
    );

    $foundAppointment = $appointmentModel->findInSameWeek(
        $clientId,
        $requestedDate->format('Y-m-d H:i:s')
    );

    checkTest(
        'Appointment in the same week is found',
        $foundAppointment !== null
        && (int) $foundAppointment['id'] === $sameWeekAppointmentId
    );

    $deleteStatement = $pdo->prepare(
        'DELETE FROM appointments
         WHERE id = :id'
    );

    $deleteStatement->execute([
        'id' => $sameWeekAppointmentId
    ]);

    $differentWeekAppointment = (clone $nextMonday)
        ->modify('+8 days')
        ->setTime(14, 0, 0);

    $appointmentModel->create(
        $clientId,
        $differentWeekAppointment->format('Y-m-d H:i:s')
    );

    $foundAppointment = $appointmentModel->findInSameWeek(
        $clientId,
        $requestedDate->format('Y-m-d H:i:s')
    );

    checkTest(
        'Appointment in a different week is not suggested',
        $foundAppointment === null
    );

    $deleteStatement = $pdo->prepare(
        'DELETE FROM appointments
         WHERE client_id = :client_id'
    );

    $deleteStatement->execute([
        'client_id' => $clientId
    ]);

    $pastAppointment = new DateTime('today 00:01:00');

    $appointmentModel->create(
        $clientId,
        $pastAppointment->format('Y-m-d H:i:s')
    );

    $todayRequest = new DateTime('today 23:59:59');

    $foundAppointment = $appointmentModel->findInSameWeek(
        $clientId,
        $todayRequest->format('Y-m-d H:i:s')
    );

    checkTest(
        'Past appointment in the same week is not suggested',
        $foundAppointment === null
    );

    $pdo->rollBack();
} catch (Throwable $exception) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    checkTest(
        'Same-week database tests completed successfully',
        false
    );

    echo 'Reason: ' . $exception->getMessage() . PHP_EOL;
}