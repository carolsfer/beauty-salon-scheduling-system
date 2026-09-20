<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Agendar horário - Cabeleleila Leila</title>
</head>

<body>
    <h1>Agendar horário</h1>

    <form method="POST" action="?action=identify-client">
        <div>
            <label for="name">Nome</label>

            <input
                type="text"
                id="name"
                name="name"
                required
            >
        </div>

        <div>
            <label for="phone">Telefone</label>

            <input
                type="tel"
                id="phone"
                name="phone"
                required
            >
        </div>

        <button type="submit">
            Continuar
        </button>
    </form>

    <a href="./">Voltar</a>
</body>
</html>