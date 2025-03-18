<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../models/Chapter.php';

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method không hợp lệ"]);
    exit();
}

if (!isset($_GET['truyen_id'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Thiếu ID truyện"]);
    exit();
}

$chapter = new Chapter($conn);
$truyen_id = $_GET['truyen_id'];

$chapters = $chapter->getAll($truyen_id);
echo json_encode(["status" => "success", "data" => $chapters]);
?>
