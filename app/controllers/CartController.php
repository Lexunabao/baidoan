<?php
require_once __DIR__ . '/../models/Book.php';

class CartController {
    public function addToCart($id) {
        $bookModel = new Book();
        $book = $bookModel->getBookById($id);

        if (!$book) {
            header("Location: index.php?action=books&error=not_found");
            exit();
        }

      
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$id] = [
                'id' => $book['id'],
                'title' => $book['title'],
                'author' => $book['author'],
                'price' => $book['price'],
                'image' => $book['image'],
                'quantity' => 1
            ];
        }

        header("Location: index.php?action=cart&success=added");
        exit();
    }

    public function viewCart() {
        include __DIR__ . '/../views/cart/index.php';
    }

    public function removeFromCart($id) {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header("Location: index.php?action=cart");
        exit();
    }

    public function updateCart() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            foreach ($_POST['quantity'] as $id => $quantity) {
                if (isset($_SESSION['cart'][$id])) {
                    $_SESSION['cart'][$id]['quantity'] = max(1, intval($quantity));
                }
            }
        }
        header("Location: index.php?action=cart");
        exit();
    }
}
?>
