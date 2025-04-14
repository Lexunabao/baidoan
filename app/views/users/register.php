<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <link rel="stylesheet" href="/PHP/baidoan/public/assets/css/style.css">
</head>
<body>
    <div class="auth-container">
        <h2>Đăng Ký</h2>
        <form method="POST" action="index.php?action=register">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" name="username" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" required>

            <label for="confirm_password">Xác nhận mật khẩu:</label>
            <input type="password" name="confirm_password" required>

            <button type="submit">Đăng Ký</button>
            <p>Đã có tài khoản? <a href="index.php?action=login">Đăng nhập ngay</a></p>
        </form>
    </div>
</body>
</html>
