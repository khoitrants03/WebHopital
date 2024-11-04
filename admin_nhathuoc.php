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
                     Quản lí thuốc</a1>
               </div>
               <div class="box-item">
                  <a href="Register_medical_old.php">
                     <i class="fa fa-plus-square" aria-hidden="true"></i>Danh sách thuốc
                  </a>
               </div>
               <div class="box-item">
                  <a href="Register_medical_new.php"><i class="fa fa-plus-square" aria-hidden="true"></i>Thêm mới
                     thuốc</a>
               </div>
               <div class="box-item">
                  <a href="Register_medical_old.php">
                     <i class="fa fa-plus-square" aria-hidden="true"></i>Cập nhật thuộc
                  </a>
               </div>
               <div class="box-item">
                  <a href="Register_medical_old.php">
                     <i class="fa fa-plus-square" aria-hidden="true"></i> Xóa thuốc
                  </a>
               </div>
               <div class="box-item">
                  <a href="Register_medical_old.php">
                     <i class="fa fa-plus-square" aria-hidden="true"></i>Danh sách thuốc
                  </a>
               </div>
            </div>
         </div>
         <div class="register1">
         <h1>Danh sách thuốc</h1>
            <div class="card-container">
               <div class="card">
                  <imgsrc="imgs/OIP.jpg"  alt="Thuốc Kháng Sinh">
                  <h2>Thuốc Kháng Sinh</h2>
                  <a href="#">Learn More →</a>
               </div>
               <div class="card">
                  <img src="imgs/OIP.jpg"  alt="Thuốc giảm đau">
                  <h2>Thuốc giảm đau</h2>
                  <a href="#">Learn More →</a>
               </div>
               <div class="card">
                  <img src="imgs/OIP.jpg" alt="Thuốc chống viêm">
                  <h2>Thuốc chống viêm</h2>
                  <a href="#">Learn More →</a>
               </div>
               <div class="card">
                  <img src="imgs/OIP.jpg"  alt="Thuốc tim mạch">
                  <h2>Thuốc tim mạch</h2>
                  <a href="#">Learn More →</a>
               </div>
               <div class="card">
                  <img src="imgs/OIP.jpg" alt="Vitamin">
                  <h2>Vitamin</h2>
                  <a href="#">Learn More →</a>
               </div>
            </div>

         </div>

      </div>
      
      <style>
         .register1 {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f5f5f5;
            margin: 0;
         }

         h1 {
            font-size: 2em;
            color: #333;
            margin: 20px 0;
         }

         .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            max-width: 1000px;
            width: 100%;
            padding: 20px;
         }

         .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            padding: 15px;
         }

         .card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
         }

         .card h2 {
            font-size: 1.1em;
            color: #333;
            margin: 15px 0 10px;
         }

         .card a {
            display: inline-block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
         }

         .card a:hover {
            color: #0056b3;
         }
      </style>
   </section>


   <!-- menu section ends -->


   <!-- footer section starts  -->
   <?php include 'components/footer.php'; ?>
   <!-- footer section ends -->


   <!-- custom js file link  -->
   <script src=" js/script.js"></script>

</body>

</html>