
<?php
require_once __DIR__ . '/../app/controllers/BookController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/CartController.php';
require_once __DIR__ . '/../app/controllers/OrderController.php';
require_once __DIR__ . '/../app/controllers/CategoryController.php';
require_once __DIR__ . '/../app/middleware/AuthMiddleware.php';
require_once __DIR__ . '/../app/controllers/CheckoutController.php'; 
require_once __DIR__ . '/../app/controllers/UserController.php';
$userController = new UserController();
$bookController = new BookController();
$authController = new AuthController();
$cartController = new CartController();
$orderController = new OrderController();
$categoryController = new CategoryController();
$checkoutController = new CheckoutController();


if (!empty($_GET['action'])) {
    switch ($_GET['action']) {
     
        case 'home':
            if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
                header("Location: index.php?action=login");
                exit();
            }
            include __DIR__ . '/../app/views/home.php';  // Chắc chắn file này tồn tại
            exit();

        // 🔹 Trang admin
        case 'admin_home':
            if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
                header("Location: index.php?action=login");
                exit();
            }

          
            $adminFile = __DIR__ . '/../app/views/admin/index.php';
            if (file_exists($adminFile)) {
                include $adminFile;
            } else {
                echo "<h2>❌ Lỗi: Không tìm thấy trang quản trị!</h2>";
                echo "<p>Vui lòng kiểm tra lại thư mục <b>views/admin/index.php</b>.</p>";
            }
            exit();
           
     
        case 'login':
            if (isset($_SESSION['user'])) {
                if ($_SESSION['user']['role'] === 'admin') {
                    header("Location: index.php?action=admin_home");
                } else {
                    header("Location: index.php?action=home");
                }
                exit();
            }
            $authController->login();
            exit();


        case 'register':
            $authController->register();
            exit();

        
        case 'logout':
            $authController->logout();
            exit();
            case 'add_to_cart':
                if (isset($_GET['id'])) {
                    $cartController->addToCart($_GET['id']);
                }
                exit();
            
            case 'cart':
                $cartController->viewCart();
                exit();
            
            case 'remove_from_cart':
                if (isset($_GET['id'])) {
                    $cartController->removeFromCart($_GET['id']);
                }
                exit();
            
            case 'update_cart':
                $cartController->updateCart();
                exit();
            
                case 'checkout':
                    $checkoutController = new CheckoutController();
                    $checkoutController->showCheckoutPage();
                    exit();
                
                case 'process_checkout':
                    $checkoutController = new CheckoutController();
                    $checkoutController->processCheckout();
                    exit();
                
                    case 'complete_checkout':
                        require_once __DIR__ . '/../app/controllers/CheckoutController.php';
                        $checkoutController = new CheckoutController();
                        $checkoutController->processCheckout(); // Gọi hàm xử lý thanh toán
                        exit();
                        case 'order_success':
                            include __DIR__ . '/../app/views/checkout/success.php';
                            exit();
                        
                    

        case 'my_orders':
            if (!isset($_SESSION['user'])) {
                header("Location: index.php?action=login");
                exit();
            }
            $orderController->userOrders();
            exit();

        case 'categories':
            $categoryController->index();
            exit();

        case 'create_category':
            $categoryController->create();
            exit();

        case 'delete_category':
            if (isset($_GET['id'])) {
                $categoryController->delete($_GET['id']);
            }
            exit();
            case 'manage_books':
                $bookController = new BookController();
                $books = $bookController->index();
                include __DIR__ . '/../app/views/admin/books/index.php';
                exit();
            
                case 'add_book':
                    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
                        header("Location: index.php?action=login");
                        exit();
                    }
                
                    $bookController = new BookController();
                
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $bookController->create(); 
                    } else {
                        include __DIR__ . '/../app/views/admin/books/add.php';
                    }
                    exit();
                
                    case 'edit_book':
                        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
                            header("Location: index.php?action=login");
                            exit();
                        }
                    
                        if (!isset($_GET['id']) || empty($_GET['id'])) {
                            header("Location: index.php?action=manage_books&error=missing_id");
                            exit();
                        }
                    
                        $bookController = new BookController();
                    
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $bookController->edit($_GET['id']); 
                        } else {
                            $bookController->edit($_GET['id']); 
                        }
                        exit();
                    
                    
            
            case 'delete_book':
                if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin' || !isset($_GET['id'])) {
                    header("Location: index.php?action=manage_books");
                    exit();
                }
                require_once __DIR__ . '/../app/controllers/BookController.php';
                $bookController = new BookController();
                $bookController->delete($_GET['id']);
                exit();
                case 'manage_categories':
                    $categoryController = new CategoryController();
                    $categoryController->index();
                    exit();
                
                case 'add_category':
                    $categoryController = new CategoryController();
                    $categoryController->create();
                    exit();
                
                case 'edit_category':
                    $categoryController = new CategoryController();
                    $categoryController->edit($_GET['id']);
                    exit();
                
                case 'delete_category':
                    $categoryController = new CategoryController();
                    $categoryController->delete($_GET['id']);
                    exit();
                
                    case 'books': 
                        $bookController->listAllBooks();
                        exit();
                        case 'book_detail': 
                            if (isset($_GET['id'])) {
                                $bookController->bookDetail($_GET['id']);
                            } else {
                                echo "<h2>❌ Không tìm thấy sách!</h2>";
                            }
                            exit();
                            case 'manage_orders':
                                $orderController->manageOrders();
                                exit();
                            
                            case 'view_order_detail':
                                if (isset($_GET['id'])) {
                                    $orderController->viewOrderDetail($_GET['id']);
                                }
                                exit();
                            
                            case 'delete_order':
                                if (isset($_GET['id'])) {
                                    $orderController->deleteOrder($_GET['id']);
                                }
                                exit();
                            
                                case 'manage_users':
                                    $userController = new UserController();
                                    $userController->index();
                                    exit();
                                
                                case 'delete_user':
                                    $userController = new UserController();
                                    $userController->deleteUser();
                                    exit();
                                
                                case 'edit_user':
                                    $userController = new UserController();
                                    $userController->editUser();
                                    exit();
                                    case 'update_user':
                                        $userController = new UserController();
                                        $userController->updateUser();
                                        exit();
                                        case 'order_history':
                                            require_once __DIR__ . '/../app/controllers/OrderController.php';
                                            $orderController = new OrderController();
                                            $orderController->viewUserOrders();
                                            exit();
                                            case 'view_order_detail':
                                                require_once __DIR__ . '/../app/controllers/OrderController.php';
                                                $orderController = new OrderController();
                                                $orderController->viewOrderDetail();
                                                exit();
                                                    
                                        

   
        default:
            echo "<h2>⚠️ Trang không tồn tại!</h2>";
            exit();
    }

    
}



if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] === 'admin') {
        header("Location: index.php?action=admin_home");
    } else {
        header("Location: index.php?action=home");
    }
    exit();
} else {
    header("Location: index.php?action=login");
    exit();
}
?>
