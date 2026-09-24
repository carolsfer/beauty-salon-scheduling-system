<?php

$pageTitle = 'Agendamentos - Cabeleleila Leila';
$layoutContext = 'admin';

require __DIR__ . '/../layouts/header.php';

?>

<main>
    <div class="container">

        <div class="page-header">
            <span>Área da Leila</span>

            <h1>Agendamentos do salão</h1>

            <p>
                Consulte os atendimentos recebidos, altere seus status
                e acesse os detalhes de cada agendamento.
            </p>
        </div>

        <?php if (empty($appointments)): ?>

            <div class="card empty-state">

                <h2>Nenhum agendamento cadastrado</h2>

                <p>
                    Os novos agendamentos feitos pelas clientes
                    serão exibidos aqui.
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
                                                Ver detalhes
                                            </a>

                                            <a
                                                href="?action=admin-edit&id=<?= (int) $appointment['id'] ?>"
                                            >
                                                Alterar
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
                        Salvar status
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

<?php require __DIR__ . '/../layouts/footer.php'; ?>