<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Agendamentos - Área da Leila</title>
</head>
<body>

    <h1>Agendamentos recebidos</h1>

    <p>
        <a href="?action=home">Voltar para o início</a>
    </p>

    <?php if (empty($appointments)): ?>

        <p>Nenhum agendamento encontrado.</p>

    <?php else: ?>

        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Cliente</th>
                    <th>Telefone</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td>
                            <?= date(
                                'd/m/Y',
                                strtotime($appointment['appointment_datetime'])
                            ) ?>
                        </td>

                        <td>
                            <?= date(
                                'H:i',
                                strtotime($appointment['appointment_datetime'])
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($appointment['client_name']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($appointment['client_phone']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($appointment['status']) ?>
                        </td>

                        <td>
                            <a href="?action=details&id=<?= (int) $appointment['id'] ?>">
                                Ver
                            </a>
                            <a href="?action=admin-edit&id=<?= (int) $appointment['id'] ?>">
                                Editar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>
    <p>
        <a href="?action=admin-logout">
            Sair
        </a>
    </p>

</body>
</html>