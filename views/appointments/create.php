<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Agendar horário - Cabeleleila Leila</title>

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

            <h1>Vamos marcar seu horário?</h1>

            <p>
                Primeiro, precisamos saber quem está realizando
                o agendamento.
            </p>
        </div>

        <form
            method="POST"
            action="?action=identify-client"
            class="form-card"
        >

            <div class="form-group">
                <label for="name">Nome</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    required
                    autocomplete="name"
                    placeholder="Digite seu nome"
                >
            </div>

            <div class="form-group">
                <label for="phone">Telefone</label>

                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    required
                    autocomplete="tel"
                    placeholder="(14) 99999-9999"
                >

                <span class="form-help">
                    Usaremos seu telefone para localizar seus agendamentos.
                </span>
            </div>

            <div class="form-actions">
                <button type="submit" class="button">
                    Continuar
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