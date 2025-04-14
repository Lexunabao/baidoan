<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="/PHP/baidoan/public/assets/css/style.css">
</head>
<body>
    <div class="auth-container">
        <h2>Đăng Nhập</h2>
        <form method="POST" action="index.php?action=login">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" name="username" required>
            
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" required>
            
            <button type="submit">Đăng nhập</button>
            <p>Chưa có tài khoản? <a href="index.php?action=register">Đăng ký ngay</a></p>
        </form>
    </div>
</body>
</html>
