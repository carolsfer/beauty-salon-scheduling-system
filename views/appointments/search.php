<?php

$pageTitle = 'Consultar agendamentos - Cabeleleila Leila';
$layoutContext = 'public';

require __DIR__ . '/../layouts/header.php';

?>

<main>
    <div class="container">

        <div class="page-header">
            <span>Seus horários</span>

            <h1>Consultar agendamentos</h1>

            <p>
                Informe seu telefone e o período que deseja consultar.
            </p>
        </div>

        <form
            method="POST"
            action="?action=search-appointments"
            class="card form-card"
        >

            <div class="form-group">
                <label for="phone">Telefone</label>

                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    autocomplete="tel"
                    placeholder="(14) 99999-9999"
                    required
                >

                <span class="form-help">
                    Use o mesmo telefone informado no agendamento.
                </span>
            </div>

            <div class="date-time-grid">

                <div class="form-group">
                    <label for="start_date">
                        Data inicial
                    </label>

                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
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

        <a href="?action=home" class="back-link">
            ← Voltar para o início
        </a>

    </div>
</main>

<?php require __DIR__ . '/../layouts/footer.php'; ?>