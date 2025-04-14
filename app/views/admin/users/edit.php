<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>✏️ Chỉnh Sửa Người Dùng</title>
    <link rel="stylesheet" href="/PHP/baidoan/public/assets/css/admin.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #ff6600;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn-group {
            text-align: center;
            margin-top: 20px;
        }

        .btn-submit, .btn-back {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .btn-submit {
            background: #28a745;
            color: #fff;
        }

        .btn-back {
            background: #007bff;
            color: white;
        }

        .btn-submit:hover, .btn-back:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>✏️ Chỉnh Sửa Người Dùng</h2>

    <form action="index.php?action=update_user" method="POST">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">

        <div class="form-group">
            <label for="username">👤 Tên Đăng Nhập:</label>
            <input type="text" name="username" required value="<?= htmlspecialchars($user['username']) ?>">
        </div>

        <div class="form-group">
            <label for="email">📧 Email:</label>
            <input type="email" name="email" required value="<?= htmlspecialchars($user['email']) ?>">
        </div>

        <div class="form-group">
            <label for="password">🔑 Mật Khẩu (Để trống nếu không muốn đổi):</label>
            <input type="password" name="password">
        </div>

        <div class="form-group">
            <label for="role">🎭 Vai Trò:</label>
            <select name="role" required>
                <option value="user" <?= ($user['role'] == 'user') ? "selected" : "" ?>>User</option>
                <option value="admin" <?= ($user['role'] == 'admin') ? "selected" : "" ?>>Admin</option>
            </select>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn-submit">💾 Lưu Thay Đổi</button>
            <a href="index.php?action=manage_users" class="btn-back">⬅️ Quay lại</a>
        </div>
    </form>
</div>

</body>
</html>
