<?php

require_once __DIR__ . '/../models/Appointment.php';
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
        $client = $this->getSessionClient();

        if ($client) {
            $serviceModel = new Service($this->pdo);
            $services = $serviceModel->findAll();

            require __DIR__ . '/../views/appointments/services.php';
            return;
        }

        require __DIR__ . '/../views/appointments/create.php';
    }

    public function clientArea(): void
    {
        $client = $this->getSessionClient();

        if (!$client) {
            require __DIR__ . '/../views/client/access.php';
            return;
        }

        $appointmentModel = new Appointment($this->pdo);

        $appointments = $appointmentModel->findByClient(
            (int) $client['id']
        );

        require __DIR__ . '/../views/client/area.php';
    }

    public function identifyClientArea(): void
    {
        $phone = trim($_POST['phone'] ?? '');
        $phoneError = '';

        if ($phone === '') {
            $phoneError = 'Informe seu telefone.';

            require __DIR__ . '/../views/client/access.php';
            return;
        }

        $clientModel = new Client($this->pdo);

        $normalizedPhone = $clientModel->normalizePhone($phone);

        if (
            strlen($normalizedPhone) < 10 ||
            strlen($normalizedPhone) > 11
        ) {
            $phoneError = 'Informe um telefone válido com DDD.';

            require __DIR__ . '/../views/client/access.php';
            return;
        }

        $client = $clientModel->findByPhone($normalizedPhone);

        if (!$client) {
            $phoneError =
                'Nenhum cadastro foi encontrado com este telefone.';

            require __DIR__ . '/../views/client/access.php';
            return;
        }

        $_SESSION['client_id'] = (int) $client['id'];

        header('Location: ?action=client-area');
        exit;
    }

    public function clientLogout(): void
    {
        unset(
            $_SESSION['client_id'],
            $_SESSION['appointment_search']
        );

        header('Location: ?action=client-area');
        exit;
    }

    public function identifyClient(): void
    {
        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        if ($name === '' || $phone === '') {
            $formError = 'Preencha seu nome e telefone para continuar.';;

            require __DIR__ . '/../views/appointments/create.php';
            return;
        }

        $clientModel = new Client($this->pdo);

        $normalizedPhone = $clientModel->normalizePhone($phone);

        if (
            strlen($normalizedPhone) < 10 ||
            strlen($normalizedPhone) > 11
        ) {
            $phoneError = 'Informe um telefone válido com DDD.';

            require __DIR__ . '/../views/appointments/create.php';
            return;
        }

        $client = $clientModel->findByPhone($normalizedPhone);

        if ($client) {
            $clientId = (int) $client['id'];
        } else {
            $clientId = $clientModel->create(
                $name,
                $normalizedPhone
            );

            $client = $clientModel->findById($clientId);
        }

        if (!$client) {
            echo 'Não foi possível identificar o cliente.';
            return;
        }

        $_SESSION['client_id'] = (int) $client['id'];

        $serviceModel = new Service($this->pdo);
        $services = $serviceModel->findAll();

        require __DIR__ . '/../views/appointments/services.php';
    }

    public function schedule(): void
    {
        $client = $this->getSessionClient();

        if (!$client) {
            header('Location: ?action=client-area');
            exit;
        }

        $clientId = (int) $client['id'];
        $selectedServices = $_POST['services'] ?? [];
        $date = trim($_POST['date'] ?? '');
        $time = trim($_POST['time'] ?? '');

        $serviceModel = new Service($this->pdo);
        $services = $serviceModel->findAll();

        if (empty($selectedServices)) {
            $formError = 'Selecione pelo menos um serviço.';

            require __DIR__ . '/../views/appointments/services.php';
            return;
        }

        if ($date === '' || $time === '') {
            $formError = 'Informe a data e o horário do agendamento.';

            require __DIR__ . '/../views/appointments/services.php';
            return;
        }

        $appointmentModel = new Appointment($this->pdo);

        if (!$appointmentModel->isValidDatetime($date, $time)) {
            $formError = 'Informe uma data e um horário válidos.';

            require __DIR__ . '/../views/appointments/services.php';
            return;
        }

        $appointmentDatetime = $date . ' ' . $time . ':00';

        if (!$appointmentModel->isDatetimeInFuture(
            $appointmentDatetime
        )) {
            $formError =
                'Escolha uma data e um horário futuros.';

            require __DIR__ . '/../views/appointments/services.php';
            return;
        }

        $selectedServices = $serviceModel->validateIds(
            $selectedServices
        );

        if ($selectedServices === null) {
            echo 'Um dos serviços selecionados é inválido.';
            return;
        }

        $sameWeekAppointment = $appointmentModel->findInSameWeek(
            $clientId,
            $appointmentDatetime
        );

        if ($sameWeekAppointment) {
            $_SESSION['pending_appointment'] = [
                'client_id' => $clientId,
                'services' => $selectedServices,
                'appointment_datetime' => $appointmentDatetime,
                'same_week_appointment_id' =>
                    (int) $sameWeekAppointment['id']
            ];

            $appointment = $sameWeekAppointment;

            require __DIR__
                . '/../views/appointments/same-week-suggestion.php';
            return;
        }

        try {
            $this->pdo->beginTransaction();

            $appointmentId = $appointmentModel->create(
                $clientId,
                $appointmentDatetime
            );

            foreach ($selectedServices as $serviceId) {
                $appointmentModel->addService(
                    $appointmentId,
                    $serviceId
                );
            }

            $this->pdo->commit();

            header(
                'Location: ?action=details&id='
                . $appointmentId
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
        $pendingAppointment =
            $_SESSION['pending_appointment'] ?? null;

        if (!$pendingAppointment) {
            echo 'Dados do agendamento não encontrados.';
            return;
        }

        $clientId = (int) $pendingAppointment['client_id'];

        if (!$this->isCurrentClient($clientId)) {
            echo 'Cliente inválido.';
            return;
        }

        $selectedServices = $pendingAppointment['services'];
        $appointmentDatetime =
            $pendingAppointment['appointment_datetime'];

        $useExistingAppointment =
            ($_POST['use_existing_appointment'] ?? '') === '1';

        $appointmentModel = new Appointment($this->pdo);

        try {
            $this->pdo->beginTransaction();

            if ($useExistingAppointment) {
                $appointmentId = (int)
                    $pendingAppointment['same_week_appointment_id'];

                $appointment =
                    $appointmentModel->findById($appointmentId);

                if (
                    !$appointment ||
                    (int) $appointment['client_id'] !== $clientId
                ) {
                    throw new Exception(
                        'Agendamento existente inválido.'
                    );
                }

                foreach ($selectedServices as $serviceId) {
                    if (
                        !$appointmentModel->hasService(
                            $appointmentId,
                            $serviceId
                        )
                    ) {
                        $appointmentModel->addService(
                            $appointmentId,
                            $serviceId
                        );
                    }
                }
            } else {
                $appointmentId = $appointmentModel->create(
                    $clientId,
                    $appointmentDatetime
                );

                foreach ($selectedServices as $serviceId) {
                    $appointmentModel->addService(
                        $appointmentId,
                        $serviceId
                    );
                }
            }

            $this->pdo->commit();

            unset($_SESSION['pending_appointment']);

            header(
                'Location: ?action=details&id='
                . $appointmentId
            );
            exit;
        } catch (Throwable $exception) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            echo 'Não foi possível criar o agendamento.';
        }
    }

    public function search(): void
    {
        $client = $this->getSessionClient();

        if (!$client) {
            header('Location: ?action=client-area');
            exit;
        }

        $startDate =
            $_SESSION['appointment_search']['start_date'] ?? '';

        $endDate =
            $_SESSION['appointment_search']['end_date'] ?? '';

        require __DIR__ . '/../views/appointments/search.php';
    }

    public function searchAppointments(): void
    {
        $client = $this->getSessionClient();

        if (!$client) {
            header('Location: ?action=client-area');
            exit;
        }

        $startDate = trim(
            $_POST['start_date']
                ?? $_SESSION['appointment_search']['start_date']
                ?? ''
        );

        $endDate = trim(
            $_POST['end_date']
                ?? $_SESSION['appointment_search']['end_date']
                ?? ''
        );

        if ($startDate === '' || $endDate === '') {
            $periodError = 'Informe o período da consulta.';

            require __DIR__ . '/../views/appointments/search.php';
            return;
        }

        if ($startDate > $endDate) {
            $periodError =
                'A data inicial não pode ser posterior à data final.';

            require __DIR__ . '/../views/appointments/search.php';
            return;
        }

        $_SESSION['appointment_search'] = [
            'start_date' => $startDate,
            'end_date' => $endDate
        ];

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
        $from = trim($_GET['from'] ?? '');

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

        $isAdmin =
            $from === 'admin'
            && !empty($_SESSION['admin_logged_in']);

        if (
            !$isAdmin &&
            !$this->canAccessAppointment($appointment)
        ) {
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

    public function edit(): void
    {
        $appointmentId = (int) ($_GET['id'] ?? 0);

        if ($appointmentId <= 0) {
            echo 'Agendamento inválido.';
            return;
        }

        $appointmentModel = new Appointment($this->pdo);
        $appointment = $appointmentModel->findById($appointmentId);

        if (
            !$appointment ||
            !$this->canAccessAppointment($appointment)
        ) {
            echo 'Agendamento não encontrado.';
            return;
        }

        if (
            !$appointmentModel->canBeEditedByClient(
                $appointment['appointment_datetime']
            )
        ) {
            header(
                'Location: ?action=details&id='
                . $appointmentId
            );
            exit;
        }

        $serviceModel = new Service($this->pdo);
        $services = $serviceModel->findAll();

        $appointmentServices = $appointmentModel->findServices(
            $appointmentId
        );

        $selectedServiceIds = array_map(
            'intval',
            array_column($appointmentServices, 'id')
        );

        require __DIR__ . '/../views/appointments/edit.php';
    }

    public function update(): void
    {
        $appointmentId = (int) ($_POST['appointment_id'] ?? 0);

        if ($appointmentId <= 0) {
            echo 'Agendamento inválido.';
            return;
        }

        $appointmentModel = new Appointment($this->pdo);
        $appointment = $appointmentModel->findById($appointmentId);

        if (
            !$appointment ||
            !$this->canAccessAppointment($appointment)
        ) {
            echo 'Agendamento não encontrado.';
            return;
        }

        if (
            !$appointmentModel->canBeEditedByClient(
                $appointment['appointment_datetime']
            )
        ) {
            header(
                'Location: ?action=details&id='
                . $appointmentId
            );
            exit;
        }

        $selectedServices = $_POST['services'] ?? [];
        $date = trim($_POST['date'] ?? '');
        $time = trim($_POST['time'] ?? '');

        $serviceModel = new Service($this->pdo);
        $services = $serviceModel->findAll();

        $selectedServiceIds = array_map(
            'intval',
            $selectedServices
        );

        if (empty($selectedServices)) {
            $formError = 'Selecione pelo menos um serviço.';

            require __DIR__ . '/../views/appointments/edit.php';
            return;
        }

        if ($date === '' || $time === '') {
            $formError = 'Informe a data e o horário do agendamento.';

            require __DIR__ . '/../views/appointments/edit.php';
            return;
        }

        if (!$appointmentModel->isValidDatetime($date, $time)) {
            $formError = 'Informe uma data e um horário válidos.';

            require __DIR__ . '/../views/appointments/edit.php';
            return;
        }

        $appointmentDatetime = $date . ' ' . $time . ':00';

        if (!$appointmentModel->isDatetimeInFuture(
            $appointmentDatetime
        )) {
            $formError =
                'Escolha uma data e um horário futuros.';

            require __DIR__ . '/../views/appointments/edit.php';
            return;
        }

        $validatedServices = $serviceModel->validateIds(
            $selectedServices
        );

        if ($validatedServices === null) {
            echo 'Um dos serviços selecionados é inválido.';
            return;
        }

        try {
            $this->pdo->beginTransaction();

            $appointmentModel->update(
                $appointmentId,
                $appointmentDatetime
            );

            $appointmentModel->removeServices($appointmentId);

            foreach ($validatedServices as $serviceId) {
                $appointmentModel->addService(
                    $appointmentId,
                    $serviceId
                );
            }

            $this->pdo->commit();

            header(
                'Location: ?action=details&id='
                . $appointmentId
            );
            exit;
        } catch (Throwable $exception) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            echo 'Não foi possível alterar o agendamento.';
        }
    }

    private function getSessionClient(): ?array
    {
        $clientId = (int) ($_SESSION['client_id'] ?? 0);

        if ($clientId <= 0) {
            return null;
        }

        $clientModel = new Client($this->pdo);

        return $clientModel->findById($clientId);
    }

    private function isCurrentClient(int $clientId): bool
    {
        $client = $this->getSessionClient();

        return $client
            && (int) $client['id'] === $clientId;
    }

    private function canAccessAppointment(
        array $appointment
    ): bool {
        return $this->isCurrentClient(
            (int) $appointment['client_id']
        );
    }
}