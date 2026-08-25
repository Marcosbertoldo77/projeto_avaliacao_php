<?php

class AuthController extends Controller
{
    public function showLogin(): void
    {
        $error = $_SESSION['auth_error'] ?? null;
        unset($_SESSION['auth_error']);
        $this->view('auth/login', ['error' => $error]);
    }

    public function login(): void
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$email || !$password) {
            $_SESSION['auth_error'] = 'Ops, Email ou Senha inválido';
            header('Location: /login');
            exit;
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['auth_error'] = 'Ops, Email ou Senha inválido';
            header('Location: /login');
            exit;
        }

        // Auth success
        $_SESSION['user_id'] = (int)$user['id'];
        header('Location: /');
        exit;
    }

    public function logout(): void
    {
        unset($_SESSION['user_id']);
        session_destroy();
        header('Location: /login');
        exit;
    }
}
