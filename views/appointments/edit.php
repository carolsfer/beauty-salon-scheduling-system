<?php

$pageTitle = 'Alterar agendamento - Cabeleleila Leila';
$layoutContext = 'public';

require __DIR__ . '/../layouts/header.php';

?>

<main>
    <div class="container">

        <div class="page-header">
            <span>Agendamento</span>

            <h1>Alterar seu horário</h1>

            <p>
                Atualize os serviços, a data ou o horário
                do seu agendamento.
            </p>
        </div>

        <form
            method="POST"
            action="?action=update"
            class="card form-card"
        >

            <input
                type="hidden"
                name="appointment_id"
                value="<?= (int) $appointment['id'] ?>"
            >

            <div class="client-summary">
                <span>Agendamento para</span>

                <strong>
                    <?= htmlspecialchars($appointment['client_name']) ?>
                </strong>
            </div>

            <?php
            $selectedServiceIds = array_column(
                $selectedServices,
                'id'
            );
            ?>

            <div class="form-group">
                <span class="form-label">
                    Serviços
                </span>

                <div class="checkbox-list">

                    <?php foreach ($services as $service): ?>

                        <label
                            class="checkbox-option"
                            for="service-<?= (int) $service['id'] ?>"
                        >

                            <input
                                type="checkbox"
                                id="service-<?= (int) $service['id'] ?>"
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
            </div>

            <div class="date-time-grid">

                <div class="form-group">
                    <label for="date">
                        Data
                    </label>

                    <input
                        type="date"
                        id="date"
                        name="date"
                        min="<?= date('Y-m-d') ?>"
                        value="<?= date(
                            'Y-m-d',
                            strtotime(
                                $appointment['appointment_datetime']
                            )
                        ) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="time">
                        Horário
                    </label>

                    <input
                        type="time"
                        id="time"
                        name="time"
                        value="<?= date(
                            'H:i',
                            strtotime(
                                $appointment['appointment_datetime']
                            )
                        ) ?>"
                        required
                    >
                </div>

            </div>

            <div class="form-actions">
                <button
                    type="submit"
                    class="button"
                >
                    Salvar alterações
                </button>
            </div>

        </form>

        <a
            href="?action=details&id=<?= (int) $appointment['id'] ?>"
            class="back-link"
        >
            ← Cancelar alterações
        </a>

    </div>
</main>

<?php require __DIR__ . '/../layouts/footer.php'; ?>