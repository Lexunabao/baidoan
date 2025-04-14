<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>📦 Quản Lý Đơn Hàng</title>
    <link rel="stylesheet" href="/PHP/baidoan/public/assets/css/admin.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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

        .action-buttons {
            text-align: center;
            margin-top: 20px;
        }

        .btn-detail, .btn-back {
            display: inline-block;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn-detail {
            background: #28a745;
            color: white;
        }

        .btn-back {
            background: #007bff;
            color: white;
        }

        .btn-detail:hover, .btn-back:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📦 Quản Lý Đơn Hàng</h2>

    <table>
        <tr>
            <th>Mã Đơn Hàng</th>
            <th>Khách Hàng</th>
            <th>📞 Số Điện Thoại</th>
            <th>📍 Địa Chỉ</th>
            <th>💳 Thanh Toán</th>
            <th>💰 Tổng Tiền</th>
            <th>📅 Ngày Đặt</th>
            <th>🔍 Chi Tiết</th>
        </tr>

        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td>#<?= $order['id'] ?></td>
                    <td><?= htmlspecialchars($order['full_name']) ?> (<?= htmlspecialchars($order['email']) ?>)</td>
                    <td><?= htmlspecialchars($order['phone']) ?></td>
                    <td><?= htmlspecialchars($order['shipping_address']) ?></td>
                    <td>
                        <?= ($order['payment_method'] == 'cod') ? "Thanh toán khi nhận hàng" : 
                             (($order['payment_method'] == 'bank_transfer') ? "Chuyển khoản" : "Thẻ tín dụng") ?>
                    </td>
                    <td><?= number_format($order['total_amount'], 0, ',', '.') ?> VNĐ</td>
                    <td><?= $order['created_at'] ?></td>
                    <td>
                        <a href="index.php?action=view_order_detail&id=<?= $order['id'] ?>" class="btn-detail">
                            📜 Xem Chi Tiết
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">🚫 Không có đơn hàng nào.</td>
            </tr>
        <?php endif; ?>
    </table>

    <div class="action-buttons">
        <a href="index.php?action=admin_home" class="btn-back">⬅️ Quay lại Trang Chính</a>
    </div>
</div>

</body>
</html>
