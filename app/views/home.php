<?php
require_once __DIR__ . '/../controllers/BookController.php';

// Gọi Controller để lấy danh sách sách mới nhất
$bookController = new BookController();
$books = $bookController->getLastBooks();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 BookStore - Trang Chủ</title>
    
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
        background-color: #f5a623; /* Thay đổi màu nền của header */
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

    /* Banner */
    .banner {
        background-color: #e7f5ff; /* Màu sáng hơn cho banner */
        color: #f5a623;
        padding: 40px 0;
        text-align: center;
    }

    .banner h2 {
        font-size: 3rem;
        margin-bottom: 10px;
    }

    .banner p {
        font-size: 1.2rem;
        margin-bottom: 20px;
    }

    .banner .btn {
        background-color: #f5a623;
        padding: 10px 20px;
        font-size: 1.2rem;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }

    .banner .btn:hover {
        background-color: #e59b21;
    }

    /* Danh sách sách mới nhất */
    .book-list {
        padding: 20px;
        background-color: #fff;
        margin-top: 30px;
    }

    .book-list h2 {
        font-size: 2.5rem; /* Tăng kích thước tiêu đề phần sách */
        margin-bottom: 20px;
        text-align: center;
    }

    .book-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); /* Tăng kích thước thẻ sách */
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
    color: #f5a623;
    font-weight: bold;
    margin-bottom: 15px;
}

.book-card .btn {
    background-color: #28a745;
    padding: 10px 20px;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-top: auto; /* Đảm bảo nút luôn ở dưới cùng */
}

.book-card .btn:hover {
    background-color: #218838;
}


    /* Section not found books */
    .book-list p {
        font-size: 1.2rem;
        color: #ff4d4d;
        text-align: center;
    }

    /* User info in header */
    header .user-info {
        font-size: 1rem;
        color: #f5a623;
        margin-left: 10px;
        display: inline-block;
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
                <li><a href="index.php?action=books">📖 Sách</a></li>
                <li><a href="index.php?action=cart">🛒 Giỏ Hàng</a></li>
                <li><a href="index.php?action=order_history">📜 Lịch Sử Đơn Hàng</a></li>

                <!-- Kiểm tra nếu đã đăng nhập -->
                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="index.php?action=logout">🔓 Đăng Xuất</a></li>
                    <li class="user-info">👤 <?= htmlspecialchars($_SESSION['user']['username']); ?></li>
                <?php else: ?>
                    <li><a href="index.php?action=login">🔑 Đăng Nhập</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <!-- Banner -->
    <section class="banner">
        <h2>Chào mừng đến với BookStore 📖</h2>
        <p>Nơi hội tụ những cuốn sách hay nhất dành cho bạn.</p>
        <a href="index.php?action=books" class="btn">Khám Phá Ngay</a>
    </section>

    <!-- Danh sách sách mới nhất -->
    <section class="book-list">
        <h2>📚 Sách Mới Nhất</h2>

        <?php if (!empty($books)): ?> 
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
        <?php else: ?>
            <p>❌ Không có sách nào trong danh mục này.</p>
        <?php endif; ?>
    </section>

</body>
</html>
