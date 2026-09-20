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

    public function search(): void
    {
        require __DIR__ . '/../views/appointments/search.php';
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
    public function searchAppointments(): void
    {
        $phone = trim($_POST['phone'] ?? '');
        $startDate = trim($_POST['start_date'] ?? '');
        $endDate = trim($_POST['end_date'] ?? '');

        if ($phone === '' || $startDate === '' || $endDate === '') {
            echo 'Preencha todos os campos.';
            return;
        }

        if ($startDate > $endDate) {
            echo 'A data inicial não pode ser posterior à data final.';
            return;
        }

        $clientModel = new Client($this->pdo);

        $client = $clientModel->findByPhone($phone);

        if (!$client) {
            echo 'Cliente não encontrado.';
            return;
        }

        $appointmentModel = new Appointment($this->pdo);

        $appointments = $appointmentModel->findByClientAndPeriod(
            (int) $client['id'],
            $startDate,
            $endDate
        );

        require __DIR__ . '/../views/appointments/list.php';
    }
}