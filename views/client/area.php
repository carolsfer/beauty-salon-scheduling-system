<?php

$pageTitle = 'Área do Cliente - Cabeleleila Leila';
$layoutContext = 'public';

require __DIR__ . '/../layouts/header.php';

$statusLabels = [
    'PENDING' => 'Pendente',
    'CONFIRMED' => 'Confirmado',
    'COMPLETED' => 'Concluído'
];

?>

<main>
    <div class="container">

        <div class="page-header">
            <span>Área do Cliente</span>

            <h1>
                Olá, <?= htmlspecialchars($client['name']) ?>
            </h1>

            <p>
                Acompanhe seus agendamentos e consulte
                os detalhes de cada atendimento.
            </p>
        </div>

        <div class="actions">

            <a href="?action=create" class="button">
                Novo agendamento
            </a>

            <a
                href="?action=list"
                class="button button-secondary"
            >
                Consultar período
            </a>

            <a
                href="?action=client-logout"
                class="button button-secondary"
            >
                Sair
            </a>

        </div>

        <?php if (empty($appointments)): ?>

            <div class="card empty-state">
                <h2>Nenhum agendamento por enquanto</h2>

                <p>
                    Seus próximos atendimentos e agendamentos
                    anteriores serão exibidos aqui.
                </p>

                <div class="form-actions">
                    <a href="?action=create" class="button">
                        Novo agendamento
                    </a>
                </div>
            </div>

        <?php else: ?>

            <div class="section-heading client-area-heading">
                <span>Histórico</span>
                <h2>Seus agendamentos</h2>
            </div>

            <div class="appointment-list">

                <?php foreach ($appointments as $appointment): ?>

                    <?php
                    $status = $appointment['status'];
                    $statusLabel = $statusLabels[$status] ?? $status;
                    ?>

                    <article class="card appointment-card">

                        <div class="appointment-date">

                            <span>
                                <?= date(
                                    'd/m/Y',
                                    strtotime(
                                        $appointment['appointment_datetime']
                                    )
                                ) ?>
                            </span>

                            <strong>
                                <?= date(
                                    'H:i',
                                    strtotime(
                                        $appointment['appointment_datetime']
                                    )
                                ) ?>
                            </strong>

                        </div>

                        <div class="appointment-info">

                            <span class="status-badge status-<?= strtolower($status) ?>">
                                <?= htmlspecialchars($statusLabel) ?>
                            </span>

                        </div>

                        <div class="appointment-actions">

                            <a
                                href="?action=details&id=<?= (int) $appointment['id'] ?>"
                                class="button button-secondary"
                            >
                                Ver detalhes
                            </a>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>
</main>

<?php require __DIR__ . '/../layouts/footer.php'; ?>