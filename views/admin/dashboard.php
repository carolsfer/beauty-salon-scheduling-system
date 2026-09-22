<?php

$pageTitle = 'Desempenho semanal - Cabeleleila Leila';
$layoutContext = 'admin';

require __DIR__ . '/../layouts/header.php';

?>

<main>
    <div class="container">

        <div class="admin-dashboard-header">
            <div class="page-header">
                <span>Visão geral</span>
                <h1>Desempenho semanal</h1>

                <p>
                    Acompanhe os agendamentos e serviços realizados
                    no período selecionado.
                </p>
            </div>

            <div class="card week-period">
                <span>Período analisado</span>

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
                    <h2>Resumo da semana</h2>
                </div>

                <a
                    href="?action=admin-appointments"
                    class="dashboard-link"
                >
                    Gerenciar agendamentos →
                </a>
            </div>

            <div class="dashboard-grid">

                <article class="card metric-card metric-card-primary">
                    <span class="metric-label">
                        Total de agendamentos
                    </span>

                    <strong class="metric-value">
                        <?= (int) $summary['total'] ?>
                    </strong>

                    <span class="metric-description">
                        Agendamentos registrados nesta semana
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
                        Horários confirmados
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
                    <h2>Serviços realizados</h2>
                </div>
            </div>

            <div class="card service-performance-card">

                <div class="service-performance-total">
                    <span class="metric-label">
                        Serviços concluídos
                    </span>

                    <strong class="service-performance-value">
                        <?= (int) $completedServices ?>
                    </strong>

                    <p>
                        Total de serviços realizados nos atendimentos
                        concluídos nesta semana.
                    </p>
                </div>

                <div class="service-breakdown">
                    <span class="metric-label">
                        Por serviço
                    </span>

                    <?php if (empty($completedServicesByType)): ?>

                        <p class="service-breakdown-empty">
                            Nenhum serviço concluído nesta semana.
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