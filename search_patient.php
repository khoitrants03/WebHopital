<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}
;

include 'components/add_cart.php';
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
        <h3>Lập phiếu khám bệnh</h3>
        <p><a href="home.php">Trang chủ</a> <span> / Bác sĩ</span></p>
    </div>

    <!-- menu section starts  -->

    <section class="products">


        <div class="box-container">

            <div class="service">
                <div class="box_register">
                    <div class="box-item">
                        <a1 href="#"><i class="fa-sharp-duotone fa-solid fa-gears"></i>
                        Lập phiếu khám</a1>
                    </div>
                    <div class="box-item">
                        <a href="#"><i class="fa fa-plus-square" aria-hidden="true"></i>Bệnh nhân
                        </a>
                    </div>
                </div>
            </div>
            <div class="register">
                <div class="form-container">
                    <div class="form-title">Tra cứu thông tin bệnh nhân</div>
                    <form>
            <div class="form-group">
                <label for="name">Họ tên</label>
                <input type="text" id="name" placeholder="Trần A">
            </div>
            <div class="form-group">
                <label for="bhyt">Mã định danh</label>
                <input type="text" id="bhyt">
            </div>
           <button type="submit" class="submit-btn"  > <a href="ticketing_doctor.php">Xác nhận</a></button>
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