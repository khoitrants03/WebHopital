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
   <title>Xem chi thonong báo mới</title>
   <link rel="shortcut icon" href="./imgs/icon.png" type="image/x-icon">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="quick-view">

      <h1 class="title">Chi tiết</h1>

      <?php
      $pid = $_GET['pid'];
      $select_products = $conn->prepare("SELECT * FROM `tintuc` WHERE id = ?");
      $select_products->execute([$pid]);
      if ($select_products->rowCount() > 0) {
         while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
      ?>
            <form action="" method="post" class="box">
               <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
               <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                  <input type="hidden" name="new" value="<?= $fetch_products['name1']; ?>">
                  <input type="hidden" name="image" value="<?= $fetch_products['imge']; ?>">

               <!-- Hình ảnh sản phẩm -->
               <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
               <!-- Danh mục sản phẩm -->
               <!-- Tên sản phẩm -->
               <div class="name"><?= $fetch_products['name']; ?></div>

             
            </form>
      <?php
         }
      } else {
         echo '<p class="empty">Chưa có sản phẩm để hiển thị!</p>';
      }
      ?>

   </section>
















   <?php include 'components/footer.php'; ?>


   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>


</body>

</html>