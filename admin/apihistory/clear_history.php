<?php
require_once __DIR__ . "/../../backend/db.php";
require_once __DIR__ . "/../../backend/auth.php";
require_once __DIR__ . "/../models/History.php";

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Phương thức không hợp lệ"]);
    exit();
}

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

$history = new History($conn);
$history->user_id = $user["id"];

if ($history->clearHistory()) {
    echo json_encode(["status" => "success", "message" => "Đã xóa toàn bộ lịch sử đọc"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Không thể xóa lịch sử đọc"]);
}
?>
