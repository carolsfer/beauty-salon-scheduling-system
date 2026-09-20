<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar agendamento - Cabeleleila Leila</title>
</head>

<body>
    <h1>Alterar agendamento</h1>

    <p>
        Cliente:
        <?= htmlspecialchars($appointment['client_name']) ?>
    </p>

    <form method="POST" action="?action=update">
        <input
            type="hidden"
            name="appointment_id"
            value="<?= $appointment['id'] ?>"
        >

        <?php
        $selectedServiceIds = array_column(
            $selectedServices,
            'id'
        );
        ?>

        <h2>Serviços</h2>

        <?php foreach ($services as $service): ?>

            <div>
                <input
                    type="checkbox"
                    id="service-<?= $service['id'] ?>"
                    name="services[]"
                    value="<?= $service['id'] ?>"
                    <?= in_array(
                        $service['id'],
                        $selectedServiceIds
                    ) ? 'checked' : '' ?>
                >

                <label for="service-<?= $service['id'] ?>">
                    <?= htmlspecialchars($service['name']) ?>
                </label>
            </div>

        <?php endforeach; ?>

        <div>
            <label for="date">Data</label>

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
        </div>

        <div>
            <label for="time">Horário</label>

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
        </div>

        <button type="submit">
            Salvar alterações
        </button>
    </form>

    <a href="?action=details&id=<?= $appointment['id'] ?>">
        Voltar
    </a>
</body>
</html>