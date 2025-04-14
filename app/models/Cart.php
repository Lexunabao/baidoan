<?php
require_once 'Database.php';

class Cart {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getCartByUser($user_id) {
        $query = "SELECT cart.*, books.title, books.price FROM cart 
                  JOIN books ON cart.book_id = books.id 
                  WHERE cart.user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addToCart($user_id, $book_id, $quantity) {
        $query = "INSERT INTO cart (user_id, book_id, quantity) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$user_id, $book_id, $quantity]);
    }

    public function removeFromCart($cart_id) {
        $query = "DELETE FROM cart WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$cart_id]);
    }
}
?>
