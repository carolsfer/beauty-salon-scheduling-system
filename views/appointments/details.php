<?php

$pageTitle = 'Detalhes do agendamento - Cabeleleila Leila';
$layoutContext = 'public';

require __DIR__ . '/../layouts/header.php';

$statusLabels = [
    'PENDING' => 'Pendente',
    'CONFIRMED' => 'Confirmado',
    'COMPLETED' => 'Concluído'
];

$status = $appointment['status'];
$statusLabel = $statusLabels[$status] ?? $status;

$from = $_GET['from'] ?? '';

if ($from === 'admin') {
    $backUrl = '?action=admin-appointments';
    $backLabel = 'Voltar para os agendamentos';
} elseif ($from === 'search') {
    $backUrl = '?action=search-appointments';
    $backLabel = 'Voltar para os resultados';
} else {
    $backUrl = '?action=client-area';
    $backLabel = 'Voltar para meus agendamentos';
}

?>

<main>
    <div class="container">

        <div class="page-header">
            <span>Agendamento</span>

            <h1>Detalhes do seu horário</h1>

            <p>
                Confira as informações do seu agendamento.
            </p>
        </div>

        <section class="card details-card">

            <div class="details-header">

                <div>
                    <span class="details-label">Cliente</span>

                    <h2>
                        <?= htmlspecialchars($appointment['client_name']) ?>
                    </h2>
                </div>

                <span class="status-badge status-<?= strtolower($status) ?>">
                    <?= htmlspecialchars($statusLabel) ?>
                </span>

            </div>

            <div class="details-grid">

                <div class="detail-item">

                    <span>Data</span>

                    <strong>
                        <?= date(
                            'd/m/Y',
                            strtotime(
                                $appointment['appointment_datetime']
                            )
                        ) ?>
                    </strong>

                </div>

                <div class="detail-item">

                    <span>Horário</span>

                    <strong>
                        <?= date(
                            'H:i',
                            strtotime(
                                $appointment['appointment_datetime']
                            )
                        ) ?>
                    </strong>

                </div>

            </div>

            <div class="details-services">

                <span class="details-label">
                    Serviços
                </span>

                <ul>

                    <?php foreach ($services as $service): ?>

                        <li>
                            <?= htmlspecialchars($service['name']) ?>
                        </li>

                    <?php endforeach; ?>

                </ul>

            </div>

        </section>

        <div class="details-actions">

            <?php if ($canEdit): ?>

                <a
                    href="?action=edit&id=<?= (int) $appointment['id'] ?>"
                    class="button"
                >
                    Alterar agendamento
                </a>

            <?php else: ?>

                <div class="message message-error">
                    Este agendamento não pode mais ser alterado online.
                    Para alterações com menos de dois dias de antecedência,
                    entre em contato com o salão.
                </div>

            <?php endif; ?>

            <a
                href="<?= htmlspecialchars($backUrl) ?>"
                class="back-link"
            >
                ← <?= htmlspecialchars($backLabel) ?>
            </a>

        </div>

    </div>
</main>

<?php require __DIR__ . '/../layouts/footer.php'; ?>