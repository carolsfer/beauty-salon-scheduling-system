<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área da Leila | Cabeleleila Leila</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header class="site-header">
        <div class="container header-content">
            <a href="?action=home" class="logo">
                Cabeleleila Leila
            </a>

            <nav class="navigation">
                <a href="?action=home">Voltar ao site</a>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="page-header">
                <span>Área administrativa</span>
                <h1>Área da Leila</h1>
                <p>
                    Entre para gerenciar os agendamentos do salão.
                </p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="message message-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form
                method="POST"
                action="?action=admin-authenticate"
                class="form-card admin-login-card"
            >
                <div class="form-group">
                    <label for="username">Usuário</label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        autocomplete="username"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Senha</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <div class="form-actions">
                    <button type="submit" class="button">
                        Entrar
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
            Cabeleleila Leila — Área administrativa
        </div>
    </footer>
</body>
</html>