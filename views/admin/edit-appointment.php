<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar agendamento - Área da Leila</title>
</head>
<body>

    <h1>Editar agendamento</h1>

    <p>
        Cliente:
        <strong>
            <?= htmlspecialchars($appointment['client_name']) ?>
        </strong>
    </p>

    <form method="POST" action="?action=admin-update">

        <input
            type="hidden"
            name="appointment_id"
            value="<?= (int) $appointment['id'] ?>"
        >

        <label for="date">Data:</label>

        <input
            type="date"
            id="date"
            name="date"
            value="<?= date(
                'Y-m-d',
                strtotime($appointment['appointment_datetime'])
            ) ?>"
            required
        >

        <br><br>

        <label for="time">Horário:</label>

        <input
            type="time"
            id="time"
            name="time"
            value="<?= date(
                'H:i',
                strtotime($appointment['appointment_datetime'])
            ) ?>"
            required
        >

        <h2>Serviços</h2>

        <?php foreach ($services as $service): ?>

            <label>
                <input
                    type="checkbox"
                    name="services[]"
                    value="<?= (int) $service['id'] ?>"
                    <?= in_array(
                        $service['id'],
                        $selectedServiceIds
                    ) ? 'checked' : '' ?>
                >

                <?= htmlspecialchars($service['name']) ?>
            </label>

            <br>

        <?php endforeach; ?>

        <br>

        <button type="submit">
            Salvar alterações
        </button>

    </form>

    <p>
        <a href="?action=admin-appointments">
            Voltar para os agendamentos
        </a>
    </p>

</body>
</html>