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

        $phone = $clientModel->normalizePhone($phone);

        if (strlen($phone) < 10 || strlen($phone) > 11) {
            echo 'Informe um telefone válido com DDD.';
            return;
        }

        $client = $clientModel->findByPhone($phone);

        if ($client) {
            $clientId = (int) $client['id'];
        } else {
            $clientId = $clientModel->create($name, $phone);
            $client = $clientModel->findById($clientId);
        }

        if (!$client) {
            echo 'Não foi possível identificar o cliente.';
            return;
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

        $clientModel = new Client($this->pdo);

        if (!$clientModel->findById($clientId)) {
            echo 'Cliente inválido.';
            return;
        }

        if (empty($services)) {
            echo 'Selecione pelo menos um serviço.';
            return;
        }

        $services = array_unique(array_map('intval', $services));

        $serviceModel = new Service($this->pdo);

        foreach ($services as $serviceId) {
            if ($serviceId <= 0 || !$serviceModel->exists($serviceId)) {
                echo 'Um dos serviços selecionados é inválido.';
                return;
            }
        }

        if ($date === '' || $time === '') {
            echo 'Data e horário são obrigatórios.';
            return;
        }

        $appointmentModel = new Appointment($this->pdo);

        if (!$appointmentModel->isValidDatetime($date, $time)) {
            echo 'Data ou horário inválido.';
            return;
        }

        $appointmentDatetime = $date . ' ' . $time . ':00';

        if (!$appointmentModel->isDatetimeInFuture($appointmentDatetime)) {
            echo 'A data e o horário do agendamento devem ser futuros.';
            return;
        }

        $existingAppointment = $appointmentModel->findInSameWeek(
            $clientId,
            $appointmentDatetime
        );

        if ($existingAppointment) {
            require __DIR__ . '/../views/appointments/same-week-suggestion.php';
            return;
        }

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

            header(
                'Location: ?action=details&id=' . $appointmentId
            );

            exit;
        } catch (Throwable $exception) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            echo 'Não foi possível criar o agendamento.';
        }
    }

    public function confirmSchedule(): void
    {
        $clientId = (int) ($_POST['client_id'] ?? 0);
        $services = $_POST['services'] ?? [];
        $date = trim($_POST['date'] ?? '');
        $time = trim($_POST['time'] ?? '');

        $existingAppointmentId = (int) (
            $_POST['existing_appointment_id'] ?? 0
        );

        $choice = $_POST['choice'] ?? '';

        if (
            $clientId <= 0 ||
            empty($services) ||
            $date === '' ||
            $time === ''
        ) {
            echo 'Dados do agendamento inválidos.';
            return;
        }

        $clientModel = new Client($this->pdo);

        if (!$clientModel->findById($clientId)) {
            echo 'Cliente inválido.';
            return;
        }

        $services = array_unique(array_map('intval', $services));

        $serviceModel = new Service($this->pdo);

        foreach ($services as $serviceId) {
            if ($serviceId <= 0 || !$serviceModel->exists($serviceId)) {
                echo 'Um dos serviços selecionados é inválido.';
                return;
            }
        }

        $appointmentModel = new Appointment($this->pdo);

        try {
            $this->pdo->beginTransaction();

            if ($choice === 'same-date') {
                if ($existingAppointmentId <= 0) {
                    throw new Exception(
                        'Agendamento existente inválido.'
                    );
                }

                $existingAppointment = $appointmentModel->findById(
                    $existingAppointmentId
                );

                if (
                    !$existingAppointment ||
                    (int) $existingAppointment['client_id'] !== $clientId
                ) {
                    throw new Exception(
                        'Agendamento existente inválido.'
                    );
                }

                foreach ($services as $serviceId) {
                    if (
                        !$appointmentModel->hasService(
                            $existingAppointmentId,
                            $serviceId
                        )
                    ) {
                        $appointmentModel->addService(
                            $existingAppointmentId,
                            $serviceId
                        );
                    }
                }

                $appointmentId = $existingAppointmentId;
            } elseif ($choice === 'keep-date') {
                $appointmentDatetime = $date . ' ' . $time . ':00';

                if (
                    !$appointmentModel->isDatetimeInFuture(
                        $appointmentDatetime
                    )
                ) {
                    throw new Exception(
                        'Data e horário inválidos.'
                    );
                }

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
            } else {
                throw new Exception('Opção inválida.');
            }

            $this->pdo->commit();

            header(
                'Location: ?action=details&id=' . $appointmentId
            );

            exit;
        } catch (Throwable $exception) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            echo 'Não foi possível criar o agendamento.';
        }
    }

    public function edit(): void
    {
        $appointmentId = (int) ($_GET['id'] ?? 0);

        if ($appointmentId <= 0) {
            echo 'Agendamento inválido.';
            return;
        }

        $appointmentModel = new Appointment($this->pdo);
        $appointment = $appointmentModel->findById($appointmentId);

        if (!$appointment) {
            echo 'Agendamento não encontrado.';
            return;
        }

        if (
            !$appointmentModel->canBeEditedByClient(
                $appointment['appointment_datetime']
            )
        ) {
            echo 'Este agendamento não pode mais ser alterado online. Entre em contato com o salão por telefone.';
            return;
        }

        $selectedServices = $appointmentModel->findServices(
            $appointmentId
        );

        $serviceModel = new Service($this->pdo);
        $services = $serviceModel->findAll();

        require __DIR__ . '/../views/appointments/edit.php';
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

        $phone = $clientModel->normalizePhone($phone);

        if (strlen($phone) < 10 || strlen($phone) > 11) {
            echo 'Informe um telefone válido com DDD.';
            return;
        }

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

    public function details(): void
    {
        $appointmentId = (int) ($_GET['id'] ?? 0);

        if ($appointmentId <= 0) {
            echo 'Agendamento inválido.';
            return;
        }

        $appointmentModel = new Appointment($this->pdo);

        $appointment = $appointmentModel->findById($appointmentId);

        if (!$appointment) {
            echo 'Agendamento não encontrado.';
            return;
        }

        $services = $appointmentModel->findServices(
            $appointmentId
        );

        $canEdit = $appointmentModel->canBeEditedByClient(
            $appointment['appointment_datetime']
        );

        require __DIR__ . '/../views/appointments/details.php';
    }

    public function update(): void
    {
        $appointmentId = (int) ($_POST['appointment_id'] ?? 0);
        $services = $_POST['services'] ?? [];
        $date = trim($_POST['date'] ?? '');
        $time = trim($_POST['time'] ?? '');

        if ($appointmentId <= 0) {
            echo 'Agendamento inválido.';
            return;
        }

        if (empty($services)) {
            echo 'Selecione pelo menos um serviço.';
            return;
        }

        $services = array_unique(array_map('intval', $services));

        $serviceModel = new Service($this->pdo);

        foreach ($services as $serviceId) {
            if ($serviceId <= 0 || !$serviceModel->exists($serviceId)) {
                echo 'Um dos serviços selecionados é inválido.';
                return;
            }
        }

        if ($date === '' || $time === '') {
            echo 'Data e horário são obrigatórios.';
            return;
        }

        $appointmentModel = new Appointment($this->pdo);

        if (!$appointmentModel->isValidDatetime($date, $time)) {
            echo 'Data ou horário inválido.';
            return;
        }

        $appointmentDatetime = $date . ' ' . $time . ':00';

        if (!$appointmentModel->isDatetimeInFuture($appointmentDatetime)) {
            echo 'A data e o horário do agendamento devem ser futuros.';
            return;
        }

        $appointment = $appointmentModel->findById($appointmentId);

        if (!$appointment) {
            echo 'Agendamento não encontrado.';
            return;
        }

        if (
            !$appointmentModel->canBeEditedByClient(
                $appointment['appointment_datetime']
            )
        ) {
            echo 'Este agendamento não pode mais ser alterado online. Entre em contato com o salão por telefone.';
            return;
        }

        try {
            $this->pdo->beginTransaction();

            $appointmentModel->update(
                $appointmentId,
                $appointmentDatetime
            );

            $appointmentModel->removeServices($appointmentId);

            foreach ($services as $serviceId) {
                $appointmentModel->addService(
                    $appointmentId,
                    (int) $serviceId
                );
            }

            $this->pdo->commit();

            header(
                'Location: ?action=details&id=' . $appointmentId
            );

            exit;
        } catch (Throwable $exception) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            echo 'Não foi possível alterar o agendamento.';
        }
    }
}