<?php
require_once '../db.php';
require_once '../jwt.php'; // Import file JWT

session_start();

function loginUser($conn, $username, $password) {
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $db_username, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $user = ["id" => $id, "username" => $db_username, "role" => $role];
            $token = createJWT($user); // Tạo JWT

            return [
                "status" => "success",
                "message" => "Đăng nhập thành công!",
                "token" => $token
            ];
        } else {
            http_response_code(401);
            return ["status" => "error", "message" => "Mật khẩu không đúng!"];
        }
    } else {
        http_response_code(401);
        return ["status" => "error", "message" => "Tài khoản không tồn tại!"];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['username'], $data['password'])) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Thiếu thông tin đăng nhập!"]);
        exit();
    }

    $response = loginUser($conn, $data['username'], $data['password']);
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
