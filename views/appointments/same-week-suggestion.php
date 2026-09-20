<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sugestão de agendamento - Cabeleleila Leila</title>
</head>

<body>
    <h1>Você já possui um agendamento nesta semana</h1>

    <p>
        Encontramos um agendamento para
        <?= date(
            'd/m/Y',
            strtotime($existingAppointment['appointment_datetime'])
        ) ?>
        às
        <?= date(
            'H:i',
            strtotime($existingAppointment['appointment_datetime'])
        ) ?>.
    </p>

    <p>
        Você pode realizar os novos serviços na mesma data
        ou manter o novo horário escolhido.
    </p>

    <form method="POST" action="?action=confirm-schedule">
        <input
            type="hidden"
            name="client_id"
            value="<?= $clientId ?>"
        >

        <input
            type="hidden"
            name="date"
            value="<?= htmlspecialchars($date) ?>"
        >

        <input
            type="hidden"
            name="time"
            value="<?= htmlspecialchars($time) ?>"
        >

        <input
            type="hidden"
            name="existing_datetime"
            value="<?= htmlspecialchars(
                $existingAppointment['appointment_datetime']
            ) ?>"
        >

        <?php foreach ($services as $serviceId): ?>
            <input
                type="hidden"
                name="services[]"
                value="<?= (int) $serviceId ?>"
            >
        <?php endforeach; ?>

        <input
            type="hidden"
            name="existing_appointment_id"
            value="<?= $existingAppointment['id'] ?>"
        >

        <button type="submit" name="choice" value="same-date">
            Usar essa data
        </button>

        <button type="submit" name="choice" value="keep-date">
            Manter data escolhida
        </button>
    </form>

    <a href="?action=create">Cancelar</a>
</body>
</html>