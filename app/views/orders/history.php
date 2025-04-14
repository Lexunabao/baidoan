<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: index.php?action=login");
    exit();
}

require_once __DIR__ . '/../../controllers/OrderController.php';

$orderController = new OrderController();
$orders = $orderController->getOrdersByUserId($_SESSION['user']['id']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>📜 Lịch Sử Đơn Hàng</title>
    <link rel="stylesheet" href="/PHP/baidoan/public/assets/css/style.css">
</head>
<body>
<style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { width: 80%; margin: 30px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        h2 { text-align: center; color: #ff6600; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: center; }
        th { background: #ff6600; color: white; }
        .btn-view { background: #007bff; color: white; padding: 8px 12px; border-radius: 5px; text-decoration: none; }
        .btn-view:hover { opacity: 0.8; }
        .btn-back { background: #28a745; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; display: block; text-align: center; margin-top: 20px; }
    </style>

<div class="container">
    <h2>📜 Lịch Sử Đơn Hàng</h2>

    <table>
        <tr>
            <th>Mã Đơn Hàng</th>
            <th>Ngày Đặt</th>
            <th>Tổng Tiền</th>
            <th>Trạng Thái</th>
            <th>Hành Động</th>
        </tr>

        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td>#<?= htmlspecialchars($order['id']) ?></td>
                    <td><?= htmlspecialchars($order['created_at']) ?></td>
                    <td><?= number_format($order['total_amount'], 0, ',', '.') ?> VNĐ</td>
                    <td>
                        <?= ($order['status'] == 'pending') ? "⏳ Đang Xử Lý" : "✅ Hoàn Thành" ?>
                    </td>
                    <td>
                        <a href="index.php?action=view_order_detail&id=<?= htmlspecialchars($order['id']) ?>" class="btn-view">🔍 Xem Chi Tiết</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">🚫 Bạn chưa có đơn hàng nào.</td>
            </tr>
        <?php endif; ?>
    </table>

    <a href="index.php?action=home" class="btn-back">🏠 Quay lại Trang Chủ</a>
</div>

</body>
</html>
