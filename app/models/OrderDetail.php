<?php
require_once 'Database.php';

class OrderDetail {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function addOrderDetail($order_id, $book_id, $quantity, $price) {
        $query = "INSERT INTO order_details (order_id, book_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$order_id, $book_id, $quantity, $price]);
    }

    public function getOrderDetailsByOrderId($order_id) {
        $query = "SELECT od.*, 
                         b.title AS book_title, 
                         b.image AS book_image 
                  FROM order_details od
                  JOIN books b ON od.book_id = b.id 
                  WHERE od.order_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$order_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
