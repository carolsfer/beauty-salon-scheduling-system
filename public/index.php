<?php

session_start();

date_default_timezone_set('America/Sao_Paulo');

$pdo = require __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/AppointmentController.php';
require_once __DIR__ . '/../controllers/AdminAppointmentController.php';

$authController = new AuthController();
$appointmentController = new AppointmentController($pdo);
$adminAppointmentController = new AdminAppointmentController($pdo);

$action = $_GET['action'] ?? 'home';

switch ($action) {

    // Public appointments

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


    // Admin authentication

    case 'admin-login':
        $authController->login();
        break;

    case 'admin-authenticate':
        $authController->authenticate();
        break;

    case 'admin-logout':
        $authController->logout();
        break;


    // Admin appointments

    case 'admin-appointments':
        $adminAppointmentController->list();
        break;

    case 'admin-edit':
        $adminAppointmentController->edit();
        break;

    case 'admin-update':
        $adminAppointmentController->update();
        break;

    case 'admin-update-statuses':
        $adminAppointmentController->updateStatuses();
        break;

    case 'admin-dashboard':
        $adminAppointmentController->dashboard();
        break;


    // Home

    case 'home':
    default:
        require __DIR__ . '/../views/home.php';
        break;
}