<?php
header("Content-Type: application/json; charset=UTF-8");
require_once '../db.php';
session_start();

function registerUser($conn, $username, $password, $confirm_password, $email) {
    if ($password !== $confirm_password) {
        http_response_code(400);
        return ["status" => "error", "message" => "Mật khẩu xác nhận không khớp!"];
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        return ["status" => "error", "message" => "Email không hợp lệ!"];
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        http_response_code(409);
        return ["status" => "error", "message" => "Username hoặc email đã tồn tại!"];
    }
    $stmt->close();

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = 'user';
    $ngay_dang_ky = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO users (username, password, email, role, ngay_dang_ky) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $hashed_password, $email, $role, $ngay_dang_ky);

    if ($stmt->execute()) {
        http_response_code(201);
        return ["status" => "success", "message" => "Đăng ký thành công!"];
    } else {
        http_response_code(500);
        return ["status" => "error", "message" => "Có lỗi xảy ra trong quá trình đăng ký!"];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data || !isset($data['username'], $data['password'], $data['confirm_password'], $data['email'])) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Thiếu dữ liệu đầu vào!"]);
        exit();
    }

    $response = registerUser($conn, $data['username'], $data['password'], $data['confirm_password'], $data['email']);
    echo json_encode($response);
    exit();
}
?>
