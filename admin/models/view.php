<?php
class View {
    private $conn;
    private $table_name = "luot_xem";

    public $id;
    public $truyen_id;
    public $user_id;
    public $viewed_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Thêm lượt xem mới
    public function addView() {
        $query = "INSERT INTO " . $this->table_name . " (truyen_id, user_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $this->truyen_id, $this->user_id);
        return $stmt->execute();
    }

    // Lấy tổng số lượt xem của một truyện
    public function getTotalViews($truyen_id) {
        $query = "SELECT COUNT(*) as total_views FROM " . $this->table_name . " WHERE truyen_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $truyen_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result["total_views"];
    }

    // Lấy top truyện có nhiều lượt xem nhất
    public function getTopViews($limit = 10) {
        $query = "SELECT truyen.id, truyen.ten_truyen, truyen.tac_gia, 
                         COALESCE(COUNT(luot_xem.id), 0) AS total_views 
                  FROM truyen 
                  LEFT JOIN luot_xem ON truyen.id = luot_xem.truyen_id 
                  GROUP BY truyen.id, truyen.ten_truyen, truyen.tac_gia
                  ORDER BY total_views DESC 
                  LIMIT ?";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $top_truyen = [];
        while ($row = $result->fetch_assoc()) {
            $top_truyen[] = $row;
        }
    
        return $top_truyen;
    }
    
}
?>
