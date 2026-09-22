<?php

$pageTitle = 'Alterar agendamento - Cabeleleila Leila';
$layoutContext = 'public';

require __DIR__ . '/../layouts/header.php';

$selectedServiceIds = array_column(
    $selectedServices,
    'id'
);

$formAction = '?action=update';
$clientLabel = 'Agendamento para';
$cancelUrl = '?action=details&id=' . (int) $appointment['id'];

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

        <?php require __DIR__ . '/../partials/appointment-form.php'; ?>

    </div>
</main>

<?php require __DIR__ . '/../layouts/footer.php'; ?>