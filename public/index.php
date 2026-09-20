<?php

$pdo = require __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Client.php';

$clientModel = new Client($pdo);

$name = 'Cliente Teste';
$phone = '14999999999';

$client = $clientModel->findByPhone($phone);

if (!$client) {
    $clientId = $clientModel->create($name, $phone);

    echo 'Cliente criado com ID: ' . $clientId;
} else {
    echo 'Cliente já cadastrado: ' . $client['name'];
}