<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';

header("Content-Type: application/json; charset=UTF-8");

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
    echo json_encode(["status" => "error", "message" => "Token không hợp lệ"]);
    exit();
}

// Đặt lại trạng thái thông báo
$query = "UPDATE theo_doi SET thong_bao = 0 WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user["id"]);
$stmt->execute();

echo json_encode(["status" => "success", "message" => "Thông báo đã được đánh dấu là đã đọc"]);
?>
