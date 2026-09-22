<?php

$pageTitle = 'Escolher serviços - Cabeleleila Leila';
$layoutContext = 'public';

require __DIR__ . '/../layouts/header.php';

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

            <div class="form-group">
                <span class="form-label">
                    Serviços
                </span>

                <div class="checkbox-list">

                    <?php foreach ($services as $service): ?>

                        <label class="checkbox-option">

                            <input
                                type="checkbox"
                                name="services[]"
                                value="<?= (int) $service['id'] ?>"
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