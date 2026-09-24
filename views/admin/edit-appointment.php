<?php

$pageTitle = 'Alterar agendamento - Cabeleleila Leila';
$layoutContext = 'admin';

require __DIR__ . '/../layouts/header.php';

$formAction = '?action=admin-update';
$clientLabel = 'Agendamento de';
$cancelUrl = '?action=admin-appointments';

?>

<main>
    <div class="container">

        <div class="page-header">
            <span>Área da Leila</span>

            <h1>Alterar agendamento</h1>

            <p>
                Atualize os serviços, a data ou o horário
                deste atendimento.
            </p>
        </div>

        <?php require __DIR__ . '/../partials/appointment-form.php'; ?>

    </div>
</main>

<?php require __DIR__ . '/../layouts/footer.php'; ?>