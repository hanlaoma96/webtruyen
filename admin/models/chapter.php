<?php
class Chapter {
    private $conn;
    private $table_name = "chapters";

    public $id;
    public $truyen_id;
    public $chapter_number;
    public $ten_chuong;
    public $noi_dung;

    // Hàm khởi tạo nhận database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Thêm chương mới
    public function create() {
        $query = "INSERT INTO chapters (truyen_id, chapter_number, ten_chuong, noi_dung) 
                  VALUES (?, ?, ?, ?)";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiss", $this->truyen_id, $this->chapter_number, $this->ten_chuong, $this->noi_dung);
    
        return $stmt->execute();
    }
    function syncChaptersToDatabase($conn, $truyen_id) {
        $chapter_dir = $_SERVER['DOCUMENT_ROOT'] . "/trangwebtutien/noidung/{$truyen_id}/";
        
        if (is_dir($chapter_dir)) {
            for ($i = 1; $i <= 1000; $i++) {
                $chapter_file = $chapter_dir . "chapter{$i}.txt";
                if (file_exists($chapter_file)) {
                    $noi_dung = file_get_contents($chapter_file);
                    $noi_dung = mysqli_real_escape_string($conn, $noi_dung);
                    $ngay_them = date('Y-m-d H:i:s', filemtime($chapter_file)); // Cập nhật đúng cột `ngay_them`
    
                    // Kiểm tra xem chương đã tồn tại chưa
                    $sql_check = "SELECT id FROM chapters WHERE truyen_id = ? AND chapter_number = ?";
                    $stmt_check = mysqli_prepare($conn, $sql_check);
                    mysqli_stmt_bind_param($stmt_check, "ii", $truyen_id, $i);
                    mysqli_stmt_execute($stmt_check);
                    $result_check = mysqli_stmt_get_result($stmt_check);
    
                    if (mysqli_num_rows($result_check) == 0) {
                        // Nếu chưa có, thêm mới
                        $sql_insert = "INSERT INTO chapters (truyen_id, chapter_number, noi_dung, ngay_them) VALUES (?, ?, ?, ?)";
                        $stmt_insert = mysqli_prepare($conn, $sql_insert);
                        mysqli_stmt_bind_param($stmt_insert, "iiss", $truyen_id, $i, $noi_dung, $ngay_them);
                        mysqli_stmt_execute($stmt_insert);
                        mysqli_stmt_close($stmt_insert);
                    } else {
                        // Nếu đã có, cập nhật nội dung
                        $sql_update = "UPDATE chapters SET noi_dung = ?, ngay_them = ? WHERE truyen_id = ? AND chapter_number = ?";
                        $stmt_update = mysqli_prepare($conn, $sql_update);
                        mysqli_stmt_bind_param($stmt_update, "ssii", $noi_dung, $ngay_them, $truyen_id, $i);
                        mysqli_stmt_execute($stmt_update);
                        mysqli_stmt_close($stmt_update);
                    }
    
                    mysqli_stmt_close($stmt_check);
                }
            }
        }
    }
    
    // Lấy danh sách chương của 1 truyện
    public function getAll($truyen_id) {
        $query = "SELECT id, chapter_number, ten_chuong, noi_dung, ngay_them 
                  FROM chapters WHERE truyen_id = ? ORDER BY chapter_number ASC";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $truyen_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Lấy chi tiết chương theo ID
    public function getById($id) {
        $query = "SELECT id, truyen_id, chapter_number, ten_chuong, noi_dung, ngay_them 
                  FROM chapters WHERE id = ? LIMIT 1";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_assoc();
    }
    

    // Cập nhật chương
    public function update() {
        $query = "UPDATE chapters SET ten_chuong = ?, noi_dung = ? WHERE id = ?";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssi", $this->ten_chuong, $this->noi_dung, $this->id);
    
        return $stmt->execute();
    }
    

    // Xóa chương
    public function delete() {
        $query = "DELETE FROM chapters WHERE id = ?";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
    
        return $stmt->execute();
    }
    
}
?>
