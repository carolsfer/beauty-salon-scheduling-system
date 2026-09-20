<?php

require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../models/Appointment.php';

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
    
    public function schedule(): void
    {
        $clientId = (int) ($_POST['client_id'] ?? 0);
        $services = $_POST['services'] ?? [];
        $date = trim($_POST['date'] ?? '');
        $time = trim($_POST['time'] ?? '');

        if ($clientId <= 0) {
            echo 'Cliente inválido.';
            return;
        }

        if (empty($services)) {
            echo 'Selecione pelo menos um serviço.';
            return;
        }

        if ($date === '' || $time === '') {
            echo 'Data e horário são obrigatórios.';
            return;
        }

        $appointmentDatetime = $date . ' ' . $time . ':00';

        $appointmentModel = new Appointment($this->pdo);

        try {
            $this->pdo->beginTransaction();

            $appointmentId = $appointmentModel->create(
                $clientId,
                $appointmentDatetime
            );

            foreach ($services as $serviceId) {
                $appointmentModel->addService(
                    $appointmentId,
                    (int) $serviceId
                );
            }

            $this->pdo->commit();

            echo 'Agendamento criado com sucesso. ID: ' . $appointmentId;
        } catch (Throwable $exception) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            echo 'Não foi possível criar o agendamento.';
        }
    }
}