<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
require_once __DIR__ . '/../models/favorite.php';

header("Content-Type: application/json; charset=UTF-8");

// Kiểm tra phương thức
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
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
$user = authenticate($token); // Xác thực user từ token

if (!$user) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Token không hợp lệ"]);
    exit();
}

// Nhận dữ liệu đầu vào
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["truyen_id"]) || !is_numeric($data["truyen_id"])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Thiếu ID truyện hợp lệ"]);
    exit();
}

$truyen_id = intval($data["truyen_id"]);

// Khởi tạo đối tượng Favorite
$favoriteModel = new Favorite($conn);
$favoriteModel->user_id = $user["id"];
$favoriteModel->truyen_id = $truyen_id;

// Kiểm tra truyện đã được yêu thích chưa
if ($favoriteModel->isFavorite()) {
    http_response_code(409);
    echo json_encode(["status" => "error", "message" => "Bạn đã thích truyện này"]);
    exit();
}

// Thêm vào danh sách yêu thích
if ($favoriteModel->addFavorite()) {
    echo json_encode(["status" => "success", "message" => "Đã thêm vào danh sách yêu thích"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Không thể thêm vào danh sách yêu thích"]);
}
?>
