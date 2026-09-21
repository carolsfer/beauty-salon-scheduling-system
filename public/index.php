<?php

session_start();

date_default_timezone_set('America/Sao_Paulo');

$pdo = require __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../controllers/AppointmentController.php';

$action = $_GET['action'] ?? 'home';

require_once __DIR__ . '/../controllers/AdminController.php';

$adminController = new AdminController();

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
        
    case 'confirm-schedule':
        $appointmentController->confirmSchedule();
        break;

    case 'list':
        $appointmentController->search();
        break;

    case 'search-appointments':
        $appointmentController->searchAppointments();
        break;
    
    case 'details':
        $appointmentController->details();
        break;
    
    case 'edit':
        $appointmentController->edit();
        break;

    case 'update':
        $appointmentController->update();
        break;

    case 'admin-login':
        $adminController->login();
        break;

    case 'admin-authenticate':
        $adminController->authenticate();
        break;

    case 'admin-logout':
        $adminController->logout();
        break;
    
    case 'admin-appointments':
        $appointmentController->adminList();
        break;

    case 'admin-edit':
        $appointmentController->adminEdit();
        break;

    case 'admin-update':
        $appointmentController->adminUpdate();
        break;

    case 'home':
    default:
        require __DIR__ . '/../views/home.php';
        break;
}