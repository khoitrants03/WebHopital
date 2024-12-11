<?php
include 'components/connect.php';
session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Danh sách Bác sĩ</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <?php include 'components/user_header.php'; ?>

   <div class="heading">
      <h3>Bác sĩ hiện có</h3>
      <p><a href="home.php">Trang chủ</a> <span> / Bác sĩ</span></p>
   </div>

   <section class="products">
      <h1 class="title">Danh sách bác sĩ</h1>

      <div class="box-container">
         <?php
         $select_doctors = $conn->prepare("SELECT * FROM `bacsi` LIMIT 6");
         $select_doctors->execute();
         
         if ($select_doctors->rowCount() > 0) {
            while ($doctor = $select_doctors->fetch(PDO::FETCH_ASSOC)) {
         ?>
            <div class="box">
               <a href="bacsichitiet.php?MaBS=<?= $doctor['MaBS']; ?>" class="fas fa-eye"></a>
               <div class="image">
                  <img src="uploaded_img/<?= $doctor['imge']; ?>" alt="<?= $doctor['Ten']; ?>">
               </div>
               <div class="name-flex">
                  <div class="name"><?= $doctor['Ten']; ?></div>
                  <div class="flex">
                     <div class="price">Chuyên Khoa: <?= $doctor['ChuyenKhoa']; ?></div>
                  </div>
               </div>
            </div>
         <?php
            }
         } else {
            echo '<p class="empty">Hiện chưa có bác sĩ để hiển thị!</p>';
         }
         ?>
      </div>
   </section>

   <?php include 'components/footer.php'; ?>
   <script src="js/script.js"></script>
</body>
</html>