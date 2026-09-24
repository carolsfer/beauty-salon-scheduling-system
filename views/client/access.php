<?php

$pageTitle = 'Área do Cliente - Cabeleleila Leila';
$layoutContext = 'public';

require __DIR__ . '/../layouts/header.php';

?>

<main>
    <div class="container">

        <div class="page-header">
            <span>Área do Cliente</span>

            <h1>Consulte seus agendamentos</h1>

            <p>
                Informe o telefone cadastrado no seu primeiro
                agendamento para acessar seus horários.
            </p>
        </div>

        <form
            method="POST"
            action="?action=client-identify"
            class="card form-card"
        >

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