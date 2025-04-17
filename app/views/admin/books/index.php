<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 Quản lý Sách</title>
    <link rel="stylesheet" href="/PHP/baidoan/public/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

    <div class="container mt-4">
        <h2 class="text-center text-primary">📚 Quản lý Sách</h2>
        
        <!-- Nút thêm sách -->
        <div class="text-end mb-3">
            <a href="index.php?action=add_book" class="btn btn-success">
                ➕ Thêm sách mới
            </a>
        </div>

        <!-- Hiển thị thông báo -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <?php
                if ($_GET['success'] == 1) echo "✅ Sách đã được thêm thành công!";
                if ($_GET['success'] == 2) echo "✅ Sách đã được cập nhật!";
                if ($_GET['success'] == 3) echo "✅ Sách đã bị xóa!";
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php
                if ($_GET['error'] == "upload_failed") echo "❌ Lỗi: Không thể tải ảnh lên!";
                if ($_GET['error'] == "invalid_format") echo "❌ Lỗi: Chỉ chấp nhận file JPG, PNG, GIF!";
                if ($_GET['error'] == "db_error") echo "❌ Lỗi: Không thể lưu dữ liệu vào database!";
                if ($_GET['error'] == "delete_failed") echo "❌ Lỗi: Không thể xóa sách!";
                ?>
            </div>
        <?php endif; ?>
        
        <!-- Nút Quay Lại -->
        <a href="index.php?action=admin_home" class="btn-back">⬅ Quay lại Trang Admin</a>
        
        <!-- Bảng danh sách sách -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề</th>
                        <th>Tác giả</th>
                        <th>Giá</th>
                        <th>Danh mục</th>
                        <th>Ảnh</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($books) && is_array($books)): ?>
                        <?php foreach ($books as $book): ?>
                        <tr>
                            <td><?= $book['id'] ?></td>
                            <td><?= htmlspecialchars($book['title']) ?></td>
                            <td><?= htmlspecialchars($book['author']) ?></td>
                            <td><?= number_format($book['price'], 0, ',', '.'); ?> VNĐ</td>
                            <td><?= htmlspecialchars($book['category_name']) ?></td>
                            <td>
                                <?php 
                                    $imagePath = !empty($book['image']) ? "/PHP/baidoan/" . htmlspecialchars($book['image']) : "/PHP/baidoan/public/assets/images/no-image.png";
                                ?>
                                <img src="<?= $imagePath ?>" width="80" height="100"
                                     onerror="this.onerror=null;this.src='/PHP/baidoan/public/assets/images/no-image.png';">
                            </td>
                            <td>
                                <a href="index.php?action=edit_book&id=<?= $book['id'] ?>" class="btn btn-warning btn-sm">
                                    ✏️ Sửa
                                </a>
                                <a href="index.php?action=delete_book&id=<?= $book['id'] ?>" class="btn btn-danger btn-sm"
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa sách này?')">
                                    🗑 Xóa
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-danger">❌ Không có sách nào trong hệ thống.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="index.php?action=manage_books&page=<?= $i ?>" class="btn btn-light btn-sm <?= ($i == $currentPage) ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
