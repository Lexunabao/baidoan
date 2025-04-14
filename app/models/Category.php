<?php
require_once 'Database.php';

class Category {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllCategories() {
        $query = "SELECT * FROM categories ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addCategory($name) {
        $query = "INSERT INTO categories (name) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$name]);
    }

    public function getCategoryById($id) {
        $query = "SELECT * FROM categories WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateCategory($id, $name) {
        $query = "UPDATE categories SET name = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$name, $id]);
    }

    public function deleteCategory($id) {
        $query = "DELETE FROM categories WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}

?>
