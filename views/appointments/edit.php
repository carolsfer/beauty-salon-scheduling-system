<?php

$pageTitle = 'Alterar agendamento - Cabeleleila Leila';
$layoutContext = 'public';

require __DIR__ . '/../layouts/header.php';

$formAction = '?action=update';
$clientLabel = 'Agendamento para';
$cancelUrl = '?action=details&id=' . (int) $appointment['id'];

?>

<main>
    <div class="container">

        <div class="page-header">
            <span>Agendamento</span>

            <h1>Alterar agendamento</h1>

            <p>
                Revise os serviços, a data ou o horário
                que deseja alterar.
            </p>
        </div>

        <?php require __DIR__ . '/../partials/appointment-form.php'; ?>

    </div>
</main>

<?php require __DIR__ . '/../layouts/footer.php'; ?>