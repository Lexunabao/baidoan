<?php 
require_once 'Database.php';
class User {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection(); // Sửa dbConnection() thành getConnection()
    }

    public function register($username, $email, $password) {
        
        $query = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username, $email]);

        if ($stmt->rowCount() > 0) {
            return false;
        }

        // Mã hóa mật khẩu trước khi lưu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$username, $email, $hashed_password]);
    }

    public function login($username, $password) {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
    public function getAllUsers() {
        $query = "SELECT id, username, email, role FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function updateUserRole($id, $role) {
        $stmt = $this->conn->prepare("UPDATE users SET role = ? WHERE id = ?");
        return $stmt->execute([$role, $id]);
    }
    public function updateUser($id, $username, $email, $password, $role) {
        if ($password) {
            $stmt = $this->conn->prepare("UPDATE users SET username = ?, email = ?, password = ?, role = ? WHERE id = ?");
            return $stmt->execute([$username, $email, $password, $role, $id]);
        } else {
            $stmt = $this->conn->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
            return $stmt->execute([$username, $email, $role, $id]);
        }
    }

}

?>