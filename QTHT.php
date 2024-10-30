<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

include 'components/add_cart.php';
include './convert_currency.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Trang chủ</title>
   <link rel="shortcut icon" href="./imgs/hospital-solid.svg" type="image/x-icon">

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/qtht.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>
   <div class="container">
    <h1 style="text-align: center;">Quản Lý Tài Khoản</h1>
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Tìm kiếm tài khoản..."> <br>
        <button class="btn btn-add">Thêm Tài Khoản</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Mã Tài Khoản</th>
                <th>Tên Đăng Nhập</th>
                <th>Email</th>
                <th>Vai Trò</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>TK001</td>
                <td>user1</td>
                <td>user1@example.com</td>
                <td>Admin</td>
                <td>
                    <button class="btn btn-edit">Sửa</button>
                    <button class="btn btn-delete">Xóa</button>
                </td>
            </tr>
            <tr>
                <td>TK002</td>
                <td>user2</td>
                <td>user2@example.com</td>
                <td>Người dùng</td>
                <td>
                    <button class="btn btn-edit">Sửa</button>
                    <button class="btn btn-delete">Xóa</button>
                </td>
            </tr>
            <!-- Thêm các tài khoản khác tại đây -->
        </tbody>
    </table>
</div>
   <?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>