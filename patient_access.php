<?php
// patient_access.php
session_start();
// Include database connection
include('components/connect.php'); // Kết nối cơ sở dữ liệu

header('Location: patient_record.php');
 
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaBN = $_POST['MaBN'];
    $Ten = $_POST['Ten'];
    $NgaySinh = $_POST['NgaySinh'];
    $GioiTinh = $_POST['GioiTinh'];
    $DiaChi = $_POST['DiaChi'];
    $SoDienThoai = $_POST['SoDienThoai'];
    $ThongTinBaoHiem = $_POST['ThongTinBaoHiem'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truy Cập Hồ Sơ Bệnh Án</title>
    <link rel="stylesheet" href=".css/patient.css">
</head>
<body>
    <div class="container">
        <form method="post" action="patient_access.php">
            <h2>Truy Cập Hồ Sơ Bệnh Án</h2>
            <label for="MaBN">Mã bệnh nhân:</label>
            <input type="text" id="MaBN" name="MaBN" required>
            
            <label for="Tên">Họ tên:</label>
            <input type="text" id="Tên" name="Tên" required>
            
            <label for="NgaySinh">Ngày sinh:</label>
            <input type="date" id="NgaySinh" name="NgaySinh" required>
            
            <label for="GioiTinh">Giới tính:</label>
            <input type="text" id="GioiTinh" name="GioiTinh" required>
            
            <label for="DiaChi">Địa chỉ:</label>
            <input type="text" id="DiaChi" name="DiaChi" required>
            
            <label for="SoDienThoai">Số điện thoại:</label>
            <input type="text" id="so_dien_thoai" name="SoDienThoai" required>
            
            <label for="ThongTinBaoHiem">Thông tin bảo hiểm:</label>
            <input type="text" id="ThongTinBaoHiem" name="ThongTinBaoHiem" required>

            <button type="submit">Truy Cập</button>
        </form>
    </div>
</body>
</html>
