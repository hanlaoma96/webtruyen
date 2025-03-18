<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../models/comments.php';

header("Content-Type: application/json; charset=UTF-8");

// Kiểm tra phương thức request
if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Phương thức không hợp lệ"]);
    exit();
}

// Lấy chapter_id từ query string
if (!isset($_GET["chapter_id"])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Thiếu chapter_id"]);
    exit();
}

$chapter_id = intval($_GET["chapter_id"]);

// Lấy danh sách bình luận
$comments = getCommentsByChapterId($chapter_id);
echo json_encode(["status" => "success", "data" => $comments]);
?>
