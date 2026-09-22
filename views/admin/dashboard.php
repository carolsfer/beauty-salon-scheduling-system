<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Desempenho semanal | Área da Leila</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header class="site-header">
    <div class="container header-content">
        <a href="?action=admin-appointments" class="logo">
            Área da Leila
        </a>

        <nav class="navigation">
            <a href="?action=admin-appointments">Agendamentos</a>
            <a href="?action=admin-dashboard">Desempenho semanal</a>
            <a href="?action=admin-logout">Sair</a>
        </nav>
    </div>
</header>

<main>
    <div class="container">

        <div class="admin-dashboard-header">
            <div class="page-header">
                <span>Visão geral</span>
                <h1>Desempenho semanal</h1>

                <p>
                    Acompanhe os agendamentos e serviços realizados
                    nesta semana.
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
                <div>
                    <span class="metric-label">
                        Serviços concluídos
                    </span>

                    <strong class="service-performance-value">
                        <?= (int) $completedServices ?>
                    </strong>
                </div>

                <p>
                    Total de serviços realizados nos atendimentos
                    concluídos nesta semana.
                </p>
            </div>
        </section>

    </div>
</main>

<footer class="site-footer">
    <div class="container">
        Cabeleleila Leila — Área administrativa
    </div>
</footer>

</body>
</html>