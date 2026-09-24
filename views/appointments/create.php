<?php

$pageTitle = 'Novo agendamento - Cabeleleila Leila';
$layoutContext = 'public';

require __DIR__ . '/../layouts/header.php';

?>

<main>
    <div class="container">

        <div class="page-header">
            <span>Novo agendamento</span>

            <h1>Vamos começar</h1>

            <p>
                Informe seus dados para continuar.
                Se você já agendou antes, use o mesmo
                telefone cadastrado.
            </p>
        </div>

        <form
            method="POST"
            action="?action=identify-client"
            class="card form-card"
        >

            <div class="form-group">
                <label for="name">Nome</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    autocomplete="name"
                    placeholder="Ex.: Ana Souza"
                    value="<?= htmlspecialchars($name ?? '') ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="phone">Telefone</label>

                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    autocomplete="tel"
                    placeholder="(14) 99999-9999"
                    value="<?= htmlspecialchars($phone ?? '') ?>"
                    class="<?= !empty($phoneError) ? 'input-error' : '' ?>"
                    required
                >

                <?php if (!empty($phoneError)): ?>
                    <span class="field-error">
                        <?= htmlspecialchars($phoneError) ?>
                    </span>
                <?php endif; ?>
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

<?php require __DIR__ . '/../layouts/footer.php'; ?>