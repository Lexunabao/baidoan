<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sách</title>
    <link rel="stylesheet" href="/PHP/baidoan/public/assets/css/admin.css">
</head>
<body>

    <div class="admin-form-container">
        <h2>➕ Thêm Sách</h2>

        
        <?php if (isset($_GET['error'])): ?>
            <p class="error-message">
                <?php
                if ($_GET['error'] == "upload_failed") echo "❌ Không thể tải ảnh lên!";
                if ($_GET['error'] == "invalid_format") echo "❌ Chỉ chấp nhận JPG, PNG, GIF!";
                if ($_GET['error'] == "db_error") echo "❌ Không thể thêm sách vào database!";
                ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="index.php?action=add_book" enctype="multipart/form-data">
            <label>Tiêu đề:</label>
            <input type="text" name="title" required>

            <label>Tác giả:</label>
            <input type="text" name="author" required>

            <label>Giá (VNĐ):</label>
            <input type="number" step="0.01" name="price" required>

            <label>Mô tả:</label>
            <textarea name="description" required></textarea>

            <label>Ảnh:</label>
            <input type="file" name="image" accept="image/*" required>

            <label>Danh mục:</label>
            <select name="category_id" required>
                <option value="">-- Chọn danh mục --</option>
                <?php
                require_once __DIR__ . '/../../../../app/models/Category.php';
                $categoryModel = new Category();
                $categories = $categoryModel->getAllCategories();

                if (!empty($categories)) {
                    foreach ($categories as $category) {
                        echo "<option value='{$category['id']}'>{$category['name']}</option>";
                    }
                } else {
                    echo "<option value=''>❌ Không có danh mục nào</option>";
                }
                ?>
            </select>

            <button type="submit" class="btn-submit">Thêm Sách</button>
        </form>

        <a href="index.php?action=manage_books" class="back-link">⬅ Quay lại Quản lý Sách</a>
    </div>

</body>
</html>
