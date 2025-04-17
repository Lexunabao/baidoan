<?php
require_once __DIR__ . '/../../../app/controllers/BookController.php';
require_once __DIR__ . '/../../../app/controllers/CategoryController.php';

// Kiểm tra nếu không có danh sách sách
if (!isset($books)) {
    echo "<p class='error-message'>❌ Không có sách nào trong hệ thống!</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 Danh Sách Sách</title>
    
    <style>
        /* Reset margin và padding của các phần tử */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Cấu trúc chung của body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }

        /* Header */
        header {
            background-color: #f5a623; /* Màu cam cho header */
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        header nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        header nav ul li {
            display: inline-block;
        }

        header nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1rem;
        }

        header nav ul li a:hover {
            text-decoration: underline;
        }

        /* Thanh tìm kiếm và lọc */
        .filter-section {
            background-color: #fff;
            padding: 20px;
            text-align: center;
            margin-top: 20px;
        }

        .filter-section form {
            display: inline-flex;
            gap: 15px;
        }

        .filter-section input[type="text"], .filter-section select {
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 250px;
        }

        .filter-section button {
            padding: 10px 20px;
            font-size: 1rem;
            background-color: #f5a623; /* Màu cam cho nút */
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }

        .filter-section button:hover {
            background-color: #e59b21;
        }

        /* Danh sách sách */
        .book-list {
            padding: 20px;
            background-color: #fff;
            margin-top: 30px;
        }

        .book-list h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-align: center;
        }

        .book-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            justify-items: center;
        }

        .book-card {
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            width: 100%;
            max-width: 280px;
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Đảm bảo các phần tử được chia đều */
            height: auto; /* Đặt chiều cao tự động để thẻ có thể mở rộng */
            min-height: 380px; /* Đặt chiều cao tối thiểu để nút không bị quá sát dưới */
            transition: transform 0.3s ease;
        }

        .book-card:hover {
            transform: translateY(-10px);
        }

        .book-card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .book-card h3 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 10px;
            word-wrap: break-word; /* Đảm bảo tiêu đề không bị cắt khi quá dài */
        }

        .book-card p {
            font-size: 1.1rem;
            color: #777;
            margin-bottom: 10px;
        }

        .book-card .price {
            font-size: 1.3rem;
            color: #f5a623; /* Màu cam cho giá */
            font-weight: bold;
            margin-bottom: 15px;
        }

        .book-card .btn {
            background-color: #f5a623; /* Màu cam cho nút */
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: auto; /* Đảm bảo nút luôn ở dưới cùng */
        }

        .book-card .btn:hover {
            background-color: #e59b21;
        }

        /* Message lỗi nếu không có sách */
        .error-message {
            color: #ff4d4d;
            text-align: center;
            font-size: 1.2rem;
            margin-top: 20px;
        }
    </style>

</head>
<body>

    <!-- Header -->
    <header>
        <h1>📚 BookStore</h1>
        <nav>
            <ul>
                <li><a href="index.php?action=home">🏠 Trang Chủ</a></li>
                <li><a href="index.php?action=cart">🛒 Giỏ Hàng</a></li>
                <li><a href="index.php?action=logout">🔓 Đăng Xuất</a></li>
            </ul>
        </nav>
    </header>

    <!-- Thanh tìm kiếm và lọc -->
    <section class="filter-section">
        <form method="GET" action="index.php">
            <input type="hidden" name="action" value="books">
            <input type="text" name="keyword" placeholder="🔍 Tìm kiếm sách hoặc tác giả..." 
                   value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">

            <select name="category_id">
                <option value="0">📂 Tất cả thể loại</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id']; ?>" 
                        <?= (isset($_GET['category_id']) && $_GET['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($category['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn">🔍 Tìm Kiếm</button>
        </form>
    </section>

    <!-- Danh sách sách -->
    <section class="book-list">
        <h2>📚 Danh Sách Sách</h2>
        <div class="book-container">
            <?php foreach ($books as $book): ?>
                <div class="book-card">
                    <?php 
                        $imagePath = !empty($book['image']) ? "/PHP/baidoan/" . htmlspecialchars($book['image']) : "/PHP/baidoan/public/assets/images/no-image.png";
                    ?>
                    <img src="<?= $imagePath ?>" width="80" height="100" 
                        onerror="this.onerror=null;this.src='/PHP/baidoan/public/assets/images/no-image.png';">
                    <h3><?= htmlspecialchars($book['title']); ?></h3>
                    <p>🖊️ Tác giả: <?= htmlspecialchars($book['author']); ?></p>
                    <p class="price">💰 <?= number_format($book['price'], 0, ',', '.'); ?> VNĐ</p>
                    <a href="index.php?action=book_detail&id=<?= $book['id']; ?>" class="btn">📖 Xem Chi Tiết</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

</body>
</html>
