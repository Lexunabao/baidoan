<?php  ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 Admin Panel</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
        }

        /* Admin container */
        .admin-container {
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #333;
            color: white;
            padding: 20px;
            height: 100vh;
        }

        .sidebar h2 {
            font-size: 24px;
            margin-bottom: 30px;
            text-align: center;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            display: flex;
            align-items: center;
            padding: 8px 0;
        }

        .sidebar ul li a:hover {
            background-color: #444;
            border-radius: 5px;
        }

        .sidebar ul li a i {
            margin-right: 10px;
        }

        /* Nội dung chính */
        .admin-content {
            flex-grow: 1;
            padding: 30px;
            background-color: #fff;
        }

        .admin-content h1 {
            font-size: 32px;
            color: #333;
            margin-bottom: 20px;
        }

        .admin-content p {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
        }

        .admin-dashboard {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .admin-dashboard h3 {
            font-size: 24px;
            color: #ff6600;
            margin-bottom: 20px;
        }

        .stats {
            display: flex;
            justify-content: space-between;
        }

        .stat-box {
            width: 22%;
            background-color: #ff6600;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .stat-box i {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .stat-box p {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-box span {
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div class="admin-container">
        <!-- Sidebar - Thanh điều hướng -->
        <nav class="sidebar">
            <h2>📚 Admin Panel</h2>
            <ul>
                <li><a href="index.php?action=admin_home"><i class="fas fa-home"></i> Trang Chủ</a></li>
                <li><a href="index.php?action=manage_books"><i class="fas fa-book"></i> Quản lý Sách</a></li>
                <li><a href="index.php?action=manage_categories"><i class="fas fa-layer-group"></i> Quản lý Thể loại</a></li>
                <li><a href="index.php?action=manage_users"><i class="fas fa-users"></i> Quản lý Người Dùng</a></li>
                <li><a href="index.php?action=manage_orders"><i class="fas fa-box"></i> Quản lý Đơn Hàng</a></li>
                <li><a href="index.php?action=logout"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a></li>
            </ul>
        </nav>

        <!-- Nội dung chính -->
        <main class="admin-content">
            <h1>Xin chào, Admin <?= htmlspecialchars($_SESSION['user']['username']); ?>! 👋</h1>
            <p>Chào mừng bạn đến với hệ thống quản lý BookStore.</p>

            <section class="admin-dashboard">
                <h3>📊 Thống kê nhanh</h3>
                <div class="stats">
                    <div class="stat-box">
                        <i class="fas fa-book"></i>
                        <p>120</p>
                        <span>Sách</span>
                    </div>
                    <div class="stat-box">
                        <i class="fas fa-layer-group"></i>
                        <p>10</p>
                        <span>Thể loại</span>
                    </div>
                    <div class="stat-box">
                        <i class="fas fa-users"></i>
                        <p>45</p>
                        <span>Người dùng</span>
                    </div>
                    <div class="stat-box">
                        <i class="fas fa-box"></i>
                        <p>30</p>
                        <span>Đơn hàng</span>
                    </div>
                </div>
            </section>
        </main>
    </div>

</body>
</html>
