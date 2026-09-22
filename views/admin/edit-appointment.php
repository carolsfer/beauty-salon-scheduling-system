<?php

$pageTitle = 'Alterar agendamento - Cabeleleila Leila';
$layoutContext = 'admin';

require __DIR__ . '/../layouts/header.php';

$formAction = '?action=admin-update';
$clientLabel = 'Cliente';
$cancelUrl = '?action=admin-appointments';

?>

<main>
    <div class="container">

        <div class="page-header">
            <span>Área administrativa</span>

            <h1>Editar agendamento</h1>

            <p>
                Altere a data, o horário ou os serviços deste agendamento.
            </p>
        </div>

        <?php require __DIR__ . '/../partials/appointment-form.php'; ?>

        <a
            href="?action=admin-appointments"
            class="back-link"
        >
            ← Voltar para os agendamentos
        </a>

    </div>
</main>

<?php require __DIR__ . '/../layouts/footer.php'; ?>