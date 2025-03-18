<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';

header("Content-Type: application/json; charset=UTF-8");

// Xác thực token
$headers = getallheaders();
if (!isset($headers["Authorization"])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Thiếu token!"]);
    exit();
}

$token = str_replace("Bearer ", "", $headers["Authorization"]);
$user = authenticate($token);

if (!$user) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Token không hợp lệ"]);
    exit();
}

// Lấy danh sách truyện có chương mới
$query = "SELECT truyen_id FROM theo_doi WHERE user_id = ? AND thong_bao = 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user["id"]);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row["truyen_id"];
}

echo json_encode(["status" => "success", "data" => $notifications]);
?>
