<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>📦 Chi Tiết Đơn Hàng</title>
    <link rel="stylesheet" href="/PHP/baidoan/public/assets/css/admin.css">
    <style>
        .order-detail-container {
            width: 70%;
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
        .order-info {
            padding: 15px;
            border-bottom: 2px solid #ff6600;
            margin-bottom: 15px;
        }
        .order-info p {
            font-size: 16px;
            margin: 8px 0;
        }
        .order-info strong {
            color: #333;
        }
        .table-container {
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #ff6600;
            color: white;
        }
        .action-btns {
            text-align: center;
            margin-top: 20px;
        }
        .back-btn {
            text-decoration: none;
            background: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
        }
        .back-btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

<div class="order-detail-container">
    <h2>📦 Chi Tiết Đơn Hàng #<?= $order['id'] ?></h2>

    <div class="order-info">
        <p>🆔 <strong>Mã Đơn Hàng:</strong> <?= $order['id'] ?></p>
        <p>👤 <strong>Người Đặt:</strong> <?= htmlspecialchars($order['full_name']) ?> (Email: <?= htmlspecialchars($order['email']) ?>)</p>
        <p>📞 <strong>Số Điện Thoại:</strong> <?= htmlspecialchars($order['phone']) ?></p>
        <p>📍 <strong>Địa Chỉ Giao Hàng:</strong> <?= htmlspecialchars($order['shipping_address']) ?></p>
        <p>💳 <strong>Phương Thức Thanh Toán:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
        <p>💰 <strong>Tổng Tiền:</strong> <?= number_format($order['total_amount'], 0, ',', '.') ?> VNĐ</p>
        <p>📅 <strong>Ngày Đặt:</strong> <?= $order['created_at'] ?></p>
    </div>

    <h3>📚 Danh Sách Sản Phẩm</h3>

    <table>
    <tr>
        <th>Hình</th>
        <th>Tên Sách</th>
        <th>Số Lượng</th>
        <th>Giá</th>
        <th>Tổng</th>
    </tr>
    <?php foreach ($orderDetails as $detail): ?>
        <tr>
            <td>
                <?php 
                $imagePath = !empty($detail['book_image']) ? "/PHP/baidoan/" . htmlspecialchars($detail['book_image']) : "/PHP/baidoan/public/assets/images/no-image.png";
                ?>
                <img src="<?= $imagePath ?>" width="120" height="160"
                     onerror="this.onerror=null;this.src='/PHP/baidoan/public/assets/images/no-image.png';">
            </td>
            <td><?= htmlspecialchars($detail['book_title']) ?></td>
            <td><?= $detail['quantity'] ?></td>
            <td><?= number_format($detail['price'], 0, ',', '.'); ?> VNĐ</td>
            <td><?= number_format($detail['quantity'] * $detail['price'], 0, ',', '.'); ?> VNĐ</td>
        </tr>
    <?php endforeach; ?>
</table>

    <div class="action-btns">
        <a href="index.php?action=manage_orders" class="back-btn">⬅️ Quay lại</a>
    </div>
</div>

</body>
</html>
