<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    public function login() {
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $userModel = new User();
            $user = $userModel->login($username, $password);

            if ($user) {
                $_SESSION['user'] = $user; 

                
                if ($user['role'] === 'admin') {
                    header("Location: index.php?action=admin_home"); 
                } else {
                    header("Location: index.php?action=home"); 
                }
                exit();
            } else {
                echo "<p style='color: red;'>Sai tài khoản hoặc mật khẩu!</p>";
            }
        }

        require_once __DIR__ . '/../views/users/login.php';
        exit();
    }


    public function register() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($password !== $confirm_password) {
                echo "<p style='color: red;'>Mật khẩu xác nhận không khớp!</p>";
                return;
            }

            $userModel = new User();
            if ($userModel->register($username,$email, $password)) {
                header("Location: index.php?action=login");
                exit();
            } else {
                echo "<p style='color: red;'>Đăng ký thất bại, tên đăng nhập đã tồn tại!</p>";
            }
        }
        include __DIR__ . '/../views/users/register.php';
        exit();
    }

    public function logout() {
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
?>
