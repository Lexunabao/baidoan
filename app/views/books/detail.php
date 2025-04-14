<?php
if (!isset($book)) {
    echo "<h2>❌ Không tìm thấy sách!</h2>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📖 <?= htmlspecialchars($book['title']); ?></title>
    
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

        /* Chi tiết sách */
        .book-detail {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.15);
        }

        .book-info {
            display: flex;
            align-items: center;
            justify-content: center; /* Căn giữa theo chiều ngang */
            gap: 30px;
        }

        /* Định dạng hình ảnh sách */
        .book-info img {
            width: 350px;
            height: 500px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Định dạng thông tin sách */
        .book-meta {
            max-width: 400px;
        }

        .book-meta h2 {
            font-size: 26px;
            margin-bottom: 10px;
        }

        .book-meta p {
            font-size: 18px;
            margin: 5px 0;
        }

        .book-meta strong {
            font-weight: bold;
        }

        /* Định dạng nút */
        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 10px;
            background: #ff6600; /* Màu cam cho nút */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        .btn:hover {
            background: #cc5500;
        }

        .btn-cancel {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 10px;
            background: #777;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        .btn-cancel:hover {
            background: #555;
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
                <li><a href="index.php?action=books">📖 Danh Sách Sách</a></li>
                <li><a href="index.php?action=cart">🛒 Giỏ Hàng</a></li>
                <li><a href="index.php?action=logout">🔓 Đăng Xuất</a></li>
            </ul>
        </nav>
    </header>

    <section class="book-detail">
        <div class="book-info">
            <!-- Hình ảnh sách -->
            <?php 
            $imagePath = !empty($book['image']) ? "/PHP/baidoan/" . htmlspecialchars($book['image']) : "/PHP/baidoan/public/assets/images/no-image.png";
            ?>
            <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($book['title']); ?>"  
                 width="350" height="500"
                 onerror="this.onerror=null;this.src='/PHP/baidoan/public/assets/images/no-image.png';">
            
            <!-- Thông tin sách -->
            <div class="book-meta">
                <h2>📖 <?= htmlspecialchars($book['title']); ?></h2>
                <p>🖊️ Tác giả: <strong><?= htmlspecialchars($book['author']); ?></strong></p>
                <p>📂 Thể loại: <strong><?= htmlspecialchars($book['category_name']); ?></strong></p>
                <p class="price">💰 Giá: <strong><?= number_format($book['price'], 0, ',', '.'); ?> VNĐ</strong></p>
                <p>📜 Mô tả:</p>
                <p><?= nl2br(htmlspecialchars($book['description'])); ?></p>

                <a href="index.php?action=add_to_cart&id=<?= $book['id']; ?>" class="btn">🛒 Thêm vào Giỏ Hàng</a>
                <a href="index.php?action=books" class="btn-cancel">⬅️ Quay lại</a>
            </div>
        </div>
    </section>

</body>
</html>
