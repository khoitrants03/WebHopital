<?php
// patient_access.php
session_start();
include('components/connect.php'); // Kết nối cơ sở dữ liệu

// Xử lý khi người dùng submit form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $sex = $_POST['sex'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Kiểm tra thông tin đăng nhập
    $query = $conn->prepare("SELECT * FROM patients WHERE id = ? AND name = ? AND dob = ? AND sex = ? AND address = ? = ?AND phone = ?");
    $query->execute([$id, $name, $dob, $phone]);

    if ($query->rowCount() > 0) {
        $_SESSION['patient_id'] = $id;
        header("Location: patient_record.php");
        exit();
    } else {
        $error_message = "Thông tin không chính xác. Vui lòng nhập lại.";
        var_dump($query->errorInfo()); // Kiểm tra lỗi SQL nếu có
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Truy Cập Hồ Sơ Bệnh Án </title>
    <link rel="stylesheet" href="css/patient.css">
</head>
<body>
<div class="container">
    <h2>Truy Cập Hồ Sơ Bệnh Án</h2>
     <?php if (isset($error_message)) echo "<p class='error-message'>$error_message</p>"; ?>
    <form method="POST" action="">
        <label for="id">Mã định danh:</label>
        <input type="text" id="id" name="id" required><br>

        <label for="name">Họ tên:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="dob">Ngày sinh:</label>
        <input type="date" id="dob" name="dob" required><br>

        <label for="sex">Giới tính:</label>
        <input type="text" id="sex" name="sex" required><br>

        <label for="address">Địa chỉ:</label>
        <input type="text" id="address" name="address" required><br>

        <label for="phone">Số điện thoại:</label>
        <input type="text" id="phone" name="phone" required><br>

        <input type="submit" value="Truy Cập">
    </form>
</div>
</body>
</html>
