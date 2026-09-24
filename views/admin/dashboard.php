<?php

$pageTitle = 'Resumo semanal - Cabeleleila Leila';
$layoutContext = 'admin';

require __DIR__ . '/../layouts/header.php';

?>

<main>
    <div class="container">

        <div class="admin-dashboard-header">
            <div class="page-header">
                <span>Área da Leila</span>
                <h1>Resumo semanal</h1>

                <p>
                    Consulte os agendamentos e serviços concluídos
                    no período selecionado.
                </p>
            </div>

            <div class="card week-period">
                <span>Período</span>

                <strong>
                    <?= $weekStart->format('d/m/Y') ?>
                    —
                    <?= $weekEnd->format('d/m/Y') ?>
                </strong>
            </div>
        </div>

        <nav class="week-navigation">
            <a
                href="?action=admin-dashboard&week=<?= $previousWeek->format('Y-m-d') ?>"
                class="button button-secondary"
            >
                ← Semana anterior
            </a>

            <a
                href="?action=admin-dashboard"
                class="dashboard-link"
            >
                Semana atual
            </a>

            <a
                href="?action=admin-dashboard&week=<?= $nextWeek->format('Y-m-d') ?>"
                class="button button-secondary"
            >
                Próxima semana →
            </a>
        </nav>

        <section class="dashboard-section">
            <div class="dashboard-section-heading">
                <div>
                    <span>Agendamentos</span>
                    <h2>Agendamentos da semana</h2>
                </div>

                <a
                    href="?action=admin-appointments"
                    class="dashboard-link"
                >
                    Ver agendamentos →
                </a>
            </div>

            <div class="dashboard-grid">

                <article class="card metric-card metric-card-primary">
                    <span class="metric-label">
                        Total
                    </span>

                    <strong class="metric-value">
                        <?= (int) $summary['total'] ?>
                    </strong>

                    <span class="metric-description">
                        Agendamentos registrados
                    </span>
                </article>

                <article class="card metric-card">
                    <span class="metric-label">
                        Pendentes
                    </span>

                    <strong class="metric-value">
                        <?= (int) $summary['pending'] ?>
                    </strong>

                    <span class="metric-description">
                        Aguardando confirmação
                    </span>
                </article>

                <article class="card metric-card">
                    <span class="metric-label">
                        Confirmados
                    </span>

                    <strong class="metric-value">
                        <?= (int) $summary['confirmed'] ?>
                    </strong>

                    <span class="metric-description">
                        Agendamentos confirmados
                    </span>
                </article>

                <article class="card metric-card">
                    <span class="metric-label">
                        Concluídos
                    </span>

                    <strong class="metric-value">
                        <?= (int) $summary['completed'] ?>
                    </strong>

                    <span class="metric-description">
                        Atendimentos finalizados
                    </span>
                </article>

            </div>
        </section>

        <section class="dashboard-section">
            <div class="dashboard-section-heading">
                <div>
                    <span>Serviços</span>
                    <h2>Serviços concluídos</h2>
                </div>
            </div>

            <div class="card service-performance-card">

                <div class="service-performance-total">
                    <span class="metric-label">
                        Total de serviços
                    </span>

                    <strong class="service-performance-value">
                        <?= (int) $completedServices ?>
                    </strong>

                    <p>
                        Serviços realizados nos atendimentos
                        concluídos durante o período.
                    </p>
                </div>

                <div class="service-breakdown">
                    <span class="metric-label">
                        Por serviço
                    </span>

                    <?php if (empty($completedServicesByType)): ?>

                        <p class="service-breakdown-empty">
                            Nenhum serviço foi concluído neste período.
                        </p>

                    <?php else: ?>

                        <ul class="service-breakdown-list">

                            <?php foreach ($completedServicesByType as $service): ?>

                                <li>
                                    <span>
                                        <?= htmlspecialchars($service['name']) ?>
                                    </span>

                                    <strong>
                                        <?= (int) $service['total'] ?>
                                    </strong>
                                </li>

                            <?php endforeach; ?>

                        </ul>

                    <?php endif; ?>

                </div>

            </div>
        </section>

    </div>
</main>

<?php require __DIR__ . '/../layouts/footer.php'; ?>