<?php
class Favorite {
    private $conn;
    private $table_name = "thich";

    public $user_id;
    public $truyen_id;
    public $liked_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Thêm truyện vào danh sách yêu thích
    public function addFavorite() {
        $query = "INSERT INTO " . $this->table_name . " (user_id, truyen_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $this->user_id, $this->truyen_id);
        return $stmt->execute();
    }

    // Xóa truyện khỏi danh sách yêu thích
    public function removeFavorite() {
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = ? AND truyen_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $this->user_id, $this->truyen_id);
        return $stmt->execute();
    }

    // Kiểm tra xem truyện đã được yêu thích chưa
    public function isFavorite() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = ? AND truyen_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $this->user_id, $this->truyen_id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    // Lấy danh sách truyện yêu thích của người dùng
    public function getFavorites() {
        $query = "SELECT t.truyen_id, t.liked_at, tr.ten_truyen 
                  FROM " . $this->table_name . " t 
                  JOIN truyen tr ON t.truyen_id = tr.id
                  WHERE t.user_id = ? 
                  ORDER BY t.liked_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
