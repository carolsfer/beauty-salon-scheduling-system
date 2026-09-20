<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Escolher serviços - Cabeleleila Leila</title>
</head>

<body>
    <h1>Escolha os serviços</h1>

    <p>
        Olá, <?= htmlspecialchars($clientName) ?>!
    </p>

    <form method="POST" action="?action=schedule">
        <input
            type="hidden"
            name="client_id"
            value="<?= $clientId ?>"
        >

        <?php foreach ($services as $service): ?>
            <div>
                <input
                    type="checkbox"
                    id="service-<?= $service['id'] ?>"
                    name="services[]"
                    value="<?= $service['id'] ?>"
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
                required
            >
        </div>

        <div>
            <label for="time">Horário</label>

            <input
                type="time"
                id="time"
                name="time"
                required
            >
        </div>

        <button type="submit">
            Continuar
        </button>
    </form>

    <a href="?action=create">Voltar</a>
</body>
</html>