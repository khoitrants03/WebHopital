<?php
include 'components/connect.php';
session_start();

// Kiểm tra và lấy user_id từ session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

// Thêm cart nếu có
include 'components/add_cart.php';

include_once("Controller/cQLHS.php");
$controller = new controllQLHS();

// Kiểm tra mã hồ sơ trong URL
if (isset($_GET['MaBN']) && !empty($_GET['MaBN'])) {
    $MaBN = $_GET['MaBN'];
    $HSBN = $controller->getHSBNById($MaBN);

    // Kiểm tra dữ liệu hồ sơ trả về
    if (!$HSBN || !isset($HSBN['Ten']) || !isset($HSBN['NgaySinh']) || !isset($HSBN['GioiTinh']) || !isset($HSBN['DiaChi']) || !isset($HSBN['SoDienThoai'])) {
        echo "<script>alert('Dữ liệu không đầy đủ hoặc không tìm thấy Hồ Sơ!');</script>";
        echo "<script> window.location.href = 'QLHSBN.php';</script>";
        exit();
    }

    // Lấy dữ liệu từ hồ sơ
    $Ten = $HSBN['Ten'];
    $NgaySinh = $HSBN['NgaySinh'];
    $GioiTinh = isset($HSBN['GioiTinh']) ? $HSBN['GioiTinh'] : '';
    $DiaChi = $HSBN['DiaChi'];
    $SoDienThoai = $HSBN['SoDienThoai'];
    $ThongTinBaoHiem = $HSBN['ThongTinBaoHiem'];
} else {
    echo "<script>alert('Không tìm thấy mã hồ sơ!');</script>";
    echo "<script>window.location.href = 'QLHSBN.php';</script>";
    exit();
}

// Xử lý khi nhấn nút Lưu thay đổi
if (isset($_POST['btnSubmit'])) {
    // Lấy giá trị từ form
    $Ten = !empty($_POST['Ten']) ? $_POST['Ten'] : $Ten;
    $NgaySinh = $_POST['NgaySinh'];
    $GioiTinh = $_POST['GioiTinh'];
    $DiaChi = !empty($_POST['DiaChi']) ? $_POST['DiaChi'] : $DiaChi;
    $SoDienThoai = $_POST['SoDienThoai'];

    // Kiểm tra số điện thoại
    if (!preg_match('/^(02|07|09)\d{8}$/', $SoDienThoai)) {
        echo "<script>alert('Số điện thoại phải bắt đầu bằng 02, 07 hoặc 09 và có đúng 10 chữ số!');</script>";
    } else {
        // Kiểm tra ngày sinh phải nhỏ hơn hoặc bằng ngày hiện tại
        $currentDate = date('Y-m-d');
        if ($NgaySinh > $currentDate) {
            echo "<script>alert('Ngày sinh phải nhỏ hơn hoặc bằng ngày hiện tại!');</script>";
        } else {
            // Kiểm tra và gán giá trị mặc định cho ThongTinBaoHiem nếu để trống
            $ThongTinBaoHiem = !empty($_POST["ThongTinBaoHiem"]) ? $_POST["ThongTinBaoHiem"] : 'Không';

            // Cập nhật hồ sơ bệnh nhân
            $result = $controller->updateHSBN($MaBN, $Ten, $NgaySinh, $GioiTinh, $DiaChi, $SoDienThoai, $ThongTinBaoHiem);

            if ($result) {
                echo "<script>alert('Cập nhật thành công!');</script>";
                echo "<script>window.location.href = 'QLHSBN.php';</script>";
            } else {
                echo "<script>alert('Cập nhật không thành công!');</script>";
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Hồ Sơ Bệnh Nhân</title>
    <link rel="shortcut icon" href="./imgs/hospital-solid.svg" type="image/x-icon">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../WebHopital-master/css/style.css">
    <link rel="stylesheet" href="../WebHopital-master/css/suaHSBN.css">
</head>
<body>

<!-- Header Section -->
<?php include 'components/user_header.php'; ?>

<!-- Form Section -->
<div class="form-container">
    <h2 class="form-title">Sửa Hồ Sơ Bệnh Nhân</h2>
    <form action="" method="POST" class="form-content">
        <input type="hidden" name="MaBN" value="<?php echo htmlspecialchars($MaBN); ?>">

        <!-- Họ Tên -->
        <div class="form-group">
            <label for="Ten">Họ Tên</label>
            <input type="text" id="Ten" name="Ten" value="<?php echo htmlspecialchars($Ten); ?>" placeholder="Nhập họ tên..." required>
        </div>

        <!-- Ngày Sinh -->
        <div class="form-group">
            <label for="NgaySinh">Ngày Sinh</label>
            <input type="date" id="NgaySinh" name="NgaySinh" value="<?php echo htmlspecialchars($NgaySinh); ?>" required>
        </div>

        <!-- Giới Tính -->
        <div class="form-group">
            <label for="GioiTinh">Giới Tính</label>
            <select id="GioiTinh" name="GioiTinh" required>
                <option value="Nam" <?php if ($GioiTinh == 'Nam') echo 'selected'; ?>>Nam</option>
                <option value="Nữ" <?php if ($GioiTinh == 'Nữ') echo 'selected'; ?>>Nữ</option>
            </select>
        </div>

        <!-- Địa Chỉ -->
        <div class="form-group">
            <label for="DiaChi">Địa Chỉ</label>
            <input type="text" id="DiaChi" name="DiaChi" value="<?php echo htmlspecialchars($DiaChi); ?>" placeholder="Nhập địa chỉ..." required>
        </div>

        <!-- Số Điện Thoại -->
        <div class="form-group">
            <label for="SoDienThoai">Số Điện Thoại</label>
            <input type="text" id="SoDienThoai" name="SoDienThoai" value="<?php echo htmlspecialchars($SoDienThoai); ?>" placeholder="Nhập số điện thoại..." required>
        </div>

        <!-- Thông Tin Bảo Hiểm -->
        <div class="form-group">
    <label for="ThongTinBaoHiem">Thông Tin Bảo Hiểm</label>
    <input type="text" id="ThongTinBaoHiem" name="ThongTinBaoHiem" value="<?php echo htmlspecialchars($ThongTinBaoHiem ?: 'Không'); ?>" placeholder="Nhập thông tin bảo hiểm...">
        </div>

        <!-- Buttons -->
        <div class="button-group">
            <button type="submit" name="btnSubmit" class="btn btn-save">Lưu Thay Đổi</button>
            <button type="button" class="btn btn-cancel" onclick="window.location.href = 'QLHSBN.php';">Hủy</button>
        </div>
    </form>
</div>

<!-- Footer Section -->
<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="js/script.js"></script>

<script>
    // Kiểm tra và xử lý thông tin bảo hiểm khi form được submit
    document.querySelector('form').addEventListener('submit', function(event) {
        var thongTinBaoHiem = document.getElementById('ThongTinBaoHiem').value;

        // Nếu trường "Thông Tin Bảo Hiểm" trống, gán giá trị mặc định là 'Không'
        if (!thongTinBaoHiem.trim()) {
            document.getElementById('ThongTinBaoHiem').value = 'Không';
        }
    });
</script>

</body>
</html>
