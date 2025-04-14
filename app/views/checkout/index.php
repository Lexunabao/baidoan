<?php
if (!isset($_SESSION['user'])) {
    header("Location: index.php?action=login");
    exit();
}

if (empty($_SESSION['cart'])) {
    header("Location: index.php?action=cart&error=empty_cart");
    exit();
}

$totalAmount = 0;
foreach ($_SESSION['cart'] as $book) {
    $totalAmount += $book['price'] * $book['quantity'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛒 Thanh Toán</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .checkout-container {
            width: 50%;
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

        .order-summary {
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .order-summary h3 {
            color: #333;
        }

        .cart-items {
            margin-bottom: 20px;
        }

        .cart-items table {
            width: 100%;
            border-collapse: collapse;
        }

        .cart-items th, .cart-items td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .cart-items th {
            background: #ff6600;
            color: #fff;
        }

        .cart-items img {
            width: 70px;
            height: 90px;
            object-fit: cover;
            border-radius: 5px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .payment-options {
            display: flex;
            justify-content: space-between;
        }

        .payment-options label {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
        }

        .btn-back {
            background: #007bff;
            color: #fff;
        }

        .btn-pay {
            background: #28a745;
            color: #fff;
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

<div class="checkout-container">
    <h2>🛍️ Thanh Toán</h2>

    <div class="order-summary">
        <h3>📋 Đơn Hàng Của Bạn</h3>
        <div class="cart-items">
            <table>
                <tr>
                    <th>Hình</th>
                    <th>Tên Sách</th>
                    <th>Số Lượng</th>
                    <th>Giá</th>
                </tr>
                <?php foreach ($_SESSION['cart'] as $book): ?>
                <tr>
                    <td><img src="/PHP/baidoan/<?= htmlspecialchars($book['image']) ?>" onerror="this.onerror=null;this.src='/PHP/baidoan/public/assets/images/no-image.png';"></td>
                    <td><?= htmlspecialchars($book['title']) ?></td>
                    <td><?= $book['quantity'] ?></td>
                    <td><?= number_format($book['price'] * $book['quantity'], 0, ',', '.'); ?> VNĐ</td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <p><strong>💰 Tổng cộng: <?= number_format($totalAmount, 0, ',', '.'); ?> VNĐ</strong></p>
    </div>

    <form action="index.php?action=process_checkout" method="POST">
    <div class="input-group">
        <label for="full_name">👤 Họ và Tên:</label>
        <input type="text" name="full_name" required>
    </div>

    <div class="input-group">
        <label for="address">📍 Địa Chỉ Giao Hàng:</label>
        <input type="text" name="address" required>
    </div>

    <div class="input-group">
        <label for="phone">📞 Số Điện Thoại:</label>
        <input type="text" name="phone" required>
    </div>

    <div class="input-group">
        <label for="payment_method">💳 Phương Thức Thanh Toán:</label>
        <select name="payment_method" required>
            <option value="cod">Thanh toán khi nhận hàng (COD)</option>
            <option value="bank_transfer">Chuyển khoản ngân hàng</option>
            <option value="credit_card">Thẻ tín dụng/Ghi nợ</option>
        </select>
    </div>

    <div class="btn-group">
        <a href="index.php?action=cart" class="btn btn-back">⬅️ Quay lại Giỏ Hàng</a>
        <button type="submit" class="btn btn-pay">💳 Thanh Toán</button>
    </div>
</form>

</div>


</body>
</html>
