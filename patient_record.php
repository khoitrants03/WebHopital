<?php
// patient_record.php
session_start();
include('components/connect.php'); // Kết nối cơ sở dữ liệu

// Kiểm tra nếu bệnh nhân đã đăng nhập
if (!isset($_SESSION['patient_id'])) {
    header("Location: patient_access.php");
    exit();
}

// Lấy thông tin bệnh nhân
$id = $_SESSION['patient_id'];
$query = $conn->prepare("SELECT * FROM patients WHERE id = ?");
$query->execute([$id]);
$patient = $query->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Cập nhật thông tin bệnh nhân
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $address = $_POST['address']; 
    
    $notes = $_POST['notes'];

    $update_query = $conn->prepare("UPDATE patients SET name = ?, dob = ?, address = ?, phone = ?, notes = ? WHERE id = ?");
    $update_query->execute([$name, $dob, $phone, $notes, $id]);

    $success_message = "Lưu thành công!";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hồ Sơ Bệnh Án</title>
</head>
<body>
    <h2>Hồ Sơ Bệnh Án</h2>
    <?php if (isset($success_message)) echo "<p style='color:green;'>$success_message</p>"; ?>
    
    <form method="POST" action="">
        <label for="name">Họ tên:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($patient['name']) ?>" required><br>

        <label for="dob">Ngày sinh:</label>
        <input type="date" id="dob" name="dob" value="<?= htmlspecialchars($patient['dob']) ?>" required><br>

        <label for="address">Địa chỉ:</label>
        <input type="text" id="address" name="address" value="<?= htmlspecialchars($patient['address']) ?>" required><br>

        <label for="phone">Số điện thoại:</label>
        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($patient['phone']) ?>" required><br>

        <label for="notes">Ghi chú:</label>
        <textarea id="notes" name="notes"><?= htmlspecialchars($patient['notes']) ?></textarea><br>

        <input type="submit" value="Lưu Thay Đổi">
    </form>
</body>
</html>
