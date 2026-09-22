<?php

class AuthController
{
    private array $env;

    public function __construct()
    {
        $this->env = parse_ini_file(
            __DIR__ . '/../.env'
        );
    }

    public function login(): void
    {
        if (!empty($_SESSION['admin_logged_in'])) {
            header('Location: ?action=admin-appointments');
            exit;
        }

        require __DIR__ . '/../views/admin/login.php';
    }

    public function authenticate(): void
    {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $validUsername = $this->env['ADMIN_USERNAME'] ?? '';
        $passwordHash = $this->env['ADMIN_PASSWORD_HASH'] ?? '';

        if (
            $username === $validUsername &&
            $passwordHash !== '' &&
            password_verify($password, $passwordHash)
        ) {
            session_regenerate_id(true);

            $_SESSION['admin_logged_in'] = true;

            header('Location: ?action=admin-appointments');
            exit;
        }

        $error = 'Usuário ou senha inválidos.';

        require __DIR__ . '/../views/admin/login.php';
    }

    public function logout(): void
    {
        $_SESSION = [];

        session_destroy();

        header('Location: ?action=home');
        exit;
    }
}