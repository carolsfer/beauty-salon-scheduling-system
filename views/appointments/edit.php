<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Alterar agendamento - Cabeleleila Leila</title>

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
            <span>Agendamento</span>

            <h1>Alterar seu horário</h1>

            <p>
                Atualize os serviços, a data ou o horário
                do seu agendamento.
            </p>
        </div>

        <form
            method="POST"
            action="?action=update"
            class="form-card"
        >

            <input
                type="hidden"
                name="appointment_id"
                value="<?= (int) $appointment['id'] ?>"
            >

            <div class="client-summary">
                <span>Agendamento para</span>

                <strong>
                    <?= htmlspecialchars($appointment['client_name']) ?>
                </strong>
            </div>

            <?php
            $selectedServiceIds = array_column(
                $selectedServices,
                'id'
            );
            ?>

            <div class="form-group">
                <span class="form-label">
                    Serviços
                </span>

                <div class="checkbox-list">

                    <?php foreach ($services as $service): ?>

                        <label
                            class="checkbox-option"
                            for="service-<?= (int) $service['id'] ?>"
                        >

                            <input
                                type="checkbox"
                                id="service-<?= (int) $service['id'] ?>"
                                name="services[]"
                                value="<?= (int) $service['id'] ?>"
                                <?= in_array(
                                    $service['id'],
                                    $selectedServiceIds
                                ) ? 'checked' : '' ?>
                            >

                            <span>
                                <?= htmlspecialchars($service['name']) ?>
                            </span>

                        </label>

                    <?php endforeach; ?>

                </div>
            </div>

            <div class="date-time-grid">

                <div class="form-group">
                    <label for="date">
                        Data
                    </label>

                    <input
                        type="date"
                        id="date"
                        name="date"
                        min="<?= date('Y-m-d') ?>"
                        value="<?= date(
                            'Y-m-d',
                            strtotime(
                                $appointment['appointment_datetime']
                            )
                        ) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="time">
                        Horário
                    </label>

                    <input
                        type="time"
                        id="time"
                        name="time"
                        value="<?= date(
                            'H:i',
                            strtotime(
                                $appointment['appointment_datetime']
                            )
                        ) ?>"
                        required
                    >
                </div>

            </div>

            <div class="form-actions">
                <button
                    type="submit"
                    class="button"
                >
                    Salvar alterações
                </button>
            </div>

        </form>

        <a
            href="?action=details&id=<?= (int) $appointment['id'] ?>"
            class="back-link"
        >
            ← Cancelar alterações
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