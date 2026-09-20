<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do agendamento - Cabeleleila Leila</title>
</head>

<body>
    <h1>Detalhes do agendamento</h1>

    <p>
        Cliente:
        <?= htmlspecialchars($appointment['client_name']) ?>
    </p>

    <p>
        Data:
        <?= date(
            'd/m/Y',
            strtotime($appointment['appointment_datetime'])
        ) ?>
    </p>

    <p>
        Horário:
        <?= date(
            'H:i',
            strtotime($appointment['appointment_datetime'])
        ) ?>
    </p>

    <p>
        Status:
        <?= htmlspecialchars($appointment['status']) ?>
    </p>

    <h2>Serviços</h2>

    <?php if (empty($services)): ?>

        <p>Nenhum serviço associado.</p>

    <?php else: ?>

        <ul>
            <?php foreach ($services as $service): ?>
                <li>
                    <?= htmlspecialchars($service['name']) ?>
                </li>
            <?php endforeach; ?>
        </ul>

    <?php endif; ?>

    <?php if ($canEdit): ?>

        <a href="?action=edit&id=<?= $appointment['id'] ?>">
            Alterar agendamento
        </a>

    <?php else: ?>

        <p>
            Este agendamento não pode mais ser alterado online.
            Entre em contato com o salão por telefone.
        </p>

    <?php endif; ?>

    <a href="?action=list">
        Voltar
    </a>
</body>
</html>