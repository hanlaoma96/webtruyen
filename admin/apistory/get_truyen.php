<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../../backend/db.php';

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method không hợp lệ"]);
    exit();
}

$query = "SELECT id, ten_truyen, mo_ta, tac_gia, anh_bia, ngay_them FROM truyen ORDER BY ngay_them DESC";
$result = $conn->query($query);

if (!$result) {
    echo json_encode(["status" => "error", "message" => "Lỗi truy vấn dữ liệu: " . $conn->error]);
    exit();
}

$stories = [];
while ($row = $result->fetch_assoc()) {
    foreach ($row as $key => $value) {
        $row[$key] = mb_convert_encoding($value, "UTF-8", "auto");
    }
    $stories[] = $row;
}

echo json_encode([
    "status" => "success",  
    "stories" => $stories
], JSON_UNESCAPED_UNICODE);
?>
