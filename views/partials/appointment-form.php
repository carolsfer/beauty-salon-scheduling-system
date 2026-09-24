<?php

$selectedServiceIds = array_map(
    'intval',
    $selectedServiceIds ?? []
);

$submittedDate = $date
    ?? date(
        'Y-m-d',
        strtotime($appointment['appointment_datetime'])
    );

$submittedTime = $time
    ?? date(
        'H:i',
        strtotime($appointment['appointment_datetime'])
    );

?>

<form
    method="POST"
    action="<?= htmlspecialchars($formAction) ?>"
    class="card form-card"
>
    <input
        type="hidden"
        name="appointment_id"
        value="<?= (int) $appointment['id'] ?>"
    >

    <div class="client-summary">
        <span><?= htmlspecialchars($clientLabel) ?></span>

        <strong>
            <?= htmlspecialchars($appointment['client_name']) ?>
        </strong>
    </div>

    <?php if (!empty($formError)): ?>

        <div class="message message-error">
            <?= htmlspecialchars($formError) ?>
        </div>

    <?php endif; ?>

    <div class="form-group">
        <span class="form-label">
            Serviços
        </span>

        <div class="checkbox-list">

            <?php foreach ($services as $service): ?>

                <?php
                $serviceId = (int) $service['id'];
                ?>

                <label
                    class="checkbox-option"
                    for="service-<?= $serviceId ?>"
                >
                    <input
                        type="checkbox"
                        id="service-<?= $serviceId ?>"
                        name="services[]"
                        value="<?= $serviceId ?>"
                        <?= in_array(
                            $serviceId,
                            $selectedServiceIds,
                            true
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
                value="<?= htmlspecialchars($submittedDate) ?>"
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
                value="<?= htmlspecialchars($submittedTime) ?>"
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

        <?php if (!empty($cancelUrl)): ?>

            <a
                href="<?= htmlspecialchars($cancelUrl) ?>"
                class="button button-secondary"
            >
                Cancelar
            </a>

        <?php endif; ?>
    </div>
</form>