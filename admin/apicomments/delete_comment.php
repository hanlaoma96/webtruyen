<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
require_once __DIR__ . '/../models/comments.php';

header("Content-Type: application/json; charset=UTF-8");

// Kiểm tra phương thức HTTP
if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Phương thức không hợp lệ"]);
    exit();
}

// Lấy token từ Header
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

// Lấy dữ liệu đầu vào
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["comment_id"])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Thiếu ID bình luận"]);
    exit();
}

// Khởi tạo model và kiểm tra quyền
$commentModel = new Comment($conn);
$commentModel->id = $data["comment_id"];
$commentModel->user_id = $user["id"];
$commentModel->user_role = $user["role"];

$permissionCheck = $commentModel->canDeleteComment();
if ($permissionCheck["status"] !== "success") {
    http_response_code(403);
    echo json_encode($permissionCheck);
    exit();
}

// Thực hiện xóa bình luận
if ($commentModel->deleteComment()) {
    echo json_encode(["status" => "success", "message" => "Xóa bình luận thành công"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Xóa bình luận thất bại"]);
}

?>
