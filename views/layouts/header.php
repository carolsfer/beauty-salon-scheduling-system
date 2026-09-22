<?php

$pageTitle = $pageTitle ?? 'Cabeleleila Leila';
$layoutContext = $layoutContext ?? 'public';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle) ?></title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header class="site-header">
    <div class="container header-content">

        <?php if ($layoutContext === 'admin'): ?>

            <a href="?action=admin-appointments" class="logo">
                Área da Leila
            </a>

            <nav class="navigation">
                <a href="?action=admin-appointments">
                    Agendamentos
                </a>

                <a href="?action=admin-dashboard">
                    Desempenho semanal
                </a>

                <a href="?action=admin-logout">
                    Sair
                </a>
            </nav>

        <?php elseif ($layoutContext === 'admin-login'): ?>

            <a href="?action=home" class="logo">
                Cabeleleila Leila
            </a>

            <nav class="navigation">
                <a href="?action=home">
                    Voltar ao site
                </a>
            </nav>

        <?php else: ?>

            <a href="?action=home" class="logo">
                Cabeleleila Leila
            </a>

            <nav class="navigation">
                <a href="?action=home">
                    Início
                </a>

                <a href="?action=client-area">
                    Área do Cliente
                </a>

                <a href="?action=admin-login">
                    Área da Leila
                </a>
            </nav>

        <?php endif; ?>

    </div>
</header>