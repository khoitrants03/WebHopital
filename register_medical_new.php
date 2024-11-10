<?php
include 'components/connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dịch vụ</title>
    <link rel="shortcut icon" href="./imgs/hospital-solid.svg" type="image/x-icon">
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- header section starts -->
    <?php include 'components/user_header.php'; ?>
    <!-- header section ends -->

    <div class="heading">
        <h3>Đăng kí khám bệnh</h3>
        <p><a href="home.php">Trang chủ</a> <span> / Bệnh nhân</span><span> / Đăng kí khám bệnh</span></p>
    </div>

    <!-- menu section starts -->
    <section class="products">
        <div class="box-container">
            <div class="service">
                <div class="box_register">
                    <div class="box-item">
                        <a href="#"><i class="fa-sharp-duotone fa-solid fa-gears"></i> Đăng kí khám bệnh</a>
                    </div>
                    <div class="box-item">
                        <a href="Register_medical_new.php"><i class="fa fa-plus-square" aria-hidden="true"></i>Bệnh nhân
                            mới</a>
                    </div>
                    <div class="box-item">
                        <a href="Register_medical_old.php"><i class="fa fa-plus-square" aria-hidden="true"></i>Bệnh nhân
                            cũ</a>
                    </div>
                </div>
            </div>
            <div class="register">
                <div class="form-container">
                    <div class="form-title">Đăng kí bệnh nhân mới</div>
                    <form method="POST">
                        <div class="form-group">
                            <label for="randomNumber">Mã BN</label>
                            <input type="number" id="randomNumber" name="randomNumber" style="font-size: 2rem;"
                                readonly>
                            <script>
                                const generatedCodes = [];

                                function generateUniqueRandomNumber() {
                                    let randomNum;
                                    do {
                                        randomNum = Math.floor(Math.random() * 10000) + 1;
                                    } while (generatedCodes.includes(randomNum));
                                    generatedCodes.push(randomNum);
                                    return randomNum;
                                }

                                document.addEventListener("DOMContentLoaded", function () {
                                    const uniqueNumber = generateUniqueRandomNumber();
                                    document.getElementById("randomNumber").value = uniqueNumber;
                                });
                            </script>
                        </div>
                        <div class="form-group">
                            <label for="bhyt">Mã BHYT</label>
                            <input type="text" id="bhyt" name="bhyt" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Họ tên</label>
                            <input type="text" id="name" name="name" placeholder="Trần A" role="">
                        </div>
                        <div class="form-group">
                            <label for="dob">Ngày sinh</label>
                            <input type="date" id="dob" name="dob" required>
                        </div>
                        <div class="form-group">
                            <label>Giới tính</label>
                            <div class="gender-options">
                                <label><input type="radio" name="gender" value="male"> Nam</label>
                                <label><input type="radio" name="gender" value="female"> Nữ</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <input type="text" id="address" name="address" placeholder="chỉ nhập tên tỉnh">
                        </div>
                        <div class="form-group">
                            <label for="phonenumber">Số điện thoại</label>
                            <input type="text" id="phonenumber" name="phonenumber">
                        </div>

                        <button type="submit" class="submit-btn" name="addnew_patient">Xác nhận</button>


                    </form>
                </div>
            </div>

            <?php
            if (isset($_POST['addnew_patient'])) {
                $address = $_POST['address'];
                $addressPattern = '/^[A-Za-zÀ-ỹ\s]+$/';

                $maBHYT = filter_var($_POST['bhyt'], FILTER_SANITIZE_STRING);
                $check_bhyT = $conn->prepare("SELECT * FROM `benhnhan` WHERE ThongTinBaoHiem = ?");
                $check_bhyT->execute([$maBHYT]);

                if ($check_bhyT->rowCount() > 0) {
                    // Nếu mã BHYT đã tồn tại
                    echo "<script>alert('Mã BHYT này đã tồn tại!');</script>";
                } else if (!preg_match($addressPattern, $address)) {
                    echo "<script>alert('Địa chỉ không đúng định dạng. ví dụ: Hồ Chí Minh.');</script>";
                } else {
                    $maBN = filter_var($_POST['randomNumber'], FILTER_SANITIZE_STRING);
                    $maBHYT = filter_var($_POST['bhyt'], FILTER_SANITIZE_STRING);
                    $ten = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                    $ngaysinh = filter_var($_POST['dob'], FILTER_SANITIZE_STRING);
                    $gioitinh = filter_var($_POST['gender'], FILTER_SANITIZE_STRING);
                    $diachi = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
                    $sdt = filter_var($_POST['phonenumber'], FILTER_SANITIZE_STRING);

                    // Chèn dữ liệu vào cơ sở dữ liệu
                    $insert_patient = $conn->prepare("INSERT INTO `benhnhan` (MaBN, Ten, NgaySinh, GioiTinh, DiaChi, SoDienThoai, ThongTinBaoHiem) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $insert_patient->execute([$maBN, $ten, $ngaysinh, $gioitinh, $diachi, $sdt, $maBHYT]);

                    echo "<script>
                    alert('Thêm Mới Bệnh Nhân Thành Công.');
                    window.location.href = 'register_medical_old.php'; 
                </script>";
                }
            }

            ?>
        </div>
    </section>
    <!-- menu section ends -->

    <!-- footer section starts -->
    <?php include 'components/footer.php'; ?>
    <!-- footer section ends -->

    <!-- custom js file link -->
    <script src="js/script.js"></script>

</body>

</html>