<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Agendamentos | Área da Leila</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header class="site-header">
    <div class="container header-content">
        <a href="?action=admin-appointments" class="logo">
            Área da Leila
        </a>

        <nav class="navigation">
            <a href="?action=admin-appointments">Agendamentos</a>
            <a href="?action=admin-dashboard">Desempenho semanal</a>
            <a href="?action=admin-logout">Sair</a>
        </nav>
    </div>
</header>

<main>
    <div class="container">

        <div class="page-header">
            <span>Área administrativa</span>
            <h1>Agendamentos recebidos</h1>
            <p>
                Consulte os horários do salão, altere os status
                e acesse os detalhes de cada agendamento.
            </p>
        </div>

        <?php if (empty($appointments)): ?>

            <div class="empty-state">
                <h2>Nenhum agendamento encontrado</h2>

                <p>
                    Os novos agendamentos aparecerão aqui quando
                    forem realizados pelas clientes.
                </p>
            </div>

        <?php else: ?>

            <form
                method="POST"
                action="?action=admin-update-statuses"
                class="admin-appointments-form"
            >

                <div class="admin-table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Horário</th>
                                <th>Cliente</th>
                                <th>Telefone</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($appointments as $appointment): ?>
                                <tr>
                                    <td>
                                        <strong>
                                            <?= date(
                                                'd/m/Y',
                                                strtotime(
                                                    $appointment['appointment_datetime']
                                                )
                                            ) ?>
                                        </strong>
                                    </td>

                                    <td>
                                        <?= date(
                                            'H:i',
                                            strtotime(
                                                $appointment['appointment_datetime']
                                            )
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $appointment['client_name']
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $appointment['client_phone']
                                        ) ?>
                                    </td>

                                    <td>
                                        <select
                                            class="admin-status-select"
                                            name="statuses[<?= (int) $appointment['id'] ?>]"
                                        >
                                            <option
                                                value="PENDING"
                                                <?= $appointment['status'] === 'PENDING'
                                                    ? 'selected'
                                                    : '' ?>
                                            >
                                                Pendente
                                            </option>

                                            <option
                                                value="CONFIRMED"
                                                <?= $appointment['status'] === 'CONFIRMED'
                                                    ? 'selected'
                                                    : '' ?>
                                            >
                                                Confirmado
                                            </option>

                                            <option
                                                value="COMPLETED"
                                                <?= $appointment['status'] === 'COMPLETED'
                                                    ? 'selected'
                                                    : '' ?>
                                            >
                                                Concluído
                                            </option>
                                        </select>
                                    </td>

                                    <td>
                                        <div class="table-actions">
                                            <a
                                                href="?action=details&id=<?= (int) $appointment['id'] ?>&from=admin"
                                            >
                                                Ver
                                            </a>

                                            <a
                                                href="?action=admin-edit&id=<?= (int) $appointment['id'] ?>"
                                            >
                                                Editar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="admin-save-actions">
                    <button type="submit" class="button">
                        Salvar alterações
                    </button>

                    <span>
                        Salva os status selecionados na tabela.
                    </span>
                </div>

            </form>

        <?php endif; ?>

        <a href="?action=home" class="back-link">
            ← Voltar para o site
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