<?php
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';


class CategoryController {
    public function index() {
        AuthMiddleware::checkAdmin();
        $categoryModel = new Category();
        $categories = $categoryModel->getAllCategories();
        include __DIR__ . '/../views/admin/categories/index.php';

    }
    public function getAllCategories() {
        require_once __DIR__ . '/../models/Category.php';
        $categoryModel = new Category();
        return $categoryModel->getAllCategories();
    }
    public function create() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = trim($_POST['name']);

            if (empty($name)) {
                $error = "Tên danh mục không được để trống!";
            } else {
                $categoryModel = new Category();
                if ($categoryModel->addCategory($name)) {
                    header("Location: index.php?action=manage_categories&success=1");
                    exit();
                } else {
                    $error = "Lỗi! Không thể thêm danh mục.";
                }
            }
        }
        include __DIR__ . '/../views/admin/categories/add.php';
    }

    public function edit($id) {
        $categoryModel = new Category();
        $category = $categoryModel->getCategoryById($id);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = trim($_POST['name']);
            if (!empty($name)) {
                if ($categoryModel->updateCategory($id, $name)) {
                    header("Location: index.php?action=manage_categories&success=2");
                    exit();
                } else {
                    $error = "Lỗi! Không thể cập nhật danh mục.";
                }
            } else {
                $error = "Tên danh mục không được để trống!";
            }
        }
        include __DIR__ . '/../views/admin/categories/edit.php';
    }

    public function delete($id) {
        $categoryModel = new Category();
        if ($categoryModel->deleteCategory($id)) {
            header("Location: index.php?action=manage_categories&success=3");
        } else {
            header("Location: index.php?action=manage_categories&error=1");
        }
        exit();
    }
}

?>
