<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
require_once __DIR__ . '/../models/view.php';

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Phương thức không hợp lệ"]);
    exit();
}

// Lấy user nếu có token
$headers = getallheaders();
$user = null;
if (isset($headers["Authorization"])) {
    $token = str_replace("Bearer ", "", $headers["Authorization"]);
    $user = authenticate($token);
}

// Nhận dữ liệu từ frontend
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["truyen_id"])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Thiếu ID truyện"]);
    exit();
}

$view = new View($conn);
$view->truyen_id = $data["truyen_id"];
$view->user_id = $user ? $user["id"] : null; // Nếu có user thì lấy user_id, nếu không thì NULL

if ($view->addView()) {
    echo json_encode(["status" => "success", "message" => "Lượt xem được ghi nhận"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Lỗi khi ghi nhận lượt xem"]);
}
?>
