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
include './convert_currency.php';
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
        <p><a href="home.php">Trang chủ</a> <span> / Dịch vụ</span></p>
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
                        <a href="#"><i class="fa fa-plus-square" aria-hidden="true"></i>Bệnh nhân mới</a>
                    </div>
                    <div class="box-item">
                        <a href="#">
                            <i class="fa fa-plus-square" aria-hidden="true"></i>Bệnh nhân cũ
                        </a>
                    </div>
                </div>
            </div>
            <div class="register">
                <form role="form" class="form-horizontal">
                    <table border="1">
                        <tbody>
                            <tr>
                                <td>ten</td>
                                <td ><input type="file" class="form-control" id="txtAnh" accept=".jpg, .jpeg, .png">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" id="btnSave" class="btn btn-success btn-block">Lưu</button>

                </form>
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