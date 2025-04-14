<?php
if (!isset($book)) {
    echo "<p class='error-message'>❌ Lỗi: Không tìm thấy sách!</p>";
    exit();
}

require_once __DIR__ . '/../../../controllers/CategoryController.php';


$categoryController = new CategoryController();
$categories = $categoryController->getAllCategories(); // Lấy danh mục từ DB

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✏️ Chỉnh Sửa Sách</title>
    <link rel="stylesheet" href="/PHP/baidoan/public/assets/css/admin.css">
</head>
<body>

    <div class="admin-container">
        <h2>✏️ Chỉnh Sửa Sách</h2>

        <?php if (isset($_GET['error'])): ?>
            <p class="error-message">
                <?php
                if ($_GET['error'] == "upload_failed") echo "❌ Lỗi: Không thể tải ảnh lên!";
                if ($_GET['error'] == "invalid_format") echo "❌ Lỗi: Chỉ chấp nhận file JPG, PNG, GIF!";
                if ($_GET['error'] == "db_error") echo "❌ Lỗi: Không thể cập nhật dữ liệu!";
                ?>
            </p>
        <?php endif; ?>

        <form action="index.php?action=edit_book&id=<?= $book['id']; ?>" method="POST" enctype="multipart/form-data">
            
            <label for="title">📖 Tiêu đề:</label>
            <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>

            <label for="author">👤 Tác giả:</label>
            <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>

            <label for="price">💰 Giá (VNĐ):</label>
            <input type="number" name="price" value="<?= htmlspecialchars($book['price']) ?>" required>

            <label for="description">📜 Mô tả:</label>
            <textarea name="description" required><?= htmlspecialchars($book['description']) ?></textarea>

            <label for="category_id">📂 Danh mục:</label>
            <select name="category_id" required>
                <option value="">-- Chọn danh mục --</option>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" 
                            <?= ($category['id'] == $book['category_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="" disabled>❌ Không có danh mục</option>
                <?php endif; ?>
            </select>

            <label for="image">📷 Ảnh:</label>
            <input type="file" name="image" accept="image/*">

            <p>📌 Ảnh hiện tại:</p>
            <?php
$imagePath = !empty($book['image']) ? '/PHP/baidoan/' . htmlspecialchars($book['image']) : '/PHP/baidoan/public/assets/images/no-image.png';
?>
<img src="<?= $imagePath ?>" width="120" height="160"
     onerror="this.onerror=null;this.src='/PHP/baidoan/public/assets/images/no-image.png';">


            <div class="form-buttons">
                <button type="submit" class="btn-save">💾 Lưu thay đổi</button>
                <a href="index.php?action=manage_books" class="btn-cancel">❌ Hủy</a>
            </div>
        </form>
    </div>

</body>
</html>
