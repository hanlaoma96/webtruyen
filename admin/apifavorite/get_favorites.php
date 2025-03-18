<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
require_once __DIR__ . '/../models/favorite.php';

header("Content-Type: application/json; charset=UTF-8");

// Chỉ chấp nhận phương thức GET
if ($_SERVER["REQUEST_METHOD"] !== "GET") {
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

// Lấy danh sách yêu thích của user
$favoriteModel = new Favorite($conn);
$favoriteModel->user_id = $user["id"];

$result = $favoriteModel->getFavorites();
$favorites = [];

while ($row = $result->fetch_assoc()) {
    $favorites[] = [
        "truyen_id" => $row["truyen_id"],
        "ten_truyen" => $row["ten_truyen"],
        "liked_at" => $row["liked_at"]
    ];
}

echo json_encode(["status" => "success", "favorites" => $favorites]);
?>
