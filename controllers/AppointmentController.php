<?php

require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../models/Service.php';

class AppointmentController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(): void
    {
        require __DIR__ . '/../views/appointments/create.php';
    }

    public function identifyClient(): void
    {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if ($name === '' || $phone === '') {
        echo 'Nome e telefone são obrigatórios.';
        return;
    }

    $clientModel = new Client($this->pdo);

    $client = $clientModel->findByPhone($phone);

    if ($client) {
        $clientId = $client['id'];
        $clientName = $client['name'];
    } else {
        $clientId = $clientModel->create($name, $phone);
        $clientName = $name;
    }

    $serviceModel = new Service($this->pdo);

    $services = $serviceModel->findAll();

    require __DIR__ . '/../views/appointments/services.php';
}
}