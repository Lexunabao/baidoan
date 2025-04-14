<?php

require_once __DIR__ . '/../../controllers/OrderController.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php?action=login");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php?action=order_history&error=no_order_id");
    exit();
}

$orderController = new OrderController();
$order = $orderController->getOrderById($_GET['id']);
$orderDetails = $orderController->getOrderDetailsByOrderId($_GET['id']);

if (!$order) {
    echo "<h2>❌ Lỗi: Không tìm thấy đơn hàng!</h2>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>📦 Chi Tiết Đơn Hàng #<?= htmlspecialchars($order['id']) ?></title>
    <link rel="stylesheet" href="/PHP/baidoan/public/assets/css/style.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { width: 60%; margin: 30px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        h2 { text-align: center; color: #ff6600; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: center; }
        th { background: #ff6600; color: white; }
        .btn-back { background: #007bff; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; display: block; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <h2>📦 Chi Tiết Đơn Hàng #<?= htmlspecialchars($order['id']) ?></h2>

    <p>👤 Người Đặt: <strong><?= htmlspecialchars($order['username']) ?></strong></p>
    <p>💰 Tổng Tiền: <strong><?= number_format($order['total_amount'], 0, ',', '.') ?> VNĐ</strong></p>
    <p>📅 Ngày Đặt: <strong><?= htmlspecialchars($order['created_at']) ?></strong></p>
    <p>📍 Địa Chỉ: <strong><?= htmlspecialchars($order['shipping_address']) ?></strong></p>
    <p>💳 Phương Thức Thanh Toán: <strong><?= htmlspecialchars($order['payment_method']) ?></strong></p>

    <h3>📚 Danh Sách Sản Phẩm</h3>

    <table>
        <tr>
            <th>Tên Sách</th>
            <th>Số Lượng</th>
            <th>Giá</th>
            <th>Tổng</th>
        </tr>
        <?php foreach ($orderDetails as $detail): ?>
            <tr>
            <td><?= htmlspecialchars($detail['book_title']) ?></td>
            <td><?= $detail['quantity'] ?></td>
            <td><?= number_format($detail['price'], 0, ',', '.'); ?> VNĐ</td>
            <td><?= number_format($detail['quantity'] * $detail['price'], 0, ',', '.'); ?> VNĐ</td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="index.php?action=admin_home" class="btn-back">⬅️ Quay lại </a>
</div>

</body>
</html>
