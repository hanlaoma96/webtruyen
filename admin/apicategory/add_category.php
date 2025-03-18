<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
require_once __DIR__ . '/../models/category.php';

header("Content-Type: application/json; charset=UTF-8");

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

if (!$user || $user["role"] !== "admin") {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Bạn không có quyền thêm thể loại"]);
    exit();
}

// Nhận dữ liệu
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["ten_the_loai"]) || empty(trim($data["ten_the_loai"]))) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Tên thể loại không được để trống"]);
    exit();
}

$categoryModel = new Category($conn);
$categoryModel->ten_the_loai = trim($data["ten_the_loai"]);

if ($categoryModel->addCategory()) {
    echo json_encode(["status" => "success", "message" => "Thêm thể loại thành công"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Thêm thể loại thất bại"]);
}
?>
