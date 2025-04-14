<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>👤 Quản Lý Người Dùng</title>
    <link rel="stylesheet" href="/PHP/baidoan/public/assets/css/admin.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #ff6600;
            color: white;
        }

        .action-buttons {
            text-align: center;
            margin-top: 20px;
        }

        .btn-edit, .btn-delete, .btn-back {
            display: inline-block;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn-edit {
            background: #ffc107;
            color: black;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-back {
            background: #007bff;
            color: white;
            font-size: 16px;
            padding: 10px 15px;
        }

        .btn-edit:hover, .btn-delete:hover, .btn-back:hover {
            opacity: 0.8;
        }

        .role-icon {
            font-size: 16px;
            margin-right: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>👤 Quản Lý Người Dùng</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Tên Đăng Nhập</th>
            <th>Email</th>
            <th>Vai Trò</th>
            <th>Hành Động</th>
        </tr>

        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td>#<?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td>
                        <?= ($user['role'] == 'admin') 
                            ? "<span class='role-icon'>👑</span> Admin" 
                            : "<span class='role-icon'>👤</span> User"; ?>
                    </td>
                    <td>
    <a href="index.php?action=edit_user&id=<?= $user['id'] ?>" class="btn-edit">✏️ Sửa</a>
    <a href="index.php?action=delete_user&id=<?= $user['id'] ?>" class="btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');">🗑️ Xóa</a>
</td>

                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">🚫 Không có người dùng nào.</td>
            </tr>
        <?php endif; ?>
    </table>

    <div class="action-buttons">
        <a href="index.php?action=admin_home" class="btn-back">⬅️ Quay lại Trang Chính</a>
    </div>
</div>

</body>
</html>
