<?php
include_once("ketnoi.php");

class modelLDT {
    private $db;

    // Khởi tạo kết nối cơ sở dữ liệu
    public function __construct() {
        $this->db = new clsKetNoi();  // Khởi tạo đối tượng kết nối
    }

    // Lấy thông tin bệnh nhân theo mã bệnh nhân
    public function getHSBNById($MaBN) {
        $conn = $this->db->ketNoiDB();

        if ($conn) {
            $query = "SELECT * FROM benhnhan WHERE MaBN = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $MaBN);
            $stmt->execute();
            $result = $stmt->get_result();
            $this->db->closeKetNoi($conn);
            return $result->fetch_assoc();  // Trả về 1 bản ghi duy nhất
        } else {
            return false;
        }
    }

    // Lấy danh sách thuốc
    public function getThuoc() {
        $conn = $this->db->ketNoiDB();

        if ($conn) {
            $query = "SELECT * FROM thuoc";
            $result = $conn->query($query);
            $this->db->closeKetNoi($conn);
            return $result->fetch_all(MYSQLI_ASSOC);  // Trả về tất cả các bản ghi
        } else {
            return false;
        }
    }



    // Lưu đơn thuốc vào cơ sở dữ liệu

    public function saveDonThuoc($MaDonThuoc, $MaBN, $Thuoc, $ThanhTien) {
        $p = new clsKetNoi();
        $conn = $p->ketNoiDB(); // Khởi tạo kết nối
        
        if ($conn) {
            // Kiểm tra dữ liệu đầu vào
            if (empty($MaDonThuoc) || empty($MaBN) || empty($Thuoc) || empty($ThanhTien)) {
                return false; // Trả về false nếu dữ liệu không hợp lệ
            }
            
            // Câu lệnh SQL với 7 tham số
            $sql = "INSERT INTO DonThuoc (MaDonThuoc, MaBN, Thuoc, ThanhTien) VALUES (?, ?, ?, ?)";
            
            // Chuẩn bị câu lệnh
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt === false) {
                return false; // Trả về false nếu không chuẩn bị được câu lệnh
            }
            
            // Gắn giá trị cho các tham số
            mysqli_stmt_bind_param($stmt, "sssi", $MaDonThuoc, $MaBN, $Thuoc, $ThanhTien);
            
            // Thực thi câu lệnh
            $result = mysqli_stmt_execute($stmt);
            
            // Đóng kết nối
            $p->closeKetNoi($conn);
            
            // Trả về kết quả thực thi
            return $result;
        } else {
            return false; // Trả về false nếu không thể kết nối tới cơ sở dữ liệu
        }
    }

    // Hủy đơn thuốc
    public function cancelDonThuoc($MaDonThuoc) {
        $conn = $this->db->ketNoiDB();

        if ($conn) {
            // Xóa đơn thuốc khỏi cơ sở dữ liệu
            $query = "DELETE FROM DonThuoc WHERE MaDonThuoc = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $MaDonThuoc);
            $stmt->execute();
            $this->db->closeKetNoi($conn);
            return true;  // Trả về true nếu xóa thành công
        } else {
            return false;  // Trả về false nếu kết nối cơ sở dữ liệu thất bại
        }
    }
    // Lấy mã đơn thuốc lớn nhất
    public function getMaxMaDonThuoc() {
    $conn = $this->db->ketNoiDB();

    if ($conn) {
        $query = "SELECT MAX(MaDonThuoc) AS maxMaDonThuoc FROM DonThuoc";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        $this->db->closeKetNoi($conn);

        // Kiểm tra nếu không có đơn thuốc nào, trả về 1
        return isset($row['maxMaDonThuoc']) && $row['maxMaDonThuoc'] ? $row['maxMaDonThuoc'] + 1 : 1;
    } else {
        return false;  // Trả về false nếu kết nối cơ sở dữ liệu thất bại
    }
}
public function updateSoLuongTon($MaThuoc, $soLuongDaBan) {
    $conn = $this->db->ketNoiDB();

    if ($conn) {
        // Truy vấn để giảm số lượng tồn kho của thuốc
        $query = "UPDATE thuoc SET SoLuongTon = SoLuongTon - ? WHERE MaThuoc = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $soLuongDaBan, $MaThuoc);
        $stmt->execute();
        $this->db->closeKetNoi($conn);

        return $stmt->affected_rows > 0;  // Nếu có dòng bị ảnh hưởng, trả về true
    } else {
        return false;  // Trả về false nếu kết nối cơ sở dữ liệu thất bại
    }
}


}
?>
