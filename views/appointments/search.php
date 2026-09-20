<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Meus agendamentos - Cabeleleila Leila</title>
</head>

<body>
    <h1>Consultar meus agendamentos</h1>

    <form method="POST" action="?action=search-appointments">
        <div>
            <label for="phone">Telefone</label>

            <input
                type="tel"
                id="phone"
                name="phone"
                required
            >
        </div>

        <div>
            <label for="start_date">Data inicial</label>

            <input
                type="date"
                id="start_date"
                name="start_date"
                required
            >
        </div>

        <div>
            <label for="end_date">Data final</label>

            <input
                type="date"
                id="end_date"
                name="end_date"
                required
            >
        </div>

        <button type="submit">
            Buscar
        </button>
    </form>

    <a href="./">Voltar</a>
</body>
</html>