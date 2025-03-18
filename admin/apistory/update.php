<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';

header("Content-Type: application/json; charset=UTF-8");

// Lấy token từ Authorization Header
$headers = getallheaders();
if (!isset($headers["Authorization"])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Thiếu token!"]);
    exit();
}

$token = str_replace("Bearer ", "", $headers["Authorization"]);
// Kiểm tra xác thực token
$user = authenticate();
if (!$user) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Unauthorized - Thiếu hoặc sai token"], JSON_UNESCAPED_UNICODE);
    exit();
}

// Chỉ chấp nhận phương thức PUT
if ($_SERVER["REQUEST_METHOD"] !== "PUT") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method không hợp lệ"], JSON_UNESCAPED_UNICODE);
    exit();
}

// Đọc dữ liệu JSON từ client
$data = json_decode(file_get_contents("php://input"), true);

// Kiểm tra các trường dữ liệu bắt buộc
if (empty($data['id']) || empty($data['ten_truyen']) || empty($data['mo_ta']) || empty($data['tac_gia'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Thiếu dữ liệu cần thiết"], JSON_UNESCAPED_UNICODE);
    exit();
}

// Lấy dữ liệu từ request
$id = intval($data['id']);
$title = htmlspecialchars(strip_tags($data['ten_truyen']));
$description = htmlspecialchars(strip_tags($data['mo_ta']));
$author = htmlspecialchars(strip_tags($data['tac_gia']));
$cover_image = !empty($data['anh_bia']) ? htmlspecialchars(strip_tags($data['anh_bia'])) : null;

// Kiểm tra xem ID có tồn tại trong database không
$checkStmt = $conn->prepare("SELECT id FROM truyen WHERE id = ?");
$checkStmt->bind_param("i", $id);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(["status" => "error", "message" => "Truyện không tồn tại"], JSON_UNESCAPED_UNICODE);
    exit();
}

// Cập nhật dữ liệu
$stmt = $conn->prepare("UPDATE truyen SET ten_truyen = ?, mo_ta = ?, tac_gia = ?, anh_bia = ? WHERE id = ?");
$stmt->bind_param("ssssi", $title, $description, $author, $cover_image, $id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Cập nhật truyện thành công!"], JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Lỗi khi cập nhật truyện"], JSON_UNESCAPED_UNICODE);
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>
