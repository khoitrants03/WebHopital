<?php
 
if (isset($_GET['logout'])) {
    session_unset(); // Xóa tất cả biến trong session
    session_destroy(); // Hủy session
    header('Location: index.php'); // Quay lại trang chính
    exit;
}

// Kiểm tra xem người dùng đã đăng nhập hay chưa
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

 $user_name = null;
if ($user_id) {
    $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $select_profile->execute([$user_id]);
    if ($select_profile->rowCount() > 0) {
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        $user_name = $fetch_profile['name'];
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bèo Hospital</title>
    <link rel="stylesheet" href="styles.css"> 
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Thông báo -->
    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '
            <div class="message">
                <span>' . htmlspecialchars($msg) . '</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>';
        }
    }
    ?>

    <!-- Header -->
    <header class="header">
        <section class="content_bg-white">
            <a href="index.php" class="logo"><i id="logo" class="fas fa-hospital"></i>Bèo Hospital</a>

            <nav class="navbar">
                <a href="#"><i class="fas fa-phone-volume"></i> KHẨN CẤP: 1900 10854</a>
                <a href="#"><i class="fas fa-clock"></i> GIỜ LÀM VIỆC: 24/7</a>
                <a href="#"><i class="fas fa-map-marker-alt"></i> VỊ TRÍ: TP.HCM</a>
            </nav>
        </section>

        <section class="flex">
            <nav class="navbar">
                <a href="home.php">Trang chủ</a>
                <a href="about.php">Về chúng tôi</a>

                 <div class="dropdown">
                    <a href="product.php" class="dropdown-toggle">Bác sĩ</a>
                    <div class="dropdown-content">
                        <a href="admin_doctor.php">Quản lí bác sĩ</a>
                        <a href="product.php">Xem thông tin bác sĩ</a>
                        <a href="search_patient.php">Lập phiếu khám bệnh</a>
                    </div>
                </div>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle">Bệnh nhân</a>
                    <div class="dropdown-content">
                        <a href="patient_access.php">Thông tin bệnh nhân</a>
                        <a href="register_medical_old.php">Đăng kí khám bệnh</a>
                    </div>
                </div>
                <a href="orders.php">Lịch đã đặt</a>
                <a href="BHYT.php">Quản lý BHYT</a>
                <a href="search_patient_thungan.php">Thu ngân</a>
                <a href="contact.php">Liên hệ</a>
            </nav>

             <div class="icons">
                <?php
                $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $count_cart_items->execute([$user_id]);
                $total_cart_items = $count_cart_items->rowCount();
                ?>
                <a href="search.php"><i class="fas fa-search"></i></a>
                <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
                <div id="user-btn" class="fas fa-user"></div>
                <div id="menu-btn" class="fas fa-bars"></div>
            </div>

            <!-- Profile -->
            <div class="profile">
                <?php if ($user_name): ?>
                    <p class="name"><?= htmlspecialchars($user_name); ?></p>
                    <div class="flex">
                        <a href="profile.php" class="btn">Thông tin</a>
                        <a href="?logout=true" onclick="return confirm('Bạn có chắc muốn đăng xuất?');" class="delete-btn">Đăng xuất</a>
                    </div>
                <?php else: ?>
                    <p class="name">Vui lòng đăng nhập!</p>
                    <a href="login.php" class="btn">Đăng nhập</a>
                <?php endif; ?>
            </div>
        </section>
    </header>

 
</body>

</html>
