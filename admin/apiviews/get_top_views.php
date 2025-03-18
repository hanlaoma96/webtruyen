<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../models/view.php';

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Phương thức không hợp lệ"]);
    exit();
}

$limit = isset($_GET["limit"]) ? (int)$_GET["limit"] : 10;

$view = new View($conn);
$top_truyen = $view->getTopViews($limit);

echo json_encode(["status" => "success", "data" => $top_truyen]);
?>
