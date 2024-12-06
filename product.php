<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sản phẩm</title>
   <link rel="shortcut icon" href="./imgs/hospital-solid.svg" type="image/x-icon">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <!-- header section starts  -->
   <?php
   if (isset($_SESSION['phanquyen'])) {
      if ($_SESSION['phanquyen'] === 'nhanvien') {
         require("components/user_header_doctor.php");
      } elseif ($_SESSION['phanquyen'] === 'bacsi') {
         require("components/user_header_doctor.php");
      } elseif ($_SESSION['phanquyen'] === 'benhnhan') {
         require("components/user_header_patient.php");
      }
      elseif ($_SESSION['phanquyen'] === 'tieptan') {
         require("components/user_header_tieptan.php");
      }
      elseif ($_SESSION['phanquyen'] === 'nhathuoc') {
         require("components/user_header_nhathuoc.php");
      }
   } else {
      include("components/user_header.php");
   }
   ?>  <!-- header section ends -->

   <div class="heading">
      <h3>Bác sĩ hiện có</h3>
      <p><a href="home.php">Trang chủ</a> <span> / Bác sĩ</span></p>
   </div>

   <!-- menu section starts  -->

   <section class="products">

      <h1 class="title">Danh sách bác sĩ </h1>

      <div class="box-container">

      <?php
            $select_products = $conn->prepare("SELECT * FROM `bacsi` LIMIT 6");
            $select_products->execute();
            if ($select_products->rowCount() > 0) {
               while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                  <form action="" method="post" class="box">
                     <input type="hidden" name="pid" value="<?= $fetch_products['MaBS']; ?>">
                     <input type="hidden" name="name" value="<?= $fetch_products['Ten']; ?>">
                     <input type="hidden" name="price" value=" <?= $fetch_products['ChuyenKhoa']; ?>">
                     <input type="hidden" name="image" value="<?= $fetch_products['imge']; ?>">
                     <a  class="fas fa-eye"></a>
                     <div class="image"  >
                        <img id="img"src="uploaded_img/<?= $fetch_products['imge']; ?>" alt="">
                     </div>
                     <div class="name-flex"  >
                        <div class="name">
                           <?= $fetch_products['Ten']; ?>
                        </div>
                        <div class="flex">
                           <div class="price">
                              Chuyên Khoa:
                              <?= $fetch_products['ChuyenKhoa']; ?>
                           </div>
                        </div>


                     </div>
                     <div class="profile" >
                  <h1>View Profile</h1>
                  </div>
                  </form>
                  <?php
               
            }
         } else {
            echo '<p class="empty">Hiện chưa có sản phẩm để hiển thị!</p>';
         }
         ?>

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