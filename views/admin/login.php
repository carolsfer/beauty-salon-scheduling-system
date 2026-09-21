<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Área da Leila</title>
</head>

<body>

    <h1>Área da Leila</h1>

    <p>Acesso administrativo do salão.</p>

    <?php if (!empty($error)): ?>
        <p>
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="?action=admin-authenticate">

        <label for="username">
            Usuário:
        </label>

        <input
            type="text"
            id="username"
            name="username"
            required
        >

        <br><br>

        <label for="password">
            Senha:
        </label>

        <input
            type="password"
            id="password"
            name="password"
            required
        >

        <br><br>

        <button type="submit">
            Entrar
        </button>

    </form>

    <p>
        <a href="?action=home">
            Voltar para o início
        </a>
    </p>

</body>
</html>