<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
require_once __DIR__ . '/../models/favorite.php';

header("Content-Type: application/json; charset=UTF-8");

// Chỉ chấp nhận phương thức DELETE
if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Phương thức không hợp lệ"]);
    exit();
}

// Kiểm tra token
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

// Nhận dữ liệu đầu vào
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["truyen_id"])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Thiếu ID truyện"]);
    exit();
}

// Tạo đối tượng Favorite
$favoriteModel = new Favorite($conn);
$favoriteModel->user_id = $user["id"];
$favoriteModel->truyen_id = $data["truyen_id"];

// Kiểm tra nếu chưa thích trước đó
if (!$favoriteModel->isFavorite()) {
    http_response_code(404);
    echo json_encode(["status" => "error", "message" => "Bạn chưa thích truyện này"]);
    exit();
}

// Xóa khỏi danh sách yêu thích
if ($favoriteModel->removeFavorite()) {
    echo json_encode(["status" => "success", "message" => "Đã xóa khỏi danh sách yêu thích"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Không thể xóa khỏi danh sách yêu thích"]);
}
?>
