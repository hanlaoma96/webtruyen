<?php
class History {
    private $conn;
    private $table_name = "history";

    public $id;
    public $user_id;
    public $truyen_id;
    public $chapter_id;
    public $last_read;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    // Thêm lịch sử đọc
    public function addHistory() {
        $query = "INSERT INTO " . $this->table_name . " (user_id, truyen_id, chapter_id, last_read)
                  VALUES (?, ?, ?, NOW())
                  ON DUPLICATE KEY UPDATE chapter_id = VALUES(chapter_id), last_read = NOW()";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $this->user_id, $this->truyen_id, $this->chapter_id);
        return $stmt->execute();
    }

    // Lấy lịch sử đọc của user
    public function getHistory() {
        $query = "SELECT h.truyen_id, t.ten_truyen, h.chapter_id, c.ten_chapter, h.last_read
                  FROM " . $this->table_name . " h
                  JOIN truyen t ON h.truyen_id = t.id
                  JOIN chapters c ON h.chapter_id = c.id
                  WHERE h.user_id = ?
                  ORDER BY h.last_read DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Xóa toàn bộ lịch sử đọc của user 
    public function clearHistory() {
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->user_id);
        return $stmt->execute();
    }
}
?>
