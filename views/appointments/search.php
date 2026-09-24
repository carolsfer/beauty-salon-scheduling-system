<?php

$pageTitle = 'Consultar agendamentos - Cabeleleila Leila';
$layoutContext = 'public';

require __DIR__ . '/../layouts/header.php';

?>

<main>
    <div class="container">

        <div class="page-header">
            <span>Área do Cliente</span>

            <h1>Consultar por período</h1>

            <p>
                Defina uma data inicial e final para localizar
                seus agendamentos nesse intervalo.
            </p>
        </div>

        <form
            method="POST"
            action="?action=search-appointments"
            class="card form-card"
        >

            <?php if (!empty($periodError)): ?>

                <div class="message message-error">
                    <?= htmlspecialchars($periodError) ?>
                </div>

            <?php endif; ?>

            <div class="date-time-grid">

                <div class="form-group">
                    <label for="start_date">
                        Data inicial
                    </label>

                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
                        value="<?= htmlspecialchars($startDate ?? '') ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="end_date">
                        Data final
                    </label>

                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        value="<?= htmlspecialchars($endDate ?? '') ?>"
                        required
                    >
                </div>

            </div>

            <div class="form-actions">

                <button type="submit" class="button">
                    Buscar agendamentos
                </button>

            </div>

        </form>

        <a href="?action=client-area" class="back-link">
            ← Voltar para a Área do Cliente
        </a>

    </div>
</main>

<?php require __DIR__ . '/../layouts/footer.php'; ?>