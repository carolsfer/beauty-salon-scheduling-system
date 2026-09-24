<?php

$pageTitle = 'Cabeleleila Leila';
$layoutContext = 'public';

require __DIR__ . '/layouts/header.php';

?>

<main>
    <div class="container">

        <section class="hero">

            <p>Salão de beleza</p>

            <h1>
                Seu momento de cuidado começa aqui!
            </h1>

            <p>
                Agende seus serviços de forma simples e acompanhe
                seus horários sem precisar sair de casa.
            </p>

            <div class="actions">

                <a href="?action=create" class="button">
                    Agendar horário
                </a>

                <a href="?action=list"
                   class="button button-secondary">
                    Consultar agendamentos
                </a>

            </div>

        </section>

        <section class="services-section">

            <div class="section-heading">
                <span>Nossos serviços</span>
                <h2>Escolha como você quer se cuidar</h2>
            </div>

            <div class="service-grid">

                <article class="card service-card">
                    <h3>Cabelos</h3>
                    <p>
                        Cuidados para deixar suas madeixas
                        do jeito que você gosta.
                    </p>
                </article>

                <article class="card service-card">
                    <h3>Unhas</h3>
                    <p>
                        Manicure e pedicure para completar
                        o seu momento de cuidado.
                    </p>
                </article>

                <article class="card service-card">
                    <h3>Hidratação</h3>
                    <p>
                        Tratamentos para cuidar e renovar
                        seus cabelos.
                    </p>
                </article>

            </div>

        </section>

    </div>
</main>

<?php require __DIR__ . '/layouts/footer.php'; ?>