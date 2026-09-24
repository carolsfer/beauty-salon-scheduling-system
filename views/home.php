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
                Agende seu atendimento
            </h1>

            <p>
                Escolha os serviços, a data e o horário
                da sua próxima visita ao salão.
            </p>

            <div class="actions">

                <a href="?action=create" class="button">
                    Novo agendamento
                </a>

                <a
                    href="?action=list"
                    class="button button-secondary"
                >
                    Área do Cliente
                </a>

            </div>

        </section>

        <section class="services-section">

            <div class="section-heading">
                <span>Serviços disponíveis</span>
                <h2>Serviços do salão</h2>
            </div>

            <div class="service-grid">

                <article class="card service-card">
                    <h3>Cabelos</h3>
                    <p>
                        Serviços de corte e finalização
                        dos cabelos.
                    </p>
                </article>

                <article class="card service-card">
                    <h3>Unhas</h3>
                    <p>
                        Manicure e pedicure disponíveis
                        para agendamento.
                    </p>
                </article>

                <article class="card service-card">
                    <h3>Hidratação</h3>
                    <p>
                        Tratamento de hidratação
                        para os cabelos.
                    </p>
                </article>

            </div>

        </section>

    </div>
</main>

<?php require __DIR__ . '/layouts/footer.php'; ?>