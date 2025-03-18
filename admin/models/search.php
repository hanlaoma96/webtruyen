<?php
class Search {
    private $conn;
    private $table_name = "stories"; // Bảng chứa thông tin truyện

    public function __construct($db) {
        $this->conn = $db;
    }

    public function searchStories($keyword) {
        $query = "SELECT id, ten_truyen, tac_gia, the_loai FROM " . $this->table_name . " 
                  WHERE ten_truyen LIKE ? OR tac_gia LIKE ? OR the_loai LIKE ? 
                  ORDER BY ten_truyen ASC";

        $stmt = $this->conn->prepare($query);
        $searchParam = "%$keyword%";
        $stmt->bind_param("sss", $searchParam, $searchParam, $searchParam);
        $stmt->execute();

        $result = $stmt->get_result();
        $stories = [];
        while ($row = $result->fetch_assoc()) {
            $stories[] = $row;
        }

        return $stories;
    }
}
?>
