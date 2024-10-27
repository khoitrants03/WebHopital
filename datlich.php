<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Giới thiệu</title>
   <link rel="shortcut icon" href="./imgs/hospital-solid.svg" type="image/x-icon">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link 
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"> -->

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <!-- header section starts  -->
   <?php include 'components/user_header.php'; ?>
   <!-- header section ends -->

    <div class="heading">
    <h3>Đặt lịch khám bệnh</h3>
    <p><a href="home.php">Trang chủ</a> <span> / lịch khám</span></p>
    </div>

   <!-- about section starts  -->

   <!-- Section for Appointment Booking -->
<div class="appointment-section">
   <div class="appointment-container">
      

      <!-- Form đặt lịch khám -->
      <form action="" method="post" class="appointment-form">
        <h1>Đặt lịch khám</h1>
      <h2>Đảm bảo sức khỏe cho bạn và gia đình bằng cách đặt lịch khám nhanh chóng và thuận tiện</h2>
         <div class="row">
            <input type="text" name="name" required placeholder="Họ tên" class="box">
            <select name="gender" class="box" required>
               <option value="" disabled selected>Giới tính</option>
               <option value="nam">Nam</option>
               <option value="nu">Nữ</option>
            </select>
         </div>
         <div class="row">
            <input type="email" name="email" required placeholder="Email" class="box">
            <input type="number" name="phone" required placeholder="Số điện thoại" class="box">
         </div>
         <div class="row">
            <input type="date" name="appointment_date" required class="box">
            <select name="appointment_time" class="box" required>
               <option value="" disabled selected>Thời gian</option>
               <option value="09:00">09:00 - 10:00</option>
               <option value="10:00">10:00 - 11:00</option>
               <option value="11:00">11:00 - 12:00</option>
               <option value="14:00">14:00 - 15:00</option>
               <option value="15:00">15:00 - 16:00</option>
               <option value="16:00">16:00 - 17:00</option>
            </select>
         </div>
         <div class="row">
            <select name="department" class="box" required>
               <option value="" disabled selected>Bác sĩ</option>
               <option value="Bác sĩ A">Bác sĩ A</option>
               <option value="Bác sĩ B">Bác sĩ B</option>
               <option value="Bác sĩ C">Bác sĩ C</option>
            </select>
            <input type="number" name="room_number" placeholder="Số phòng" class="box">
         </div>
         <textarea name="note" class="box" placeholder="Lời nhắn" cols="30" rows="3"></textarea>
         <input type="submit" value="Submit" class="btn" name="submit">
      </form>
   </div>

   <div class="working-hours">
      <h2>Giờ làm việc</h2>
      <ul>
         <li>Thứ hai <span>09:00 AM - 07:00 PM</span></li>
         <li>Thứ ba <span>09:00 AM - 07:00 PM</span></li>
         <li>Thứ tư <span>09:00 AM - 07:00 PM</span></li>
         <li>Thứ năm <span>09:00 AM - 07:00 PM</span></li>
         <li>Thứ sáu <span>09:00 AM - 07:00 PM</span></li>
         <li>Thứ bảy <span>09:00 AM - 07:00 PM</span></li>
         <li>Chủ nhật <span>Closed</span></li>
      </ul>
      <div class="emergency">
         <h3>Cấp cứu</h3>
         <p>0384104942</p>
      </div>
   </div>
</div>


   <!-- footer section starts  -->
   <?php include 'components/footer.php'; ?>
   <!-- footer section ends -->=

   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

   <script>
      var swiper = new Swiper(".reviews-slider", {
         loop: true,
         grabCursor: true,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
         breakpoints: {
            0: {
               slidesPerView: 1,
            },
            700: {
               slidesPerView: 2,
            },
            1024: {
               slidesPerView: 3,
            },
         },
      });
   </script>

</body>

</html>