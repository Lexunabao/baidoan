<?php
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛒 Giỏ Hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #f5a623; /* Màu cam cho header */
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        header h1 {
            font-size: 2.5rem;
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
            font-size: 1.2rem;
        }

        header nav ul li a:hover {
            text-decoration: underline;
        }

        .cart-container {
            width: 80%;
            margin: 20px auto;
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
            background: #fff;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #ff6600;
            color: #fff;
        }

        td img {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }

        input[type="number"] {
            width: 50px;
            padding: 5px;
            text-align: center;
        }

        .cart-actions {
            text-align: right;
            margin-top: 15px;
        }

        .cart-actions a, .cart-actions button {
            display: inline-block;
            padding: 10px 15px;
            margin: 5px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-update {
            background: #007bff;
            color: #fff;
            border: none;
        }

        .btn-checkout {
            background: #28a745;
            color: #fff;
            border: none;
        }

        .btn-delete {
            background: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
        }

        .total-price {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>

<header>
    <h1>📚 BookStore</h1>
    <nav>
        <ul>
            <li><a href="index.php?action=home">🏠 Trang Chủ</a></li>
            <li><a href="index.php?action=books">📖 Sách</a></li>
            <li><a href="index.php?action=cart">🛒 Giỏ Hàng</a></li>
            <li><a href="index.php?action=logout">🔓 Đăng Xuất</a></li>
        </ul>
    </nav>
</header>

<div class="cart-container">
    <h2>🛒 Giỏ Hàng Của Bạn</h2>

    <?php if (!empty($_SESSION['cart'])): ?>
        <form action="index.php?action=update_cart" method="POST">
            <table>
                <tr>
                    <th>Hình</th>
                    <th>Tên Sách</th>
                    <th>Tác Giả</th>
                    <th>Giá</th>
                    <th>Số Lượng</th>
                    <th>Tổng</th>
                    <th>Hành Động</th>
                </tr>

                <?php $total = 0; ?>
                <?php foreach ($_SESSION['cart'] as $id => $book): ?>
                    <?php $subtotal = $book['price'] * $book['quantity']; ?>
                    <?php $total += $subtotal; ?>
                    <tr>
                        <td>
                            <?php 
                            // Kiểm tra đường dẫn ảnh và hiển thị ảnh từ thư mục uploads
                            $imagePath = !empty($book['image']) ? "/PHP/baidoan/" . htmlspecialchars($book['image']) : "/PHP/baidoan/public/assets/images/no-image.png";
                            ?>
                            <img src="<?= $imagePath ?>" width="80" height="100"
                                onerror="this.onerror=null;this.src='/PHP/baidoan/public/assets/images/no-image.png';">
                        </td>
                        <td><?= htmlspecialchars($book['title']) ?></td>
                        <td><?= htmlspecialchars($book['author']) ?></td>
                        <td><?= number_format($book['price'], 0, ',', '.'); ?> VNĐ</td>
                        <td>
                            <input type="number" name="quantity[<?= $id; ?>]" value="<?= $book['quantity']; ?>" min="1">
                        </td>
                        <td><?= number_format($subtotal, 0, ',', '.'); ?> VNĐ</td>
                        <td>
                            <a href="index.php?action=remove_from_cart&id=<?= $id; ?>" class="btn-delete">❌ Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <tr>
                    <td colspan="5" class="total-price">Tổng Cộng:</td>
                    <td class="total-price"><?= number_format($total, 0, ',', '.'); ?> VNĐ</td>
                    <td></td>
                </tr>
            </table>

            <div class="cart-actions">
                <button type="submit" class="btn-update">🔄 Cập Nhật</button>
                <a href="index.php?action=checkout" class="btn-checkout">✅ Thanh Toán</a>
            </div>
        </form>
    <?php else: ?>
        <p style="text-align: center; font-size: 18px;">🛒 Giỏ hàng của bạn đang trống.</p>
    <?php endif; ?>
</div>

</body>
</html>
