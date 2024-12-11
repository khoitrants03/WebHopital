<?php
include_once("Model/mLDT.php");
include_once("Model/mQLHSBN.php");

class controllerLDT {
    private $model;

    // Khởi tạo đối tượng modelLDT
    public function __construct() {
        $this->model = new modelLDT();
    }

    // Lấy thông tin bệnh nhân theo mã
    public function getHSBNById($MaBN) {
        // Lấy thông tin bệnh nhân từ model
        $result = $this->model->getHSBNById($MaBN);
        // Trả về kết quả nếu có, nếu không trả về null
        return $result ? $result : null;
    }

    // Lấy danh sách thuốc
    public function getThuoc() {
        // Lấy danh sách thuốc từ model
        $result = $this->model->getThuoc();
        // Trả về danh sách thuốc nếu có, nếu không trả về null
        return $result ? $result : null;
    }

    // Lấy mã đơn thuốc tiếp theo
    public function getNextMaDonThuoc() {
        return $this->model->getMaxMaDonThuoc();
    }

    // Lưu đơn thuốc
    public function saveDonThuoc($MaDonThuoc, $MaBN, $Thuoc, $ThanhTien) {
        $thuocDetails = "";
        foreach ($Thuoc as $thuoc) {
            $thuocDetails .= $thuoc['TenThuoc'] . " (" . $thuoc['DangThuoc'] . ", Số lượng: " . $thuoc['SoLuong'] . "), ";
        }
        $thuocDetails = rtrim($thuocDetails, ', ');  // Loại bỏ dấu phẩy thừa
    
        // Lưu thông tin đơn thuốc cho bệnh nhân
        if ($this->model->saveDonThuoc($MaDonThuoc, $MaBN, $thuocDetails, $ThanhTien)) {
            // Cập nhật số lượng tồn kho của thuốc
            foreach ($Thuoc as $thuoc) {
                $this->model->updateSoLuongTon($thuoc['MaThuoc'], $thuoc['SoLuong']);
            }
            return "Đơn thuốc đã được lưu thành công!";  // Thông báo thành công
        } else {
            return "Có lỗi xảy ra trong quá trình lưu đơn thuốc.";  // Thông báo lỗi
        }
    }

    // Hủy đơn thuốc
    public function cancelDonThuoc($MaDonThuoc) {
        // Xóa đơn thuốc khỏi bảng DonThuoc
        if ($this->model->cancelDonThuoc($MaDonThuoc)) {
            return "Đơn thuốc đã được hủy thành công!";  // Thông báo thành công
        } else {
            return "Có lỗi xảy ra trong quá trình hủy đơn thuốc.";  // Thông báo lỗi
        }
    }
    
    // Cập nhật số lượng tồn
    public function updateSoLuongTon($MaThuoc, $soLuongDaBan) {
        // Gọi phương thức từ model để cập nhật số lượng tồn
        return $this->model->updateSoLuongTon($MaThuoc, $soLuongDaBan);
    }
}
?>
