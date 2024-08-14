<?php

class UserController {

    /* Iniciar Sesión */
    static public function login() {
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
    
    /* Cerrar Sesión */
    static public function logout() {
        $_SESSION = [];
        session_destroy();
        header("Location: /");
        exit;
    }

    /* Página de Login */
    static public function renderLoging() {
        TemplateController::render('./views/users/login.php');
    }

    /* Página con todos los usuarios */
    static public function renderUsers() {
        $users = UserModel::alls();
        $data = [
            'title' => 'POS - Users',
            'users' => $users
        ];
        TemplateController::render('./views/users/list.php', './views/layout/sidebar.php', $data);
    }

    /* Formulario nuevo usuario */
    static public function renderNewForm() {
        include 'views/users/formNew.php';
    }

    /* Formulario editar usuario */
    static public function renderEditForm() {
        $userId = $_GET['id'] ?? null;
        if (!$userId) {
            echo "ID de usuario no proporcionado.";
            return;
        }
        $user = UserModel::getUserById($userId);
        if (!$user) {
            echo "Usuario no encontrado.";
            return;
        }
        include 'views/users/formEdit.php';
    }

    /* Crear un nuevo usuario */
    public static function createUser() {
        $login_usuario = $_POST['login_usuario'] ?? null;
        $password = $_POST['password'] ?? null;
        $vrpassword = $_POST['vrpassword'] ?? null;
        $perfil = $_POST['perfil'] ?? null;
        if (empty($login_usuario) || empty($password) || empty($vrpassword) || empty($perfil)) {
            echo json_encode(["status" => "ERROR", "message" => "Todos los campos son obligatorios."]);
            return;
        }
        if ($password !== $vrpassword) {
            echo json_encode(["status" => "ERROR", "message" => "Las contraseñas no coinciden."]);
            return;
        }
        $result = UserModel::createUser($login_usuario, $password, $perfil);
        if ($result) {
            echo json_encode(["status" => "OK", "message" => "Usuario creado exitosamente."]);
        } else {
            echo json_encode(["status" => "ERROR", "message" => "No se pudo crear el usuario."]);
        }
    }

    /* Eliminar usuario */
    public static function removeUser() {
        $userId = $_POST['id'] ?? null;
        if (empty($userId)) {
            echo json_encode(["status" => "ERROR", "message" => "El ID del usuario es requerido."]);
            return;
        }
        $currentUserId = $_SESSION['user_id'] ?? null;
        try {
            $result = UserModel::removeUser($userId);

            if ($result) {
                if ($userId == $currentUserId) {
                    $_SESSION = [];
                    session_destroy();
                }
                echo json_encode(["status" => "OK", "message" => "Usuario eliminado exitosamente."]);
            } else {
                echo json_encode(["status" => "ERROR", "message" => "No se pudo eliminar el usuario."]);
            }
        } catch (Exception $e) {
            echo json_encode(["status" => "ERROR", "message" => "Error al eliminar el usuario: " . $e->getMessage()]);
        }
    }

    /* Editar Usuario */
    public static function editUser() {
        $id = $_POST['id'] ?? null;
        $login_usuario = $_POST['login_usuario'] ?? null;
        $password = $_POST['password'] ?? null;
        $vrpassword = $_POST['vrpassword'] ?? null;
        $perfil = $_POST['perfil'] ?? null;
        $estado = isset($_POST['estado_usuario']) ? 1 : 0;
        if ($id && $login_usuario && $perfil) {
            try {
                if ($password !== '' && $vrpassword !== '') {
                    if ($password === $vrpassword) {
                        UserModel::updateUser($id, $login_usuario, $password, $perfil, $estado);
                        echo json_encode(['status' => 'OK', 'message' => 'Usuario actualizado exitosamente']);
                    } else {
                        echo json_encode(['status' => 'ERROR', 'message' => 'Las contraseñas no coinciden']);
                    }
                } else {
                    UserModel::updateUser($id, $login_usuario, null, $perfil, $estado);
                    echo json_encode(['status' => 'OK', 'message' => 'Usuario actualizado exitosamente']);
                }
            } catch (Exception $e) {
                echo json_encode(['status' => 'ERROR', 'message' => 'Error al actualizar el usuario: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['status' => 'ERROR', 'message' => 'Todos los campos son requeridos']);
        }
    }
}
