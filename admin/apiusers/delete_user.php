<?php
require_once __DIR__ . '/../backend/db.php';
require_once __DIR__ . '/../backend/auth.php';
require_once __DIR__ . '/../models/User.php';

header("Content-Type: application/json; charset=UTF-8");

// Kiểm tra phương thức
if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
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
    echo json_encode(["status" => "error", "message" => "Token không hợp lệ"]);
    exit();
}

// Kiểm tra quyền (Admin hoặc chính chủ mới được xóa)
if ($user["role"] !== "admin") {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Bạn không có quyền xóa tài khoản"]);
    exit();
}

// Xóa user
$userModel = new User($conn);
$deleted = $userModel->deleteUser($user["id"]);

if ($deleted) {
    echo json_encode(["status" => "success", "message" => "Xóa tài khoản thành công"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Xóa tài khoản thất bại"]);
}
?>
