<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
require_once __DIR__ . '/../models/chapter.php';

header("Content-Type: application/json; charset=UTF-8");
// Lấy token từ Authorization Header
$headers = getallheaders();
if (!isset($headers["Authorization"])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Thiếu token!"]);
    exit();
}

$token = str_replace("Bearer ", "", $headers["Authorization"]);
$user = authenticate(); // Kiểm tra token

if ($user_role !== 'admin') {
    echo json_encode(["message" => "Bạn không có quyền thực hiện hành động này"]);
    exit();
}

// Kiểm tra phương thức
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Chỉ hỗ trợ phương thức POST"]);
    exit();
}

$truyen_id = $_POST["truyen_id"] ?? null;

if (!$truyen_id) {
    echo json_encode(["status" => "error", "message" => "Thiếu truyen_id"]);
    exit();
}

$upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/trangwebtutien/noidung/{$truyen_id}/";

// Kiểm tra thư mục, nếu chưa có thì tạo mới
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (!empty($_FILES["file"]["name"])) {
    $file_name = basename($_FILES["file"]["name"]);
    $target_path = $upload_dir . $file_name;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_path)) {
        // Sau khi upload thành công, gọi model để đồng bộ
        $database = new Database();
        $db = $database->getConnection();
        $chapterModel = new ChapterModel($db);
        $chapterModel->syncChaptersToDatabase($truyen_id);

        echo json_encode(["status" => "success", "message" => "Upload & Đồng bộ chương thành công"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi khi tải file"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Không có file nào được chọn"]);
}

?>
