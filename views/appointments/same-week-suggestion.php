<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sugestão de agendamento - Cabeleleila Leila</title>

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
            <span>Sugestão de agendamento</span>

            <h1>Você já tem um horário nesta semana</h1>

            <p>
                Encontramos outro agendamento seu próximo
                da data escolhida.
            </p>
        </div>

        <div class="card suggestion-card">

            <div class="existing-appointment">
                <span>Agendamento existente</span>

                <strong>
                    <?= date(
                        'd/m/Y',
                        strtotime(
                            $existingAppointment['appointment_datetime']
                        )
                    ) ?>

                    às

                    <?= date(
                        'H:i',
                        strtotime(
                            $existingAppointment['appointment_datetime']
                        )
                    ) ?>
                </strong>
            </div>

            <p class="suggestion-text">
                Você pode aproveitar essa visita e adicionar
                os novos serviços ao agendamento existente.
                Se preferir, também pode manter o novo horário
                que escolheu.
            </p>

            <form
                method="POST"
                action="?action=confirm-schedule"
            >

                <input
                    type="hidden"
                    name="client_id"
                    value="<?= (int) $clientId ?>"
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
                    value="<?= (int) $existingAppointment['id'] ?>"
                >

                <div class="suggestion-actions">

                    <button
                        type="submit"
                        name="choice"
                        value="same-date"
                        class="button"
                    >
                        Adicionar ao agendamento existente
                    </button>

                    <button
                        type="submit"
                        name="choice"
                        value="keep-date"
                        class="button button-secondary"
                    >
                        Manter novo horário
                    </button>

                </div>

            </form>

        </div>

        <a href="?action=create" class="back-link">
            ← Cancelar agendamento
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