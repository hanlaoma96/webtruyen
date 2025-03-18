<?php
require_once __DIR__ . '/../backend/db.php';
require_once __DIR__ . '/../backend/auth.php';
require_once __DIR__ . '/../models/User.php';

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "PUT") {
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
if (!isset($data["username"]) || !isset($data["email"])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Thiếu thông tin cập nhật"]);
    exit();
}

$userModel = new User($conn);
$updated = $userModel->updateUser($user["id"], $data["username"], $data["email"]);

if ($updated) {
    echo json_encode(["status" => "success", "message" => "Cập nhật thành công"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Cập nhật thất bại"]);
}
?>
