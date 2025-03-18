<?php
require_once __DIR__ . "/../../backend/db.php";
require_once __DIR__ . "/../../backend/auth.php";
require_once __DIR__ . "/../models/History.php";

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
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

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["truyen_id"]) || !isset($data["chapter_id"])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Thiếu thông tin cần thiết"]);
    exit();
}

$history = new History($conn);
$history->user_id = $user["id"];
$history->truyen_id = $data["truyen_id"];
$history->chapter_id = $data["chapter_id"];

if ($history->addHistory()) {
    echo json_encode(["status" => "success", "message" => "Đã cập nhật lịch sử đọc"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Không thể cập nhật lịch sử đọc"]);
}
?>
