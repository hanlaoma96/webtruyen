<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../models/category.php';

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Phương thức không hợp lệ"]);
    exit();
}

$categoryModel = new Category($conn);
$categories = $categoryModel->getCategories();

echo json_encode(["status" => "success", "data" => $categories]);
?>
