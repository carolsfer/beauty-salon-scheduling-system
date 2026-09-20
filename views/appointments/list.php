<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Meus agendamentos - Cabeleleila Leila</title>
</head>

<body>
    <h1>Meus agendamentos</h1>

    <p>
        Cliente: <?= htmlspecialchars($client['name']) ?>
    </p>

    <?php if (empty($appointments)): ?>

        <p>Nenhum agendamento encontrado no período informado.</p>

    <?php else: ?>

        <?php foreach ($appointments as $appointment): ?>

            <div>
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

                <a href="?action=details&id=<?= $appointment['id'] ?>">
                    Ver detalhes
                </a>

                <hr>
            </div>

        <?php endforeach; ?>

    <?php endif; ?>

    <a href="?action=list">Nova consulta</a>

    <a href="./">Início</a>
</body>
</html>