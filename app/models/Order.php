<?php
require_once 'Database.php';

class Order {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function createOrder($user_id, $email, $full_name, $shipping_address, $phone, $payment_method, $totalAmount) {
        $query = "INSERT INTO orders (user_id, email, full_name, shipping_address, phone, payment_method, total_amount, status) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id, $email, $full_name, $shipping_address, $phone, $payment_method, $totalAmount]);
    
        return $this->conn->lastInsertId();
    }
    
    
    

    public function getOrderById($order_id) {
        $query = "SELECT orders.*, users.username FROM orders 
                  JOIN users ON orders.user_id = users.id 
                  WHERE orders.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getOrdersByUser($user_id) {
        $query = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllOrders() {
        $query = "SELECT * FROM orders ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    
    public function updateOrderStatus($orderId, $status) {
        $query = "UPDATE orders SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$status, $orderId]);
    }

    
    public function deleteOrder($orderId) {
        $query = "DELETE FROM orders WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$orderId]);
    }
    public function getOrdersByUserId($user_id) {
        $query = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

}
?>
