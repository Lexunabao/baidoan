<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

class UserController {
    public function index() {
        AuthMiddleware::checkAdmin();
        $userModel = new User();
        $users = $userModel->getAllUsers();
        include __DIR__ . '/../views/admin/users/index.php';
    }

    public function deleteUser() {
        AuthMiddleware::checkAdmin();

        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: index.php?action=manage_users&error=missing_id");
            exit();
        }

        $userModel = new User();
        $userModel->deleteUser($_GET['id']);
        header("Location: index.php?action=manage_users&success=deleted");
        exit();
    }

    public function editUser() {
        AuthMiddleware::checkAdmin();

        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: index.php?action=manage_users&error=missing_id");
            exit();
        }

        $userModel = new User();
        $user = $userModel->getUserById($_GET['id']);

        if (!$user) {
            header("Location: index.php?action=manage_users&error=user_not_found");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $role = $_POST['role'];
            $userModel->updateUserRole($_GET['id'], $role);
            header("Location: index.php?action=manage_users&success=updated");
            exit();
        }

        include __DIR__ . '/../views/admin/users/edit.php';
    }
    public function updateUser() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userModel = new User();
            $id = $_POST['id'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = isset($_POST['password']) && !empty($_POST['password']) 
                ? password_hash($_POST['password'], PASSWORD_BCRYPT) 
                : null;
            $role = $_POST['role'];

            $userModel->updateUser($id, $username, $email, $password, $role);
        }

        header("Location: index.php?action=manage_users&success=updated");
        exit();
    }
}
?>
