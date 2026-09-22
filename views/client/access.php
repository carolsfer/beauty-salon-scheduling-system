<?php

$pageTitle = 'Área do Cliente - Cabeleleila Leila';
$layoutContext = 'public';

require __DIR__ . '/../layouts/header.php';

?>

<main>
    <div class="container">

        <div class="page-header">
            <span>Área do Cliente</span>

            <h1>Acesse seus agendamentos</h1>

            <p>
                Informe o telefone utilizado nos seus agendamentos.
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
                    required
                >

                <span class="form-help">
                    Use o mesmo telefone informado ao agendar.
                </span>
            </div>

            <div class="form-actions">
                <button type="submit" class="button">
                    Acessar minha área
                </button>
            </div>

        </form>

        <a href="?action=home" class="back-link">
            ← Voltar para o início
        </a>

    </div>
</main>

<?php require __DIR__ . '/../layouts/footer.php'; ?>