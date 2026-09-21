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

$oneHourFromNow = (new DateTime())
    ->modify('+1 hour')
    ->format('Y-m-d H:i:s');

$oneHourAgo = (new DateTime())
    ->modify('-1 hour')
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