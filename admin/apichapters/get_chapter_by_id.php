<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
require_once __DIR__ . '/../models/chapter.php';

header("Content-Type: application/json; charset=UTF-8");


if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method không hợp lệ"]);
    exit();
}

// Kiểm tra ID chương
if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Thiếu ID chương"]);
    exit();
}

$chapter = new Chapter($conn);
$id = $_GET['id'];

$data = $chapter->getById($id);

if ($data) {
    echo json_encode(["status" => "success", "data" => $data]);
} else {
    http_response_code(404);
    echo json_encode(["status" => "error", "message" => "Không tìm thấy chương"]);
}
?>
