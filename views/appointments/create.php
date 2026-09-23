<?php

$pageTitle = 'Agendar horário - Cabeleleila Leila';
$layoutContext = 'public';

require __DIR__ . '/../layouts/header.php';

?>

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
            class="card form-card"
        >

            <div class="form-group">
                <label for="name">Nome</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="<?= htmlspecialchars($name ?? '') ?>"
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
                    value="<?= htmlspecialchars($phone ?? '') ?>"
                    class="<?= !empty($phoneError) ? 'input-error' : '' ?>"
                    required
                    autocomplete="tel"
                    placeholder="(14) 99999-9999"
                >
                
                <?php if (!empty($phoneError)): ?>
                    <span class="field-error">
                        <?= htmlspecialchars($phoneError) ?>
                    </span>
                <?php endif; ?>

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

<?php require __DIR__ . '/../layouts/footer.php'; ?>