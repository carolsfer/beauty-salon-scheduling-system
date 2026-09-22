<?php

$pageTitle = 'Alterar agendamento - Cabeleleila Leila';
$layoutContext = 'admin';

require __DIR__ . '/../layouts/header.php';

?>

<main>
    <div class="container">

        <div class="page-header">
            <span>Área administrativa</span>
            <h1>Editar agendamento</h1>
            <p>
                Altere a data, o horário ou os serviços deste agendamento.
            </p>
        </div>

        <form
            method="POST"
            action="?action=admin-update"
            class="card form-card"
        >
            <input
                type="hidden"
                name="appointment_id"
                value="<?= (int) $appointment['id'] ?>"
            >

            <div class="client-summary">
                <span>Cliente</span>

                <strong>
                    <?= htmlspecialchars($appointment['client_name']) ?>
                </strong>
            </div>

            <div class="date-time-grid">
                <div class="form-group">
                    <label for="date">Data</label>

                    <input
                        type="date"
                        id="date"
                        name="date"
                        value="<?= date(
                            'Y-m-d',
                            strtotime($appointment['appointment_datetime'])
                        ) ?>"
                        min="<?= date('Y-m-d') ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="time">Horário</label>

                    <input
                        type="time"
                        id="time"
                        name="time"
                        value="<?= date(
                            'H:i',
                            strtotime($appointment['appointment_datetime'])
                        ) ?>"
                        required
                    >
                </div>
            </div>

            <div class="form-group">
                <span class="form-label">Serviços</span>

                <div class="checkbox-list">
                    <?php foreach ($services as $service): ?>

                        <label class="checkbox-option">
                            <input
                                type="checkbox"
                                name="services[]"
                                value="<?= (int) $service['id'] ?>"
                                <?= in_array(
                                    $service['id'],
                                    $selectedServiceIds
                                ) ? 'checked' : '' ?>
                            >

                            <span>
                                <?= htmlspecialchars($service['name']) ?>
                            </span>
                        </label>

                    <?php endforeach; ?>
                </div>

                <span class="form-help">
                    Selecione pelo menos um serviço.
                </span>
            </div>

            <div class="form-actions">
                <button type="submit" class="button">
                    Salvar alterações
                </button>

                <a
                    href="?action=admin-appointments"
                    class="button button-secondary"
                >
                    Cancelar
                </a>
            </div>
        </form>

        <a href="?action=admin-appointments" class="back-link">
            ← Voltar para os agendamentos
        </a>

    </div>
</main>

<?php require __DIR__ . '/../layouts/footer.php'; ?>