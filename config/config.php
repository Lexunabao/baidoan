<?php
// **Cấu hình kết nối Database**
define('DB_HOST', 'localhost');      // Địa chỉ host của MySQL
define('DB_NAME', 'bookstore');      // Tên cơ sở dữ liệu
define('DB_USER', 'root');           // Tên đăng nhập MySQL
define('DB_PASS', '');               // Mật khẩu MySQL (để trống nếu không có)

// **Cấu hình URL gốc của website**
define('BASE_URL', 'http://localhost:8081/PHP/baidoan/');



// **Bật/Tắt hiển thị lỗi**
define('DEBUG', true);

if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// **Bắt đầu session nếu chưa có**
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
