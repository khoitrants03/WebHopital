<?php
// patient_access.php
session_start();
// Include database connection
include('components/connect.php'); // Kết nối cơ sở dữ liệu

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ma_dinh_danh = $_POST['ma_dinh_danh'];
    $ho_ten = $_POST['ho_ten'];
    $ngay_sinh = $_POST['ngay_sinh'];
    $gioi_tinh = $_POST['gioi_tinh'];
    $dia_chi = $_POST['dia_chi'];
    $so_dien_thoai = $_POST['so_dien_thoai'];

    // Xác thực đầu vào và chuyển hướng đến patient_record.php
    // Thêm logic xác thực và chuyển hướng của bạn vào đây
    header("Location: patient_record.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truy Cập Hồ Sơ Bệnh Án</title>
    <link rel="stylesheet" href="..css/styles.css">
</head>
<body>
    <div class="container">
        <form method="post" action="patient_access.php">
            <h2>Truy Cập Hồ Sơ Bệnh Án</h2>
            <label for="ma_dinh_danh">Mã định danh:</label>
            <input type="text" id="ma_dinh_danh" name="ma_dinh_danh" required>
            
            <label for="ho_ten">Họ tên:</label>
            <input type="text" id="ho_ten" name="ho_ten" required>
            
            <label for="ngay_sinh">Ngày sinh:</label>
            <input type="date" id="ngay_sinh" name="ngay_sinh" required>
            
            <label for="gioi_tinh">Giới tính:</label>
            <input type="text" id="gioi_tinh" name="gioi_tinh" required>
            
            <label for="dia_chi">Địa chỉ:</label>
            <input type="text" id="dia_chi" name="dia_chi" required>
            
            <label for="so_dien_thoai">Số điện thoại:</label>
            <input type="text" id="so_dien_thoai" name="so_dien_thoai" required>
            
            <button type="submit">Truy Cập</button>
        </form>
    </div>
</body>
</html>
