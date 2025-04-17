<?php
require_once 'Database.php';

class Book {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllBooks() {
        $query = "SELECT books.*, categories.name AS category_name FROM books 
                  LEFT JOIN categories ON books.category_id = categories.id";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt->execute()) {
            die("❌ Lỗi truy vấn database: " . implode(" ", $stmt->errorInfo()));
        }
    
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if (!$books) {
            return []; // Nếu không có sách, trả về mảng rỗng thay vì null
        }
    
        return $books;
    }
    
    public function searchBooks($keyword) {
        $query = "SELECT * FROM books WHERE title LIKE ? OR author LIKE ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(["%$keyword%", "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getBookById($id) {
        $query = "SELECT books.*, categories.name AS category_name 
                  FROM books 
                  LEFT JOIN categories ON books.category_id = categories.id 
                  WHERE books.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getTotalBooks() {
        $sql = "SELECT COUNT(*) AS total FROM books";
        $result = $this->conn->query($sql);  
        $row = $result->fetch(PDO::FETCH_ASSOC);  
        return $row['total'];
    }
    

    public function getBooksWithLimit($offset, $limit) {
        $sql = "SELECT * FROM books LIMIT $offset, $limit";
        $result = $this->conn->query($sql);  
        $books = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) { 
            $books[] = $row;
        }
        return $books;
    }
    public function getBooksWithPagination($offset, $limit) {
        $query = "SELECT books.*, categories.name AS category_name FROM books 
                  LEFT JOIN categories ON books.category_id = categories.id 
                  LIMIT :offset, :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function addBook($title, $author, $price, $description, $imagePath, $category_id) {
        $query = "INSERT INTO books (title, author, price, description, image, category_id, created_at) 
                  VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$title, $author, $price, $description, $imagePath, $category_id]);
    }

    public function updateBook($id, $title, $author, $price, $description, $imagePath, $category_id) {
        $query = "UPDATE books SET title = ?, author = ?, price = ?, description = ?, image = ?, category_id = ? 
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$title, $author, $price, $description, $imagePath, $category_id, $id]);
    }

    public function deleteBook($id) {
        $query = "DELETE FROM books WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
    public function getLastBooks() {
        try {
            $query = "SELECT * FROM books ORDER BY created_at DESC LIMIT 5";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    public function getBooksByCategory($category_id) {
        $query = "SELECT * FROM books WHERE category_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$category_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
