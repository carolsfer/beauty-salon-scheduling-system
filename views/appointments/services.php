<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Escolher serviços - Cabeleleila Leila</title>

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

            <h1>Escolha seus serviços</h1>

            <p>
                Selecione um ou mais serviços e escolha
                quando você gostaria de vir ao salão.
            </p>
        </div>

        <form
            method="POST"
            action="?action=schedule"
            class="form-card"
        >

            <input
                type="hidden"
                name="client_id"
                value="<?= (int) $client['id'] ?>"
            >

            <div class="client-summary">
                <span>Agendamento para</span>

                <strong>
                    <?= htmlspecialchars($client['name']) ?>
                </strong>
            </div>

            <div class="form-group">
                <span class="form-label">
                    Serviços
                </span>

                <div class="checkbox-list">

                    <?php foreach ($services as $service): ?>

                        <label class="checkbox-option">

                            <input
                                type="checkbox"
                                name="services[]"
                                value="<?= (int) $service['id'] ?>"
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
                        required
                    >
                </div>

            </div>

            <div class="form-actions">
                <button
                    type="submit"
                    class="button"
                >
                    Continuar
                </button>
            </div>

        </form>

        <a href="?action=create" class="back-link">
            ← Voltar
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