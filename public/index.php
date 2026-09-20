<?php

$pdo = require __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../controllers/AppointmentController.php';

$action = $_GET['action'] ?? 'home';

$appointmentController = new AppointmentController($pdo);

switch ($action) {
    case 'create':
        $appointmentController->create();
        break;

    case 'identify-client':
        $appointmentController->identifyClient();
        break;

    case 'schedule':
        $appointmentController->schedule();
        break;
        
    case 'home':
    default:
        require __DIR__ . '/../views/home.php';
        break;
}