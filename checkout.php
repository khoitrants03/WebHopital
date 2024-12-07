<?php
include 'components/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['patient_id'])) {
    $patient_id = trim($_POST['patient_id']);

    if (empty($patient_id)) {
        echo json_encode(['error' => 'Vui lòng nhập mã bệnh nhân.']);
        exit;
    }

    try {
        // Truy vấn thông tin bệnh nhân
        $stmt = $conn->prepare("SELECT * FROM benhnhan WHERE MaBN = ?");
        $stmt->execute([$patient_id]);
        $patient_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$patient_data) {
            echo json_encode(['error' => 'Mã bệnh nhân không tồn tại.']);
            exit;
        }

        // Tính tiền thuốc
        $medicine_fee = 0;
        $medicine_stmt = $conn->prepare("
            SELECT dt.SoLuong, t.GiaTien 
            FROM donthuoc dt
            JOIN thuoc t ON dt.MaThuoc = t.MaThuoc
            WHERE dt.MaBN = ?
        ");
        $medicine_stmt->execute([$patient_id]);

        while ($medicine = $medicine_stmt->fetch(PDO::FETCH_ASSOC)) {
            $medicine_fee += $medicine['SoLuong'] * $medicine['GiaTien'];
        }

        // Trả về dữ liệu
        echo json_encode([
            'name' => $patient_data['Ten'],
            'consultation_fee' => 500000,  // Tiền khám cố định
            'test_fee' => 150000,          // Tiền xét nghiệm cố định
            'medicine_fee' => $medicine_fee,
            'total_amount' => 500000 + 150000 + $medicine_fee
        ]);
    } catch (Exception $e) {
        echo json_encode(['error' => 'Lỗi xử lý: ' . $e->getMessage()]);
    }
    exit;
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
    <style>
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group select { width: 100%; padding: 8px; }
        .confirm-btn { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        .confirm-btn:hover { background-color: #45a049; }
    </style>
</head>
<body>
<section class="checkout">
    <h1 class="title">Thanh Toán</h1>

    <!-- Form chính -->
    <form action="hoadon.php" method="post" class="payment-form">
        <div class="form-group">
            <label for="patient_id">Mã bệnh nhân</label>
            <input type="text" id="patient_id" name="patient_id" placeholder="Nhập mã bệnh nhân" required>
        </div>

        <div class="form-group">
            <label for="name">Họ tên</label>
            <input type="text" id="name" name="name" readonly>
        </div>

        <div class="form-group">
            <label for="department">Khoa khám</label>
            <input type="text" id="department" name="department" readonly>
        </div>

        <div class="form-group">
            <label for="consultation_fee">Tiền khám bệnh</label>
            <input type="text" id="consultation_fee" name="consultation_fee" readonly>
        </div>

        <div class="form-group">
            <label for="medicine_fee">Tiền thuốc</label>
            <input type="text" id="medicine_fee" name="medicine_fee" readonly>
        </div>

        <div class="form-group">
            <label for="test_fee">Tiền xét nghiệm</label>
            <input type="text" id="test_fee" name="test_fee" readonly>
        </div>

        <div class="form-group">
            <label for="total_amount">Tổng tiền</label>
            <input type="text" id="total_amount" name="total_amount" readonly>
        </div>

        <div class="form-group">
            <label for="payment_method">Hình thức thanh toán</label>
            <select id="payment_method" name="payment_method" required>
                <option value="cash">Tiền mặt</option>
                <option value="MoMo">MoMo</option>
                <option value="Visa">Visa</option>
            </select>
        </div>

        <button type="submit" name="submit" class="confirm-btn">Xác nhận</button>
    </form>
</section>

<script>
   document.getElementById('patient_id').addEventListener('blur', function () {
    const patientId = this.value.trim();

    if (patientId) {
        fetch('', { // Tệp PHP hiện tại
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ patient_id: patientId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                clearFields();
            } else {
                document.getElementById('name').value = data.name;
                document.getElementById('consultation_fee').value = data.consultation_fee;
                document.getElementById('medicine_fee').value = data.medicine_fee;
                document.getElementById('test_fee').value = data.test_fee;
                document.getElementById('total_amount').value = data.total_amount;
            }
        })
        .catch(error => console.error('Error:', error));
      } else {
         clearFields();
      }
   });

   function clearFields() {
      document.querySelectorAll('.form-group input[type="text"]').forEach(input => input.value = '');
   }

</script>
</body>
</html>
