<?php

$pageTitle = 'Escolher serviços - Cabeleleila Leila';
$layoutContext = 'public';

require __DIR__ . '/../layouts/header.php';

$selectedServices = array_map(
    'intval',
    $selectedServices ?? []
);

?>

<main>
    <div class="container">

        <div class="page-header">
            <span>Agendamento</span>

            <h1>Escolha seus serviços</h1>

            <p>
                Selecione um ou mais serviços e escolha
                quando você gostaria de vir ao salão.
            </p>
        </div>

        <form
            method="POST"
            action="?action=schedule"
            class="card form-card"
        >

            <input
                type="hidden"
                name="client_id"
                value="<?= (int) $client['id'] ?>"
            >

            <div class="client-summary">
                <span>Agendamento para</span>

                <strong>
                    <?= htmlspecialchars($client['name']) ?>
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

                        <label class="checkbox-option">

                            <input
                                type="checkbox"
                                name="services[]"
                                value="<?= $serviceId ?>"
                                <?= in_array(
                                    $serviceId,
                                    $selectedServices,
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
                        value="<?= htmlspecialchars($date ?? '') ?>"
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
                        value="<?= htmlspecialchars($time ?? '') ?>"
                        required
                    >
                </div>

            </div>

            <div class="form-actions">
                <button
                    type="submit"
                    class="button"
                >
                    Continuar
                </button>
            </div>

        </form>

        <a href="?action=create" class="back-link">
            ← Voltar
        </a>

    </div>
</main>

<?php require __DIR__ . '/../layouts/footer.php'; ?>