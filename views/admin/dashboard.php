<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Desempenho semanal - Área da Leila</title>
</head>

<body>

    <h1>Desempenho semanal</h1>

    <p>
        <?= $weekStart->format('d/m/Y') ?>
        a
        <?= $weekEnd->format('d/m/Y') ?>
    </p>

    <h2>Agendamentos</h2>

    <p>
        Total:
        <strong><?= (int) $summary['total'] ?></strong>
    </p>

    <p>
        Pendentes:
        <strong><?= (int) $summary['pending'] ?></strong>
    </p>

    <p>
        Confirmados:
        <strong><?= (int) $summary['confirmed'] ?></strong>
    </p>

    <p>
        Concluídos:
        <strong><?= (int) $summary['completed'] ?></strong>
    </p>

    <h2>Serviços realizados</h2>

    <p>
        <strong><?= $completedServices ?></strong>
    </p>

    <p>
        <a href="?action=admin-appointments">
            Ver agendamentos
        </a>
    </p>

    <p>
        <a href="?action=admin-logout">
            Sair
        </a>
    </p>

</body>
</html>