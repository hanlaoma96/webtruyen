<?php

require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';

// Lấy token từ Authorization Header
$headers = getallheaders();
if (!isset($headers["Authorization"])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Thiếu token!"]);
    exit();
}

$token = str_replace("Bearer ", "", $headers["Authorization"]);
$user = authenticate(); // Kiểm tra token

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method không hợp lệ"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['ten_truyen'], $data['mo_ta'], $data['tac_gia'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Thiếu dữ liệu"]);
    exit();
}

$title = $data['ten_truyen'];
$description = $data['mo_ta'];
$author = $data['tac_gia'];
$cover_image = isset($data['anh_bia']) ? $data['anh_bia'] : null;

$stmt = $conn->prepare("INSERT INTO truyen (ten_truyen, mo_ta, tac_gia, anh_bia) VALUES (?, ?, ?, ?)");

if (!$stmt) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Lỗi truy vấn: " . $conn->error]);
    exit();
}

$stmt->bind_param("ssss", $title, $description, $author, $cover_image);

if ($stmt->execute()) {
    http_response_code(201);
    echo json_encode(["status" => "success", "message" => "Thêm truyện thành công!"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Lỗi khi thêm truyện: " . $stmt->error]);
}

$stmt->close();
$conn->close();

?>
