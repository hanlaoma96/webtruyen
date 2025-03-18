<?php
require_once __DIR__ . '/../../backend/db.php';

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method không hợp lệ"]);
    exit();
}

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Thiếu ID truyện"]);
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT id, ten_truyen, mo_ta, tac_gia, anh_bia, ngay_them FROM truyen WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $story = $result->fetch_assoc();
    echo json_encode(["status" => "success", "story" => $story]);
} else {
    http_response_code(404);
    echo json_encode(["status" => "error", "message" => "Không tìm thấy truyện"]);
}
?>
