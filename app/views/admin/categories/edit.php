<h2>✏️ Chỉnh sửa Danh Mục</h2>

<?php if (!empty($error)): ?>
    <p class="error-message"><?= $error; ?></p>
<?php endif; ?>

<form method="POST" action="index.php?action=edit_category&id=<?= $category['id']; ?>" class="edit-category-form">
    <label>Tên danh mục:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($category['name']); ?>" required>
    <button type="submit" class="btn-submit">Cập Nhật</button>
</form>

<a href="index.php?action=manage_categories" class="btn-back">⬅ Quay lại</a>

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

    .error-message {
        background-color: #dc3545;
        color: white;
        padding: 10px;
        margin: 20px 0;
        border-radius: 5px;
        text-align: center;
    }

    .edit-category-form {
        width: 50%;
        margin: 30px auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .edit-category-form label {
        display: block;
        margin-bottom: 10px;
        font-size: 16px;
        color: #333;
    }

    .edit-category-form input[type="text"] {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .btn-submit {
        width: 100%;
        padding: 10px;
        background-color: #ff6600;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-submit:hover {
        background-color: #e55c00;
    }

    .btn-back {
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
    }

    .btn-back:hover {
        background-color: #0056b3;
    }
</style>
