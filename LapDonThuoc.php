<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

include_once("Controller/cLDT.php"); // Gọi Controller

// Khởi tạo session cho mảng thuốc đã thêm nếu chưa tồn tại
if (!isset($_SESSION['thuocAdded'])) {
    $_SESSION['thuocAdded'] = [];
}

$patient = null;              // Biến lưu thông tin bệnh nhân
$error_message = '';          // Biến lưu thông báo lỗi
$tongTien = 0;                // Tổng tiền đơn thuốc
$controller = new controllerLDT();
$thuocList = $controller->getThuoc(); // Lấy danh sách thuốc
$tongTien = 0;
$tongTienSauGiam = 0;
$giamGia = 0;


// Lấy mã bệnh nhân từ POST, GET hoặc session
$MaBN = isset($_POST['MaBN']) ? $_POST['MaBN'] : (isset($_GET['MaBN']) ? $_GET['MaBN'] : '');
if ($MaBN) {
    $_SESSION['MaBN'] = $MaBN;
    $patient = $controller->getHSBNById($MaBN);
    if (!$patient) {
        $error_message = "Không tìm thấy bệnh nhân với mã: " . $MaBN;
    }
}

// Tính tổng tiền từ danh sách thuốc trong session
foreach ($_SESSION['thuocAdded'] as $thuoc) {
    $tongTien += $thuoc['GiaTien'] * $thuoc['SoLuong'];
}

// Lấy mã đơn thuốc tiếp theo từ controller
if (!isset($_SESSION['MaDonThuoc'])) {
    $_SESSION['MaDonThuoc'] = $controller->getNextMaDonThuoc();
}

$MaDonThuoc = $_SESSION['MaDonThuoc'] ?: 1;

// Xử lý yêu cầu POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Thêm thuốc vào đơn
    if (isset($_POST['thuoc']) && isset($_POST['soLuong'])) {
        $thuocSelected = $_POST['thuoc'];
        $soLuong = $_POST['soLuong'];

        foreach ($thuocList as $thuoc) {
            if ($thuoc['MaThuoc'] === $thuocSelected) {
                if ($thuoc['SoLuongTon'] < $soLuong) {
                    echo "<script>alert('Số lượng thuốc không đủ');</script>";
                } else {
                    $tongTien += $thuoc['GiaTien'] * $soLuong;
                    $_SESSION['thuocAdded'][] = [
                        'MaThuoc' => $thuoc['MaThuoc'],
                        'TenThuoc' => $thuoc['Ten'],
                        'SoLuong' => $soLuong,
                        'DangThuoc' => $thuoc['DangThuoc'],
                        'GiaTien' => $thuoc['GiaTien']
                    ];
                }
                break;
            }
        }
    }

    // Kiểm tra bảo hiểm và áp dụng giảm giá nếu có
    $giamGia = 0;
    $tongTienSauGiam = 0;
    $tongTienSauGiam = $tongTien;
    if ($patient && $patient['ThongTinBaoHiem'] !== 'Không') {
        $giamGia = $tongTien * 0.7;
        $tongTienSauGiam = $tongTien * 0.3;
    }

    // Xóa thuốc khỏi danh sách
    if (isset($_POST['deleteThuoc'])) {
        $maThuocToDelete = $_POST['deleteThuoc'];
        foreach ($_SESSION['thuocAdded'] as $key => $thuoc) {
            if ($thuoc['MaThuoc'] === $maThuocToDelete) {
                $tongTien -= $thuoc['GiaTien'] * $thuoc['SoLuong'];
                unset($_SESSION['thuocAdded'][$key]);
                $_SESSION['thuocAdded'] = array_values($_SESSION['thuocAdded']);
                header("Location: " . $_SERVER['PHP_SELF'] . "?MaBN=" . $_SESSION['MaBN']);
                exit;
            }
        }
    }

    // Lưu đơn thuốc
    if (isset($_POST['saveDonThuoc'])) {
        if (!empty($_SESSION['thuocAdded']) && $patient) {
            // Lấy mã đơn thuốc mới
            $MaDonThuoc = $controller->getNextMaDonThuoc();
    
            // Dữ liệu đơn thuốc
            $Thuoc = $_SESSION['thuocAdded'];
            $ThanhTien = $tongTienSauGiam;
    
            // Gọi hàm lưu đơn thuốc
            $message = $controller->saveDonThuoc($MaDonThuoc, $patient['MaBN'], $Thuoc, $ThanhTien);
    
            // Hiển thị thông báo
            if ($message) {
                $_SESSION['message'] = $message; // Lưu thông báo vào session
                echo "<script>window.location.href = window.location.href;</script>";  // Tải lại trang để hiển thị thông báo
                unset($_SESSION['thuocAdded']);
                unset($_SESSION['MaDonThuoc']);
                header('Location: LapDonThuoc.php');
                exit;
            }
        } else {
            $_SESSION['message'] = 'Vui lòng chọn thuốc'; // Lưu thông báo lỗi
            header("Location: " . $_SERVER['PHP_SELF'] . "?MaBN=" . $_SESSION['MaBN']);
            exit;
        }
    }

    // Hủy đơn thuốc
    if (isset($_POST['cancelDonThuoc'])) {
        $message = $controller->cancelDonThuoc($MaDonThuoc);
        $_SESSION['message'] = $message; // Lưu thông báo vào session
        echo "<script>window.location.href = window.location.href;</script>";  // Tải lại trang để hiển thị thông báo
        unset($_SESSION['thuocAdded']);
        unset($_SESSION['MaDonThuoc']);
        header('Location: LapDonThuoc.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lập Đơn Thuốc</title>
    <link rel="shortcut icon" href="./imgs/hospital-solid.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../WebHopital-master/css/style.css">
    <link rel="stylesheet" href="../WebHopital-master/css/LDT.css">
</head>

<body>
<?php
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']);  // Xóa thông báo sau khi đã hiển thị
}
?>


   <!-- header section starts  -->
   <?php include 'components/user_header.php'; ?>
   <!-- header section ends -->

   <div class="heading">
      <h3>Lập Đơn Thuốc</h3>
      <p><a href="home.php">Trang chủ</a> <span> / Lập Đơn Thuốc</span></p>
   </div>

   <div class="appointment-section">
      <div class="form-container">
         <h3>Nhập Mã Bệnh Nhân</h3>

         <!-- Form nhập mã bệnh nhân -->
         <form action="" method="POST" class="appointment-form">
            <div class="inputBox">
               <span>Mã Bệnh Nhân:</span>
               <input type="text" name="MaBN" placeholder="Nhập mã bệnh nhân" value="<?php echo isset($_SESSION['MaBN']) ? $_SESSION['MaBN'] : ''; ?>" required>
            </div>
            <input type="submit" value="Kiểm Tra" name="submit" class="btn">
         </form>

         <!-- Hiển thị thông tin bệnh nhân nếu tìm thấy -->
         <?php if ($patient): ?>
            <h3 style="margin-top: 15px; text-align: center;">Thông Tin Bệnh Nhân</h3>
            <div class="patient-info">
               <table>
                  <tr><th>Mã Bệnh Nhân</th><td><?php echo $patient['MaBN']; ?></td></tr>
                  <tr><th>Tên</th><td><?php echo $patient['Ten']; ?></td></tr>
                  <tr><th>Ngày Sinh</th><td><?php echo $patient['NgaySinh']; ?></td></tr>
                  <tr><th>Giới Tính</th><td><?php echo $patient['GioiTinh']; ?></td></tr>
                  <tr><th>Số Điện Thoại</th><td><?php echo $patient['SoDienThoai']; ?></td></tr>
                  <tr><th>Thông Tin Bảo Hiểm</th><td><?php echo $patient['ThongTinBaoHiem']; ?></td></tr>
               </table>
            </div>

            <h3 style="margin-top: 15px; text-align: center;">Mã Đơn Thuốc: <?php echo $_SESSION['MaDonThuoc']; ?></h3> 

            <!-- Form Chọn Thuốc -->
            <h3 style="margin-top: 15px; text-align: center;">Chọn Thuốc</h3>
            <form action="" method="POST" class="appointment-form">
               <input type="hidden" name="MaBN" value="<?php echo $patient['MaBN']; ?>">
               <div class="inputBox">
                  <span>Thuốc:</span>
                  <select name="thuoc" required>
                     <?php foreach ($thuocList as $thuoc): ?>
                        <option value="<?php echo $thuoc['MaThuoc']; ?>">
                           <?php echo $thuoc['Ten'] . " (Giá: " . number_format($thuoc['GiaTien'], 0, ',', '.') . " VNĐ)"; ?>
                        </option>
                     <?php endforeach; ?>
                  </select>
               </div>
               <div class="inputBox">
                  <span>Số Lượng:</span>
                  <input type="text" name="soLuong" id="soLuong" required oninput="validatePositiveNumber(event)">

<script>
function validatePositiveNumber(event) {
    const input = event.target;
    const value = input.value;

    // Kiểm tra nếu giá trị không phải là số hoặc là số âm
    if (isNaN(value) || value <= 0) {
        input.setCustomValidity('Vui lòng nhập một số dương');
    } else {
        input.setCustomValidity(''); // Xóa thông báo lỗi nếu giá trị hợp lệ
    }
}
</script>
               </div>
               <input type="submit" value="Thêm Thuốc" class="btn">
            </form>

            <!-- Danh Sách Thuốc Đã Thêm -->
            <h3 style="margin-top: 20px;">Danh Sách Thuốc Đã Thêm</h3>
            <?php if (!empty($_SESSION['thuocAdded'])): ?>
               <table>
                  <tr>
                     <th>Tên Thuốc</th>
                     <th>Số Lượng</th>
                     <th>Dạng Thuốc</th>
                     <th>Hành Động</th>
                  </tr>
                  <?php foreach ($_SESSION['thuocAdded'] as $thuoc): ?>
                     <tr>
                        <td><?php echo $thuoc['TenThuoc']; ?></td>
                        <td><?php echo $thuoc['SoLuong']; ?></td>
                        <td><?php echo $thuoc['DangThuoc']; ?></td>
                        <td>
                           <form action="" method="POST" style="display:inline;">
                              <input type="hidden" name="deleteThuoc" value="<?php echo $thuoc['MaThuoc']; ?>">
                              <input type="submit" value="Xóa" class="btn-delete">
                           </form>
                        </td>
                     </tr>
                  <?php endforeach; ?>
               </table>
            <?php else: ?>
               <p>Chưa có thuốc nào được thêm.</p>
            <?php endif; ?>

            <!-- Tính Tổng Tiền -->
            <h3 style="margin-top: 20px;">Tổng Tiền: <?php echo number_format($tongTien, 0, ',', '.'); ?> VNĐ</h3>
            <?php if ($patient['ThongTinBaoHiem'] !== 'Không'): ?>
               <h4>Giảm Giá (70%): <?php echo number_format($giamGia, 0, ',', '.'); ?> VNĐ</h4>
               <h4>Thành Tiền: <?php echo number_format($tongTienSauGiam, 0, ',', '.'); ?> VNĐ</h4>
            <?php else: ?>
               <h4>Thành Tiền: <?php echo number_format($tongTienSauGiam, 0, ',', '.'); ?> VNĐ</h4>
            <?php endif; ?>
            
            <!-- hai nút Lưu và Hủy đơn thuốc -->
            <form action="" method="POST" style="text-align: center; margin-top: 20px;">
               <input type="hidden" name="MaBN" value="<?php echo $patient['MaBN']; ?>">
               <input type="submit" name="saveDonThuoc" value="Lưu Đơn Thuốc" class="btn-save">
               <input type="submit" name="cancelDonThuoc" value="Hủy Đơn Thuốc" class="btn-delete">
            </form>
         <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && !$patient): ?>
            <p style="color:red; text-align:center;"><?php echo $error_message; ?></p>
         <?php endif; ?>

      </div>
   </div>

   <!-- footer section starts -->
   <?php include 'components/footer.php'; ?>
   <!-- footer section ends -->

   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
   <script src="js/script.js"></script>

</body>




</html>

