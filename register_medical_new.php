<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}
;

// include 'components/add_cart.php';
// include './convert_currency.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dịch vụ</title>
    <link rel="shortcut icon" href="./imgs/hospital-solid.svg" type="image/x-icon">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <!-- header section starts  -->
    <?php include 'components/user_header.php'; ?>
    <!-- header section ends -->

    <div class="heading">
        <h3>Đăng kí khám bệnh</h3>
        <p><a href="home.php">Trang chủ</a> <span> / Bác sĩ</span><span> / Đăng kí khám bệnh</span></p>
    </div>

    <!-- menu section starts  -->

    <section class="products">


        <div class="box-container">

            <div class="service">
                <div class="box_register">
                    <div class="box-item">
                        <a1 href="#"><i class="fa-sharp-duotone fa-solid fa-gears"></i>
                            Đăng kí khám bệnh</a1>


                    </div>
                    <div class="box-item">
                        <a href="Register_medical_new.php"><i class="fa fa-plus-square" aria-hidden="true"></i>Bệnh nhân
                            mới</a>
                    </div>
                    <div class="box-item">
                        <a href="Register_medical_old.php">
                            <i class="fa fa-plus-square" aria-hidden="true"></i>Bệnh nhân cũ
                        </a>
                    </div>
                </div>
            </div>
            <div class="register">
                <div class="form-container">
                    <div class="form-title">Đăng kí khám bệnh mới</div>
                    <form>
                        <div class="form-group">
                            <label for="name">Họ tên</label>
                            <input type="text" id="name" placeholder="Trần A">
                        </div>
                        <div class="form-group">
                            <label for="dob">Ngày sinh</label>
                            <input type="date" id="dob">
                        </div>
                        <div class="form-group">
                            <label>Giới tính</label>
                            <div class="gender-options">
                                <label><input type="radio" name="gender" value="male"> Nam</label>
                                <label><input type="radio" name="gender" value="female"> Nữ</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bhyt">Mã BHYT</label>
                            <input type="text" id="bhyt">
                        </div>
                        <div class="form-group">
                            <label for="department">Khoa khám bệnh</label>
                            <select id="department">
                                <option value="tmh">Tai - Mũi - Họng</option>
                                <option value="nhi">Nhi</option>
                                <option value="noikhoa">Nội khoa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="appointment">Ngày khám</label>
                            <input type="date" id="appointment">
                        </div>
                        <button type="submit" class="submit-btn">Xác nhận</button>
                    </form>
      
                </div>
            </div>

    </section>


    <!-- menu section ends -->


    <!-- footer section starts  -->
    <?php include 'components/footer.php'; ?>
    <!-- footer section ends -->


    <!-- custom js file link  -->
    <script src=" js/script.js"></script>

</body>

</html>