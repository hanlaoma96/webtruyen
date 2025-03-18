<?php
session_start();
header("Content-Type: application/json");

// Kiểm tra yêu cầu POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input_captcha = $_POST['captcha'] ?? '';

    if (!isset($_SESSION['captcha'])) {
        echo json_encode(["success" => false, "message" => "CAPTCHA hết hạn, vui lòng tải lại"]);
        exit;
    }

    // Kiểm tra CAPTCHA
    if (strcasecmp($input_captcha, $_SESSION['captcha']) === 0) {
        echo json_encode(["success" => true, "message" => "Xác thực thành công"]);
    } else {
        echo json_encode(["success" => false, "message" => "CAPTCHA không đúng"]);
    }

    // Xóa CAPTCHA sau khi kiểm tra
    unset($_SESSION['captcha']);
} else {
    echo json_encode(["success" => false, "message" => "Phương thức không hợp lệ"]);
}
?>
