<?php

$pageTitle = 'Sugestão de agendamento - Cabeleleila Leila';
$layoutContext = 'public';

require __DIR__ . '/../layouts/header.php';

?>

<main>
    <div class="container">

        <div class="page-header">
            <span>Sugestão de agendamento</span>

            <h1>Você já tem um horário nesta semana</h1>

            <p>
                Encontramos outro agendamento seu nesta semana.
                Se preferir, você pode incluir os novos serviços
                nessa mesma visita.
            </p>
        </div>

        <div class="card suggestion-card">

            <div class="existing-appointment">
                <span>Agendamento existente</span>

                <strong>
                    <?= date(
                        'd/m/Y',
                        strtotime(
                            $appointment['appointment_datetime']
                        )
                    ) ?>

                    às

                    <?= date(
                        'H:i',
                        strtotime(
                            $appointment['appointment_datetime']
                        )
                    ) ?>
                </strong>
            </div>

            <p class="suggestion-text">
                Escolha se deseja adicionar os serviços ao
                agendamento existente ou manter o novo
                agendamento na data selecionada.
            </p>

            <form
                method="POST"
                action="?action=confirm-schedule"
            >

                <div class="suggestion-actions">

                    <button
                        type="submit"
                        name="use_existing_appointment"
                        value="1"
                        class="button"
                    >
                        Adicionar ao agendamento existente
                    </button>

                    <button
                        type="submit"
                        name="use_existing_appointment"
                        value="0"
                        class="button button-secondary"
                    >
                        Manter novo agendamento
                    </button>

                </div>

            </form>

        </div>

        <a href="?action=create" class="back-link">
            ← Voltar
        </a>

    </div>
</main>

<?php require __DIR__ . '/../layouts/footer.php'; ?>