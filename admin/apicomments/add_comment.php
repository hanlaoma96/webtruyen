<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
require_once __DIR__ . '/../models/comments.php';

header("Content-Type: application/json; charset=UTF-8");

// Kiểm tra phương thức request
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Phương thức không hợp lệ"]);
    exit();
}

// Xác thực token
$headers = getallheaders();
if (!isset($headers["Authorization"])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Thiếu token!"]);
    exit();
}

$token = str_replace("Bearer ", "", $headers["Authorization"]);
$user = authenticate($token);
if (!$user) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Token không hợp lệ!"]);
    exit();
}

// Lấy dữ liệu đầu vào
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["chapter_id"]) || !isset($data["noi_dung"])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Thiếu dữ liệu đầu vào!"]);
    exit();
}

// Lưu bình luận
$chapter_id = intval($data["chapter_id"]);
$user_id = $user["id"]; // Lấy user_id từ token
$noi_dung = trim($data["noi_dung"]);

$result = addComment($chapter_id, $user_id, $noi_dung);
if ($result) {
    echo json_encode(["status" => "success", "message" => "Thêm bình luận thành công"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Lỗi khi thêm bình luận"]);
}
?>
