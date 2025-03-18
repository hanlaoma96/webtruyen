<?php
require_once __DIR__ . '/../backend/db.php';

class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy thông tin user theo ID
    public function getUserById($id) {
        $query = "SELECT id, username, email, role, created_at FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Cập nhật thông tin user
    public function updateUser($id, $username, $email) {
        $query = "UPDATE users SET username = ?, email = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssi", $username, $email, $id);
        return $stmt->execute();
    }

    // Xóa user (Chỉ admin hoặc chính chủ mới có quyền)
    public function deleteUser($id) {
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
