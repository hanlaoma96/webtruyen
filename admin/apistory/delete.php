<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';

// Lấy token từ Authorization Header
$headers = getallheaders();
if (!isset($headers["Authorization"])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Thiếu token!"]);
    exit();
}

$token = str_replace("Bearer ", "", $headers["Authorization"]);
$user = authenticate(); // Kiểm tra token

if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method không hợp lệ"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Thiếu ID truyện"]);
    exit();
}

$id = $data['id'];

$stmt = $conn->prepare("DELETE FROM truyen WHERE id = ?");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Lỗi chuẩn bị truy vấn"]);
    exit();
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Xóa truyện thành công!"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Lỗi khi xóa truyện"]);
}

$stmt->close();
$conn->close();
?>
