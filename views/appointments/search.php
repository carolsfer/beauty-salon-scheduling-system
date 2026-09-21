<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Consultar agendamentos - Cabeleleila Leila</title>

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
            <span>Seus horários</span>

            <h1>Consultar agendamentos</h1>

            <p>
                Informe seu telefone e o período que deseja consultar.
            </p>
        </div>

        <form
            method="POST"
            action="?action=search-appointments"
            class="form-card"
        >

            <div class="form-group">
                <label for="phone">Telefone</label>

                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    autocomplete="tel"
                    placeholder="(14) 99999-9999"
                    required
                >

                <span class="form-help">
                    Use o mesmo telefone informado no agendamento.
                </span>
            </div>

            <div class="date-time-grid">

                <div class="form-group">
                    <label for="start_date">
                        Data inicial
                    </label>

                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="end_date">
                        Data final
                    </label>

                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        required
                    >
                </div>

            </div>

            <div class="form-actions">
                <button type="submit" class="button">
                    Buscar agendamentos
                </button>
            </div>

        </form>

        <a href="?action=home" class="back-link">
            ← Voltar para o início
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