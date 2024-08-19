<?php

class AuthController {

    public static function renderLoging() {
        TemplateController::render('./views/users/login.php');
    }

    public static function login() {
        $login_usuario = $_POST['login_usuario'] ?? null;
        $password = $_POST['password'] ?? null;
        if ($login_usuario && $password) {
            $login_usuario = htmlspecialchars($login_usuario, ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');
            $userAuth = UserModel::authorize($login_usuario, $password);
    
            if ($userAuth) {
                $_SESSION['user_id'] = $userAuth['id_usuario'];
                header("Location: /dashboard");
                exit;
            } else {
                header("Location: /");
                exit;
            }
        } else {
            header("Location: /");
            exit;
        }
    }

    public static function logout() {
        $_SESSION = [];
        session_unset();
        session_destroy();
        header("Location: /");
        exit;
    }
}