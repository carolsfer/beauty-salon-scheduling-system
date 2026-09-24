<?php

$pageTitle = 'Agendamentos - Cabeleleila Leila';
$layoutContext = 'admin';

require __DIR__ . '/../layouts/header.php';

$statusLabels = [
    'PENDING' => 'Pendente',
    'CONFIRMED' => 'Confirmado',
    'COMPLETED' => 'Concluído'
];

?>

<main>
    <div class="container">

        <div class="page-header">
            <span>Área da Leila</span>

            <h1>Agendamentos do salão</h1>

            <p>
                Consulte os atendimentos recebidos, altere seus dados
                e acompanhe o andamento de cada um.
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
            >

                <div class="appointment-list">

                    <?php foreach ($appointments as $appointment): ?>

                        <?php
                        $status = $appointment['status'];
                        $statusLabel = $statusLabels[$status] ?? $status;
                        ?>

                        <article class="card appointment-card">

                            <div class="appointment-date">

                                <span>
                                    <?= date(
                                        'd/m/Y',
                                        strtotime(
                                            $appointment[
                                                'appointment_datetime'
                                            ]
                                        )
                                    ) ?>
                                </span>

                                <strong>
                                    <?= date(
                                        'H:i',
                                        strtotime(
                                            $appointment[
                                                'appointment_datetime'
                                            ]
                                        )
                                    ) ?>
                                </strong>

                            </div>

                            <div class="appointment-info">

                                <strong>
                                    <?= htmlspecialchars(
                                        $appointment['client_name']
                                    ) ?>
                                </strong>

                                <span>
                                    <?= htmlspecialchars(
                                        $appointment['client_phone']
                                    ) ?>
                                </span>

                            </div>

                            <div class="appointment-status">

                                <label
                                    for="status-<?= (int) $appointment['id'] ?>"
                                >
                                    Status
                                </label>

                                <select
                                    id="status-<?= (int) $appointment['id'] ?>"
                                    name="statuses[<?= (int) $appointment['id'] ?>]"
                                >

                                    <?php foreach (
                                        $statusLabels as
                                        $statusValue => $label
                                    ): ?>

                                        <option
                                            value="<?= $statusValue ?>"
                                            <?= $status === $statusValue
                                                ? 'selected'
                                                : '' ?>
                                        >
                                            <?= htmlspecialchars($label) ?>
                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                            <div class="appointment-actions">

                                <a
                                    href="?action=details&id=<?= (int) $appointment['id'] ?>&from=admin"
                                    class="button button-secondary"
                                >
                                    Ver detalhes
                                </a>

                                <a
                                    href="?action=admin-edit&id=<?= (int) $appointment['id'] ?>"
                                    class="button button-secondary"
                                >
                                    Alterar agendamento
                                </a>

                            </div>

                        </article>

                    <?php endforeach; ?>

                </div>

                <div class="form-actions">
                    <button type="submit" class="button">
                        Salvar status
                    </button>
                </div>

            </form>

        <?php endif; ?>

    </div>
</main>

<?php require __DIR__ . '/../layouts/footer.php'; ?>