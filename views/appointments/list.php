<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Seus agendamentos - Cabeleleila Leila</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header class="site-header">
    <div class="container header-content">

        <a href="?action=home" class="logo">
            Cabeleleila Leila
        </a>

        <nav class="navigation">
            <a href="?action=home">Início</a>
            <a href="?action=create">Agendar</a>
            <a href="?action=list">Consultar agendamentos</a>
            <a href="?action=admin-login">Área da Leila</a>
        </nav>

    </div>
</header>

<main>
    <div class="container">

        <div class="page-header">
            <span>Seus horários</span>

            <h1>Agendamentos encontrados</h1>

            <p>
                Confira os horários encontrados para o período informado.
            </p>
        </div>

        <?php if (empty($appointments)): ?>

            <div class="card empty-state">
                <h2>Nenhum agendamento encontrado</h2>

                <p>
                    Não encontramos agendamentos para esse telefone
                    no período informado.
                </p>

                <div class="form-actions">
                    <a href="?action=list" class="button">
                        Fazer outra consulta
                    </a>

                    <a href="?action=create"
                       class="button button-secondary">
                        Agendar horário
                    </a>
                </div>
            </div>

        <?php else: ?>

            <div class="appointment-list">

                <?php foreach ($appointments as $appointment): ?>

                    <?php
                    $statusLabels = [
                        'PENDING' => 'Pendente',
                        'CONFIRMED' => 'Confirmado',
                        'COMPLETED' => 'Concluído'
                    ];

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

        <a href="?action=list" class="back-link">
            ← Fazer outra consulta
        </a>

    </div>
</main>

<footer class="site-footer">
    <div class="container">
        Cabeleleila Leila — Salão de Beleza
    </div>
</footer>

</body>

</html>