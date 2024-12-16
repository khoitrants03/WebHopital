<?php
include_once("Model/mQLHSBN.php");
class controllQLHS {
    // Lấy tất cả hồ sơ bệnh nhân
    function getAllHSBN() {
        $p = new modelHSBN();
        $tblHSBN = $p->selectAllHSBN();
        return $tblHSBN;
    }

    // Thêm hồ sơ bệnh nhân
    public function addHSBN($MaBN, $Ten, $NgaySinh, $GioiTinh, $DiaChi, $SoDienThoai, $ThongTinBaoHiem) {
        $model = new modelHSBN(); // Khởi tạo đối tượng modelHSBN
        
        // Kiểm tra mã bệnh nhân đã tồn tại
        if ($model->checkHSBNExists($MaBN)) {
            return "Mã bệnh nhân đã tồn tại."; // Trả về thông báo nếu mã đã tồn tại
        }
        
        // Thêm hồ sơ bệnh nhân mới
        $result = $model->addHSBN($MaBN, $Ten, $NgaySinh, $GioiTinh, $DiaChi, $SoDienThoai, $ThongTinBaoHiem);
        return $result ? "Thêm hồ sơ thành công." : "Lỗi khi thêm hồ sơ.";
    }

    // Xóa hồ sơ bệnh nhân
    public function deleteHSBN($MaBN) {
        $model = new modelHSBN();
        return $model->xoaHSBNtheoId($MaBN);  // Gọi model để xóa hồ sơ theo mã bệnh nhân
    }

    // Lấy tất cả hồ sơ bệnh nhân với phân trang
    public function getAllHSBNWithPagination($start, $limit) {
        $model = new modelHSBN();
        return $model->selectAllHSBNPT($start, $limit);
    }

    // Tính tổng số hồ sơ bệnh nhân
    public function getTotalHSBNPT() {
        $model = new modelHSBN();
        return $model->getTotalHSBNPT();
    }

    // Lấy hồ sơ bệnh nhân theo mã
    public function getHSBNById($MaBN) {
        $model = new modelHSBN();
        return $model->getHSBNById($MaBN);
    }

    // Cập nhật hồ sơ bệnh nhân
    public function updateHSBN($MaBN, $Ten, $NgaySinh, $GioiTinh, $DiaChi, $SoDienThoai, $ThongTinBaoHiem) {
        $model = new modelHSBN();
        return $model->updateHSBN($MaBN, $Ten, $NgaySinh, $GioiTinh, $DiaChi, $SoDienThoai, $ThongTinBaoHiem);
    }
    public function checkLichHenExists($MaBN) {
        $model = new modelHSBN(); 
        return $model->checkHSBNExists($MaBN); 
    }
    public function searchHSBN($keyword, $page = 1, $limit = 10) {
        $model = new modelHSBN(); // Khởi tạo đối tượng modelHSBN

        // Tính toán offset cho phân trang
        $offset = ($page - 1) * $limit;

        // Gọi phương thức tìm kiếm hồ sơ bệnh nhân từ model
        $result = $model->searchHSBN($keyword, $limit, $offset);
        $totalRecords = $model->countSearchHSBN($keyword); // Lấy tổng số hồ sơ bệnh nhân

        if ($result) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row; // Thêm từng hồ sơ vào mảng dữ liệu
            }

            // Trả kết quả dưới dạng mảng
            return [
                'success' => true,
                'data' => $data,
                'total' => $totalRecords
            ];
        } else {
            return [
                'success' => false,
                'message' => "Không tìm thấy kết quả."
            ];
        }
    }
}
?>
