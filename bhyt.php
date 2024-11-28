<?php
include 'components/connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:home.php');
}

// Khởi tạo biến thông báo
$message = '';

// Xử lý khi form được submit
if (isset($_POST['check'])) {
   $bhyt_id = $_POST['bhyt_id'];
   
   // Kiểm tra mã BHYT/CCCD đã tồn tại trong cơ sở dữ liệu
   $query = "SELECT * FROM bhyt_table WHERE bhyt_id = ?";
   $stmt = $conn->prepare($query);
   $stmt->execute([$bhyt_id]);
   
   if ($stmt->rowCount() > 0) {
       // Nếu mã đã tồn tại
       $message = "Mã BHYT/CCCD đã tồn tại.";
   } else {
       // Nếu chưa có
       $message = "Mã BHYT/CCCD chưa có trong cơ sở dữ liệu.";
   }
}



if (isset($_POST['add'])) {
   $bhyt_id = $_POST['bhyt_id'];
   $start_date = $_POST['start_date'];
   $end_date = $_POST['end_date'];

   if (!empty($bhyt_id) && !empty($start_date) && !empty($end_date)) {
      $query = "SELECT * FROM bhyt_table WHERE bhyt_id = ?";
      $stmt = $conn->prepare($query);
      $stmt->execute([$bhyt_id]);

      if ($stmt->rowCount() > 0) {
         $message = "Dữ liệu đã có, không thể thêm.";
      } else {
         $insert_query = "INSERT INTO bhyt_table (bhyt_id, start_date, end_date) VALUES (?, ?, ?)";
         $insert_stmt = $conn->prepare($insert_query);
         $insert_stmt->execute([$bhyt_id, $start_date, $end_date]);
         $message = "Thêm mã BHYT/CCCD thành công.";

         // Xóa dữ liệu trong form
         $_POST['bhyt_id'] = '';
         $_POST['start_date'] = '';
         $_POST['end_date'] = '';
      }
   } else {
      $message = "Vui lòng nhập đầy đủ thông tin.";
   }
}

if (isset($_POST['delete'])) {
   $bhyt_id = $_POST['bhyt_id'];

   if (!empty($bhyt_id)) {
      $query = "SELECT * FROM bhyt_table WHERE bhyt_id = ?";
      $stmt = $conn->prepare($query);
      $stmt->execute([$bhyt_id]);

      if ($stmt->rowCount() > 0) {
         $delete_query = "DELETE FROM bhyt_table WHERE bhyt_id = ?";
         $delete_stmt = $conn->prepare($delete_query);
         $delete_stmt->execute([$bhyt_id]);
         $message = "Xóa mã BHYT/CCCD thành công.";

         // Xóa dữ liệu trong form
         $_POST['bhyt_id'] = '';
         $_POST['start_date'] = '';
         $_POST['end_date'] = '';
      } else {
         $message = "Mã BHYT/CCCD không tồn tại.";
      }
   } else {
      $message = "Vui lòng nhập mã BHYT/CCCD để xóa.";
   }
}


?>

<!DOCTYPE html>
<html lang="vi">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Thêm BHYT</title>
   <link rel="shortcut icon" href="./imgs/icon.png" type="image/x-icon">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css"> 
   <link rel="stylesheet" href="css/bhyt.css"> 
</head>
<body>
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <p><a href="home.php">Trang chủ</a> <span> / Quản lý BHYT</span></p>
</div>

<div class="container">
   <aside class="sidebar">
      <button type="submit" form="bhytForm" name="add" class="confirm-btn">Thêm</button>
      <button type="submit" form="bhytForm" name="delete" class="confirm-btn">Xóa</button>
      <button onclick="window.location.href='danhsach_bhyt.php';">Danh sách BHYT</button>
   </aside>

   <section class="checkout">
      <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
      <form action="" method="post" id="bhytForm" class="insurance-form">
         <div class="form-group">
            <label for="bhyt_id">Số BHYT/CCCD</label>
            <input type="text" id="bhyt_id" name="bhyt_id" placeholder="Nhập số BHYT/CCCD" 
                  value="<?php echo isset($_POST['bhyt_id']) ? htmlspecialchars($_POST['bhyt_id']) : ''; ?>" required>
         </div>

         <div class="form-group">
            <label for="start_date">Ngày bắt đầu</label>
            <input type="date" id="start_date" name="start_date" 
                  value="<?php echo isset($_POST['start_date']) ? htmlspecialchars($_POST['start_date']) : ''; ?>" required>
         </div>

         <div class="form-group">
            <label for="end_date">Ngày hết hạn</label>
            <input type="date" id="end_date" name="end_date" 
                  value="<?php echo isset($_POST['end_date']) ? htmlspecialchars($_POST['end_date']) : ''; ?>" required>
         </div>

         <button type="submit" name="check" class="confirm-btn">Kiểm tra</button>
      </form>
   </section>


</div>

</body>
</html>