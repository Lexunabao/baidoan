<h2>📂 Quản lý Thể loại</h2>

<?php if (isset($_GET['success'])): ?>
    <p class="success-message">
        <?php
        if ($_GET['success'] == 1) echo "✅ Thể loại đã được thêm thành công!";
        if ($_GET['success'] == 2) echo "✅ Thể loại đã được cập nhật!";
        if ($_GET['success'] == 3) echo "✅ Thể loại đã bị xóa!";
        ?>
    </p>
<?php endif; ?>

<a href="index.php?action=add_category" class="btn-add-category">➕ Thêm Thể loại</a>

<table>
    <tr>
        <th>ID</th>
        <th>Tên Thể loại</th>
        <th>Hành động</th>
    </tr>
    <?php if (!empty($categories)): ?>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= $category['id']; ?></td>
                <td><?= htmlspecialchars($category['name']); ?></td>
                <td>
                    <a href="index.php?action=edit_category&id=<?= $category['id']; ?>" class="btn-edit">✏️ Sửa</a>
                    <a href="index.php?action=delete_category&id=<?= $category['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?')" class="btn-delete">🗑 Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="3">❌ Không có thể loại nào.</td></tr>
    <?php endif; ?>
</table>

<!-- Nút Quay lại Trang Chính -->
<a href="index.php?action=admin_home" class="btn-back-to-home">⬅️ Quay lại Trang Chính</a>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    h2 {
        text-align: center;
        color: #ff6600;
        margin-top: 30px;
    }

    .success-message {
        background-color: #28a745;
        color: white;
        padding: 10px;
        margin: 20px 0;
        border-radius: 5px;
        text-align: center;
    }

    .btn-add-category {
        display: inline-block;
        background-color: #ff6600;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        font-size: 16px;
        border-radius: 5px;
        margin-bottom: 20px;
        margin-left: 10px;
        transition: background-color 0.3s;
    }

    .btn-add-category:hover {
        background-color: #e55c00;
    }

    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
        background: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    th, td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }

    th {
        background-color: #ff6600;
        color: white;
        font-weight: bold;
    }

    td {
        font-size: 16px;
    }

    td a {
        text-decoration: none;
        color: #007bff;
        padding: 5px 10px;
        border-radius: 5px;
    }

    td a:hover {
        background-color: #f0f0f0;
    }

    .btn-edit {
        background-color: #007bff;
        color: white;
    }

    .btn-edit:hover {
        background-color: #0056b3;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background-color: #c82333;
    }

    tr:hover {
        background-color: #f9f9f9;
    }

    td[colspan="3"] {
        text-align: center;
        color: #dc3545;
        font-weight: bold;
    }

    /* Nút Quay lại Trang Chính */
    .btn-back-to-home {
        display: inline-block;
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        font-size: 16px;
        border-radius: 5px;
        margin-top: 20px;
        transition: background-color 0.3s;
        text-align: center;
        width: 100%;
    }

    .btn-back-to-home:hover {
        background-color: #0056b3;
    }
</style>
