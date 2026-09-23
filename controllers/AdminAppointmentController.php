<?php

require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../models/Service.php';

class AdminAppointmentController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function list(): void
    {
        $this->requireAdmin();

        $appointmentModel = new Appointment($this->pdo);

        $appointments = $appointmentModel->findAll();

        require __DIR__ . '/../views/admin/appointments.php';
    }

    public function edit(): void
    {
        $this->requireAdmin();

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

        $serviceModel = new Service($this->pdo);
        $services = $serviceModel->findAll();

        $appointmentServices = $appointmentModel->findServices(
            $appointmentId
        );

        $selectedServiceIds = array_map(
            'intval',
            array_column($appointmentServices, 'id')
        );

        require __DIR__ . '/../views/admin/edit-appointment.php';
    }

    public function update(): void
    {
        $this->requireAdmin();

        $appointmentId = (int) ($_POST['appointment_id'] ?? 0);

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

            require __DIR__ . '/../views/admin/edit-appointment.php';
            return;
        }

        if ($date === '' || $time === '') {
            $formError = 'Data e horário são obrigatórios.';

            require __DIR__ . '/../views/admin/edit-appointment.php';
            return;
        }

        if (!$appointmentModel->isValidDatetime($date, $time)) {
            $formError = 'Data ou horário inválido.';

            require __DIR__ . '/../views/admin/edit-appointment.php';
            return;
        }

        $appointmentDatetime = $date . ' ' . $time . ':00';

        if (!$appointmentModel->isDatetimeInFuture(
            $appointmentDatetime
        )) {
            $formError =
                'A data e o horário do agendamento devem ser futuros.';

            require __DIR__ . '/../views/admin/edit-appointment.php';
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

            header('Location: ?action=admin-appointments');
            exit;
        } catch (Throwable $exception) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            echo 'Não foi possível alterar o agendamento.';
        }
    }

    public function updateStatuses(): void
    {
        $this->requireAdmin();

        $statuses = $_POST['statuses'] ?? [];

        if (empty($statuses)) {
            echo 'Nenhum status recebido.';
            return;
        }

        $appointmentModel = new Appointment($this->pdo);

        try {
            $this->pdo->beginTransaction();

            foreach ($statuses as $appointmentId => $status) {
                $appointmentId = (int) $appointmentId;

                if (
                    $appointmentId <= 0 ||
                    !in_array(
                        $status,
                        Appointment::ALLOWED_STATUSES,
                        true
                    )
                ) {
                    throw new Exception('Status inválido.');
                }

                $appointment = $appointmentModel->findById(
                    $appointmentId
                );

                if (!$appointment) {
                    throw new Exception('Agendamento inválido.');
                }

                $appointmentModel->updateStatus(
                    $appointmentId,
                    $status
                );
            }

            $this->pdo->commit();

            header('Location: ?action=admin-appointments');
            exit;
        } catch (Throwable $exception) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            echo 'Não foi possível atualizar os status.';
        }
    }

    public function dashboard(): void
    {
        $this->requireAdmin();

        $week = trim($_GET['week'] ?? '');

        if ($week !== '') {
            $referenceDate = DateTime::createFromFormat(
                '!Y-m-d',
                $week
            );

            if (
                !$referenceDate ||
                $referenceDate->format('Y-m-d') !== $week
            ) {
                $referenceDate = new DateTime();
            }
        } else {
            $referenceDate = new DateTime();
        }

        $weekStart = (clone $referenceDate)
            ->modify('monday this week')
            ->setTime(0, 0, 0);

        $weekEnd = (clone $weekStart)
            ->modify('+6 days')
            ->setTime(23, 59, 59);

        $previousWeek = (clone $weekStart)
            ->modify('-7 days');

        $nextWeek = (clone $weekStart)
            ->modify('+7 days');

        $appointmentModel = new Appointment($this->pdo);

        $weekStartFormatted = $weekStart->format(
            'Y-m-d H:i:s'
        );

        $weekEndFormatted = $weekEnd->format(
            'Y-m-d H:i:s'
        );

        $summary = $appointmentModel->getWeeklySummary(
            $weekStartFormatted,
            $weekEndFormatted
        );

        $completedServices = $appointmentModel
            ->getCompletedServicesCount(
                $weekStartFormatted,
                $weekEndFormatted
            );

        $completedServicesByType = $appointmentModel
            ->getCompletedServicesByType(
                $weekStartFormatted,
                $weekEndFormatted
            );

        require __DIR__ . '/../views/admin/dashboard.php';
    }

    private function requireAdmin(): void
    {
        if (empty($_SESSION['admin_logged_in'])) {
            header('Location: ?action=admin-login');
            exit;
        }
    }
}