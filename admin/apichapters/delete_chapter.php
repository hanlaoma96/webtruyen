<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
require_once __DIR__ . '/../models/chapter.php';

header("Content-Type: application/json; charset=UTF-8");
// Lấy token từ Authorization Header
$headers = getallheaders();
if (!isset($headers["Authorization"])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Thiếu token!"]);
    exit();
}

$token = str_replace("Bearer ", "", $headers["Authorization"]);
$user = authenticate(); // Kiểm tra token

if ($user_role !== 'admin') {
    echo json_encode(["message" => "Bạn không có quyền thực hiện hành động này"]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method không hợp lệ"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Thiếu ID chương"]);
    exit();
}

$chapter = new Chapter($conn);
$chapter->id = $data['id'];

if ($chapter->delete()) {
    echo json_encode(["status" => "success", "message" => "Xóa chương thành công!"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Lỗi khi xóa chương"]);
}
?>
