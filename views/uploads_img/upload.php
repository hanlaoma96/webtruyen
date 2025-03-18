<?php
require_once __DIR__ . '/../../backend/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $targetDir = "uploads/"; // Thư mục lưu ảnh
    $fileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    // Kiểm tra định dạng ảnh
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];

    if (in_array($fileType, $allowTypes)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            // Lưu đường dẫn vào database
            $ten_truyen = $_POST["ten_truyen"];
            $sql = "INSERT INTO truyen (ten_truyen, anh_bia) VALUES ('$ten_truyen', '$fileName')";
            if ($conn->query($sql)) {
                echo "Upload thành công!";
            } else {
                echo "Lỗi SQL: " . $conn->error;
            }
        } else {
            echo "Lỗi khi di chuyển file.";
        }
    } else {
        echo "Chỉ chấp nhận JPG, PNG, JPEG, GIF.";
    }
}
?>
