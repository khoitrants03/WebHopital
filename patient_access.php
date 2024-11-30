<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truy Cập Hồ Sơ Bệnh Án</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Truy Cập Hồ Sơ Bệnh Án</h2>
            <form action="patient_access.php" method="POST">
                <label for="ma_dinh_danh">Mã định danh:</label>
                <input type="text" id="ma_dinh_danh" name="ma_dinh_danh" required>
                
                <label for="ho_ten">Họ tên:</label>
                <input type="text" id="ho_ten" name="ho_ten" required>
                
                <label for="ngay_sinh">Ngày sinh:</label>
                <input type="date" id="ngay_sinh" name="ngay_sinh" required>
                
                <label for="gioi_tinh">Giới tính:</label>
                <input type="text" id="gioi_tinh" name="gioi_tinh" required>
                
                <label for="dia_chi">Địa chỉ:</label>
                <input type="text" id="dia_chi" name="dia_chi">
                
                <label for="so_dien_thoai">Số điện thoại:</label>
                <input type="text" id="so_dien_thoai" name="so_dien_thoai" required>
                
                <button type="submit">Truy Cập</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root"; // Thay bằng tài khoản MySQL của bạn
$password = ""; // Thay bằng mật khẩu MySQL của bạn
$dbname = "WebHospital";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ma_dinh_danh = $_POST["ma_dinh_danh"];
    $ho_ten = $_POST["ho_ten"];
    $ngay_sinh = $_POST["ngay_sinh"];
    $gioi_tinh = $_POST["gioi_tinh"];
    $dia_chi = $_POST["dia_chi"];
    $so_dien_thoai = $_POST["so_dien_thoai"];

    // Truy vấn dữ liệu
    $sql = "SELECT * FROM hosobenhan WHERE ma_dinh_danh = ? AND ho_ten = ? AND ngay_sinh = ? AND gioi_tinh = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $ma_dinh_danh, $ho_ten, $ngay_sinh, $gioi_tinh);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Hiển thị thông tin bệnh án
        while ($row = $result->fetch_assoc()) {
            echo "<h2>Thông Tin Bệnh Án</h2>";
            echo "Họ Tên: " . $row["ho_ten"] . "<br>";
            echo "Ngày Sinh: " . $row["ngay_sinh"] . "<br>";
            echo "Giới Tính: " . $row["gioi_tinh"] . "<br>";
            echo "Địa Chỉ: " . $row["dia_chi"] . "<br>";
            echo "Số Điện Thoại: " . $row["so_dien_thoai"] . "<br>";
            echo "Thông Tin Bệnh Án: " . $row["thong_tin_benh_an"] . "<br>";
        }
    } else {
        echo "Không tìm thấy hồ sơ bệnh án!";
    }
}
$conn->close();
?>
