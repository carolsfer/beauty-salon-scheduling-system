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

        <span class="form-help">
            Selecione pelo menos um serviço.
        </span>
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
                    strtotime($appointment['appointment_datetime'])
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
                    strtotime($appointment['appointment_datetime'])
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