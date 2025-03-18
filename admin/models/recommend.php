<?php
class Recommend {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy danh sách truyện được đề xuất dựa trên lịch sử đọc
    public function getRecommendations($user_id, $limit = 10) {
        $query = "SELECT t.id, t.ten_truyen, t.anh_bia, t.luot_xem
                  FROM history h
                  JOIN truyen t ON h.truyen_id = t.id
                  WHERE h.user_id = ?
                  GROUP BY t.id, t.ten_truyen, t.anh_bia, t.luot_xem
                  ORDER BY MAX(h.last_read) DESC
                  LIMIT ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $user_id, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        $recommendations = [];
        while ($row = $result->fetch_assoc()) {
            $recommendations[] = $row;
        }

        return $recommendations;
    }
}
?>