<?php
class Comment {
    private $conn;
    private $table_name = "comments";

    public $id;
    public $chapter_id;
    public $user_id;
    public $user_role;
    public $noi_dung;
    public $ngay_binh_luan;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addComment() {
        $query = "INSERT INTO " . $this->table_name . " (chapter_id, user_id, noi_dung) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iis", $this->chapter_id, $this->user_id, $this->noi_dung);
        return $stmt->execute();
    }
    
    public function getCommentById($comment_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $comment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function canDeleteComment() {
        $comment = $this->getCommentById($this->id);
        if (!$comment) {
            return ["status" => "error", "message" => "Bình luận không tồn tại"];
        }
    
        if ($comment["user_id"] != $this->user_id && $this->user_role !== "admin") {
            return ["status" => "error", "message" => "Bạn không có quyền xóa bình luận này"];
        }
    
        return ["status" => "success", "message" => "Được phép xóa"];
    }
    public function deleteComment() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        
        if ($stmt->execute()) {
            return ["status" => "success", "message" => "Xóa bình luận thành công"];
        } else {
            return ["status" => "error", "message" => "Xóa bình luận thất bại"];
        }
    }
    
    
    public function getCommentsByChapter() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE chapter_id = ? ORDER BY ngay_binh_luan DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->chapter_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
