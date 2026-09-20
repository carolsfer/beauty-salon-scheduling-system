<?php

$pdo = require __DIR__ . '/../config/database.php';

$query = $pdo->query('SELECT id, name FROM services');

$services = $query->fetchAll();

foreach ($services as $service) {
    echo $service['name'] . '<br>';
}