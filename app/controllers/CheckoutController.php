<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/OrderDetail.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

class CheckoutController {
    public function showCheckoutPage() {
        AuthMiddleware::checkAuth(); 

        if (empty($_SESSION['cart'])) {
            header("Location: index.php?action=cart&error=empty_cart");
            exit();
        }

        include __DIR__ . '/../views/checkout/index.php';
    }

    public function processCheckout() {
        AuthMiddleware::checkAuth();
    
        if (empty($_SESSION['cart'])) {
            header("Location: index.php?action=cart&error=empty_cart");
            exit();
        }
    
        $user_id = $_SESSION['user']['id'];
        $email = $_SESSION['user']['email']; 
        $full_name = trim($_POST['full_name']);
        $shipping_address = trim($_POST['address']);
        $phone = trim($_POST['phone']);
        $payment_method = trim($_POST['payment_method']);
    
     
        $validMethods = ['cod', 'bank_transfer', 'credit_card'];
        if (!in_array($payment_method, $validMethods)) {
            header("Location: index.php?action=checkout&error=invalid_payment");
            exit();
        }
    
        $totalAmount = 0;
        foreach ($_SESSION['cart'] as $book) {
            $totalAmount += $book['price'] * $book['quantity'];
        }
    
        $orderModel = new Order();
        $orderId = $orderModel->createOrder($user_id, $email, $full_name, $shipping_address, $phone, $payment_method, $totalAmount);
    
        if ($orderId) {
            $orderDetailModel = new OrderDetail();
            foreach ($_SESSION['cart'] as $bookId => $book) {
                $orderDetailModel->addOrderDetail($orderId, $bookId, $book['quantity'], $book['price']);
            }
    
            unset($_SESSION['cart']);
    
            header("Location: index.php?action=order_success&order_id=$orderId");
            exit();
        } else {
            header("Location: index.php?action=cart&error=checkout_failed");
            exit();
        }
    }
    
}
?>
