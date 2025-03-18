<?php
require_once __DIR__ . '/../backend/db.php';
require_once __DIR__ . '/../../admin/models/search.php';

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Phương thức không hợp lệ"]);
    exit();
}

// Kiểm tra từ khóa tìm kiếm
if (!isset($_GET["keyword"]) || empty(trim($_GET["keyword"]))) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Vui lòng nhập từ khóa tìm kiếm"]);
    exit();
}

$keyword = trim($_GET["keyword"]);
$searchModel = new Search($conn);
$results = $searchModel->searchStories($keyword);

echo json_encode(["status" => "success", "data" => $results]);
?>
