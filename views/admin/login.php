<?php

$pageTitle = 'Área da Leila - Cabeleleila Leila';
$layoutContext = 'admin-login';

require __DIR__ . '/../layouts/header.php';

?>

<main>
    <div class="container">

        <div class="page-header">
            <span>Área da Leila</span>

            <h1>Acesso administrativo</h1>

            <p>
                Entre com suas credenciais para acessar
                os agendamentos e o acompanhamento do salão.
            </p>
        </div>

        <form
            method="POST"
            action="?action=admin-authenticate"
            class="form-card admin-login-card"
        >

            <?php if (!empty($error)): ?>

                <div class="message message-error">
                    <?= htmlspecialchars($error) ?>
                </div>

            <?php endif; ?>

            <div class="form-group">
                <label for="username">
                    Usuário
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    autocomplete="username"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">
                    Senha
                </label>

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

<?php require __DIR__ . '/../layouts/footer.php'; ?>