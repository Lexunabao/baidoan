<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/OrderDetail.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

class OrderController {
    private $conn;
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection(); 
    }
    public function userOrders() {
        AuthMiddleware::checkAuth();
        $orderModel = new Order();
        $user_id = $_SESSION['user']['id'];
        $orders = $orderModel->getOrdersByUser($user_id);
        include __DIR__ . '/../views/orders/index.php';
    }

    public function orderSuccess() {
        AuthMiddleware::checkAuth();

        if (!isset($_GET['order_id'])) {
            header("Location: index.php?action=home");
            exit();
        }

        $orderModel = new Order();
        $orderDetailModel = new OrderDetail();

        $order_id = $_GET['order_id'];  
        $order = $orderModel->getOrderById($order_id);
        $orderDetails = $orderDetailModel->getOrderDetailsByOrderId($order_id);

        if (!$order) {
            header("Location: index.php?action=home");
            exit();
        }

        include __DIR__ . '/../views/orders/success.php';
    }
    public function manageOrders() {
        AuthMiddleware::checkAdmin();
        $orderModel = new Order();
        $orders = $orderModel->getAllOrders();
        include __DIR__ . '/../views/admin/orders/index.php';
    }


  

    
    public function updateOrderStatus() {
        AuthMiddleware::checkAdmin();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id']) && isset($_POST['status'])) {
            $orderId = $_POST['order_id'];
            $status = $_POST['status'];

            $orderModel = new Order();
            $orderModel->updateOrderStatus($orderId, $status);

            header("Location: index.php?action=manage_orders&success=updated");
            exit();
        }
    }

 
    public function deleteOrder($orderId) {
        AuthMiddleware::checkAdmin();

        $orderModel = new Order();
        $orderModel->deleteOrder($orderId);

        header("Location: index.php?action=manage_orders&success=deleted");
        exit();
    }
    public function viewUserOrders() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit();
        }

        $user_id = $_SESSION['user']['id'];
        $orderModel = new Order();
        $orders = $orderModel->getOrdersByUserId($user_id);

        include __DIR__ . '/../views/orders/history.php';
    }
    public function getOrdersByUserId($userId) {
        $query = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getOrderDetailsByOrderId($orderId) {
        $query = "SELECT order_details.*, books.title AS book_title 
                  FROM order_details 
                  JOIN books ON order_details.book_id = books.id 
                  WHERE order_details.order_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getOrderById($orderId) {
        require_once __DIR__ . '/../models/Order.php';
        $orderModel = new Order();
        return $orderModel->getOrderById($orderId);
    }
    public function viewOrderDetail() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit();
        }
    
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: index.php?action=order_history&error=no_order_id");
            exit();
        }
    
        $orderId = $_GET['id'];
        $userId = $_SESSION['user']['id'];
    
        require_once __DIR__ . '/../models/Order.php';
        $orderModel = new Order();
    
   
        $order = $orderModel->getOrderById($orderId);
    
     
        if (!$order || ($order['user_id'] != $userId && $_SESSION['user']['role'] !== 'admin')) {
            echo "<h2>⛔ Bạn không có quyền truy cập trang này!</h2>";
            exit();
        }
    
        require_once __DIR__ . '/../models/OrderDetail.php';
        $orderDetailModel = new OrderDetail();
        $orderDetails = $orderDetailModel->getOrderDetailsByOrderId($orderId);
    
        include __DIR__ . '/../views/orders/order_detail.php';
    }
    
    
}
?>
