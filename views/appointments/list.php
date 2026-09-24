<?php

$pageTitle = 'Resultado da consulta - Cabeleleila Leila';
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
            <span>Consulta por período</span>

            <h1>
                <?= empty($appointments)
                    ? 'Consulta de agendamentos'
                    : 'Agendamentos encontrados' ?>
            </h1>

            <?php if (!empty($startDate) && !empty($endDate)): ?>

                <p>
                    Período consultado:
                    <?= date('d/m/Y', strtotime($startDate)) ?>
                    a
                    <?= date('d/m/Y', strtotime($endDate)) ?>.
                </p>

            <?php endif; ?>
        </div>

        <?php if (empty($appointments)): ?>

            <div class="card empty-state">

                <h2>Nenhum agendamento neste período</h2>

                <p>
                    Não há agendamentos entre as datas informadas.
                    Altere o período para fazer uma nova busca.
                </p>

                <div class="form-actions">

                    <a
                        href="?action=list"
                        class="button"
                    >
                        Alterar período
                    </a>

                </div>

            </div>

        <?php else: ?>

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

                            <span
                                class="status-badge status-<?= strtolower($status) ?>"
                            >
                                <?= htmlspecialchars($statusLabel) ?>
                            </span>

                        </div>

                        <div class="appointment-actions">

                            <a
                                href="?action=details&id=<?= (int) $appointment['id'] ?>&from=search"
                                class="button button-secondary"
                            >
                                Ver detalhes
                            </a>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

            <div class="form-actions">

                <a
                    href="?action=list"
                    class="button button-secondary"
                >
                    Alterar período
                </a>

            </div>

        <?php endif; ?>

        <a href="?action=client-area" class="back-link">
            ← Voltar para a Área do Cliente
        </a>

    </div>
</main>

<?php require __DIR__ . '/../layouts/footer.php'; ?>