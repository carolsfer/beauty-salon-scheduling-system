<?php

$pdo = require __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../models/Service.php';

$serviceModel = new Service($pdo);

function checkServiceTest(
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
echo "=== Service Tests ===" . PHP_EOL;
echo PHP_EOL;

$services = $serviceModel->findAll();

if (empty($services)) {
    echo "[FAIL] Service tests require at least one registered service."
        . PHP_EOL;

    exit(1);
}

$firstServiceId = (int) $services[0]['id'];

$secondServiceId = isset($services[1])
    ? (int) $services[1]['id']
    : $firstServiceId;

// Valid service IDs

$validatedServices = $serviceModel->validateIds([
    $firstServiceId,
    $secondServiceId
]);

checkServiceTest(
    'Valid service IDs are accepted',
    $validatedServices !== null
);

// Duplicate IDs

$validatedServices = $serviceModel->validateIds([
    $firstServiceId,
    $firstServiceId
]);

checkServiceTest(
    'Duplicate service IDs are removed',
    $validatedServices !== null
    && count($validatedServices) === 1
);

// Invalid service IDs

$statement = $pdo->query(
    'SELECT COALESCE(MAX(id), 0) + 1000
     FROM services'
);

$invalidServiceId = (int) $statement->fetchColumn();

$validatedServices = $serviceModel->validateIds([
    $firstServiceId,
    $invalidServiceId
]);

checkServiceTest(
    'Nonexistent service ID is rejected',
    $validatedServices === null
);

$validatedServices = $serviceModel->validateIds([0]);

checkServiceTest(
    'Invalid service ID value is rejected',
    $validatedServices === null
);

$validatedServices = $serviceModel->validateIds([]);

checkServiceTest(
    'Empty service selection is rejected',
    $validatedServices === null
);