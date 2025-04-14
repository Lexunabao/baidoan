<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class AuthMiddleware{
    public static function checkAuth(){
        if(!isset($_SESSION['user'])){
            header("Location: index.php?action=login");
            exit();
        }
    }
    public static function checkAdmin() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            die("🚫 Bạn không có quyền truy cập trang này!");
        }
    }

    public static function guestOnly() {
        if (isset($_SESSION['user'])) {
            header("Location: index.php");
            exit();
        }
    }

    
    public static function getCurrentUser() {
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }
}
?>