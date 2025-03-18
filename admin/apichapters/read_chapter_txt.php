<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
require_once __DIR__ . '/../models/chapter.php';

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    echo json_encode(["message" => "Chỉ hỗ trợ phương thức GET"]);
    exit();
}

$truyen_id = $_GET['truyen_id'] ?? null;
$chapter_id = $_GET['chapter_id'] ?? null;

if (!$truyen_id || !$chapter_id) {
    echo json_encode(["message" => "Thiếu thông tin truyện hoặc chương"]);
    exit();
}

$file_path = $_SERVER['DOCUMENT_ROOT'] . "/trangwebtutien/noidung/{$truyen_id}/chapter{$chapter_id}.txt";

if (!file_exists($file_path)) {
    echo json_encode(["message" => "Chương này chưa có nội dung"]);
    exit();
}

$content = file_get_contents($file_path);
echo json_encode(["chapter_id" => $chapter_id, "content" => $content]);
?>
