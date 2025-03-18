<?php
require_once __DIR__ . '/../../backend/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten_truyen = $_POST["ten_truyen"];
    $tac_gia = $_POST["tac_gia"];
    $mo_ta = $_POST["mo_ta"];
    
    // Xử lý upload ảnh
    $target_dir = "../uploads/";
    $file_name = basename($_FILES["anh_bia"]["name"]);
    $target_file = $target_dir . $file_name;
    $upload_ok = 1;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra file ảnh
    $check = getimagesize($_FILES["anh_bia"]["tmp_name"]);
    if ($check === false) {
        die("File không phải là ảnh.");
    }

    // Giới hạn định dạng ảnh
    $allowed_types = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($image_file_type, $allowed_types)) {
        die("Chỉ cho phép upload ảnh JPG, JPEG, PNG, GIF.");
    }

    // Upload file vào thư mục
    if (move_uploaded_file($_FILES["anh_bia"]["tmp_name"], $target_file)) {
        // Lưu vào database
        $query = "INSERT INTO truyen (ten_truyen, mo_ta, tac_gia, anh_bia) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $ten_truyen, $mo_ta, $tac_gia, $file_name);

        if ($stmt->execute()) {
            echo "Thêm truyện thành công! <a href='add_truyen.php'>Quay lại</a>";
        } else {
            echo "Lỗi khi lưu vào database.";
        }
    } else {
        echo "Lỗi khi upload ảnh.";
    }
}
?>
