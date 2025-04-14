<?php
require_once __DIR__ . '/../models/Book.php';

class BookController {
    public function index() {
        $bookModel = new Book();
        $books = $bookModel->getAllBooks();
    
       
        if (!$books) {
            echo "<pre>";
            print_r($books);
            echo "</pre>";
            die("❌ Không có sách nào hoặc lỗi trong truy vấn database!");
        }
    
        include __DIR__ . '/../views/admin/books/index.php';
        exit();
    }
    
    

    public function getLastBooks() {
        $bookModel = new Book();
        return $bookModel->getLastBooks();
    }

    
    
        public function create() {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $title = trim($_POST['title']);
                $author = trim($_POST['author']);
                $price = floatval($_POST['price']);
                $description = trim($_POST['description']);
                $category_id = intval($_POST['category_id']);
                $imagePath = "public/assets/images/no-image.png";
    
                if (!empty($_FILES['image']['name'])) {
                    $targetDir = __DIR__ . '/../../public/assets/images/';
                    if (!is_dir($targetDir)) {
                        mkdir($targetDir, 0777, true);
                    }
    
                    $fileName = time() . "_" . basename($_FILES["image"]["name"]);
                    $targetFilePath = $targetDir . $fileName;
                    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    
                    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                    if (in_array($fileType, $allowedTypes) && move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                        $imagePath = "public/assets/images/" . $fileName;
                    }
                }
    
                $bookModel = new Book();
                if ($bookModel->addBook($title, $author, $price, $description, $imagePath, $category_id)) {
                    header("Location: index.php?action=manage_books&success=1");
                    exit();
                } else {
                    header("Location: index.php?action=add_book&error=db_error");
                    exit();
                }
            }
            include __DIR__ . '/../views/admin/books/add.php';
        }     
    
    public function edit($id) {
        $bookModel = new Book();
        $book = $bookModel->getBookById($id);
    
      
        if (!$book) {
            header("Location: index.php?action=manage_books&error=book_not_found");
            exit();
        }
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = trim($_POST['title']);
            $author = trim($_POST['author']);
            $price = floatval($_POST['price']);
            $description = trim($_POST['description']);
            $category_id = intval($_POST['category_id']);
    
           
            if (!empty($_FILES['image']['name'])) {
                $targetDir = __DIR__ . '/../../public/uploads/';
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
    
                $fileName = time() . "_" . basename($_FILES["image"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array($fileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                        $imagePath = "public/uploads/" . $fileName;
                    } else {
                        header("Location: index.php?action=edit_book&id=$id&error=upload_failed");
                        exit();
                    }
                } else {
                    header("Location: index.php?action=edit_book&id=$id&error=invalid_format");
                    exit();
                }
            } else {
                $imagePath = $book['image']; 
            }
    
            
            if ($bookModel->updateBook($id, $title, $author, $price, $description, $imagePath, $category_id)) {
                header("Location: index.php?action=manage_books&success=2");
                exit();
            } else {
                header("Location: index.php?action=edit_book&id=$id&error=db_error");
                exit();
            }
        }
    
        include __DIR__ . '/../views/admin/books/edit.php';
    }
    
    
    public function delete($id) {
        $bookModel = new Book();
        if ($bookModel->deleteBook($id)) {
            header("Location: index.php?action=manage_books&success=3");
        } else {
            header("Location: index.php?action=manage_books&error=delete_failed");
        }
        exit();
    }
    public function listAllBooks() {
        $bookModel = new Book();
        $categoriesModel = new Category(); 
        $categories = $categoriesModel->getAllCategories();
    
        
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
    
        if (!empty($keyword)) {
            $books = $bookModel->searchBooks($keyword);
        } elseif ($category_id > 0) {
            $books = $bookModel->getBooksByCategory($category_id);
        } else {
            $books = $bookModel->getAllBooks();
        }
    
        include __DIR__ . '/../views/books/index.php';
    }
    public function bookDetail($id) {
        $bookModel = new Book();
        $book = $bookModel->getBookById($id);
    
        if (!$book) {
            echo "<h2>❌ Không tìm thấy sách!</h2>";
            exit();
        }
    
        include __DIR__ . '/../views/books/detail.php';
    }
    
    
}
?>
