<?php
include_once("ketnoi.php");
class modelHSBN{
    function selectAllHSBN(){
        $p = new clsKetNoi();
        $conn = $p->ketNoiDB(); 
        if($conn){
            $string = "SELECT * FROM benhnhan";
            $table = mysqli_query($conn, $string); 
            
            $p->closeKetNoi($conn); 
            return $table;
        }else{
            return false;
        }
    }
        // Lấy tất cả hồ sơ
        function selectAllHSBNPT($start, $limit) {
            $p = new clsKetNoi();
            $conn = $p->ketNoiDB();
            if ($conn) {
                $query = "SELECT * FROM benhnhan LIMIT ?, ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ii", $start, $limit);
                $stmt->execute();
                $result = $stmt->get_result();
                $p->closeKetNoi($conn);
                return $result;
            } else {
                return false;
            }
        }
    
        // Tính tổng số hồ sơ
        public function getTotalHSBNPT() {
            $p = new clsKetNoi();
            $conn = $p->ketNoiDB();
            if ($conn) {
                $query = "SELECT COUNT(*) as total FROM benhnhan";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $p->closeKetNoi($conn);
                return $row['total'];
            } else {
                return 0;
            }
        }
        public function addHSBN($MaBN, $Ten, $NgaySinh, $GioiTinh, $DiaChi, $SoDienThoai, $ThongTinBaoHiem) {
            $p = new clsKetNoi();
            $conn = $p->ketNoiDB(); // Khởi tạo kết nối
            
            if ($conn) {
                // Kiểm tra dữ liệu đầu vào
                if (empty($MaBN) || empty($Ten) || empty($NgaySinh) || empty($GioiTinh) || empty($DiaChi) || empty($SoDienThoai)) {
                    return false; // Trả về false nếu dữ liệu không hợp lệ
                }
                
                // Câu lệnh SQL với 7 tham số
                $sql = "INSERT INTO benhnhan (MaBN, Ten, NgaySinh, GioiTinh, DiaChi, SoDienThoai, ThongTinBaoHiem) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                
                // Chuẩn bị câu lệnh
                $stmt = mysqli_prepare($conn, $sql);
                if ($stmt === false) {
                    return false; // Trả về false nếu không chuẩn bị được câu lệnh
                }
                
                // Gắn giá trị cho các tham số
                mysqli_stmt_bind_param($stmt, "sssssss", $MaBN, $Ten, $NgaySinh, $GioiTinh, $DiaChi, $SoDienThoai, $ThongTinBaoHiem);
                
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
        
        public function xoaHSBNtheoId($maBN) {
            $p = new clsKetNoi();
            $conn = $p->ketnoiDB();
            if ($conn) {
                $query = "DELETE FROM benhnhan WHERE maBN = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $maBN);
                $result = $stmt->execute();
                $stmt->close();
                $p->closeKetNoi($conn);
        
                if ($result) {
                    return "Xóa Lịch Hồ Sơ Bệnh Nhân Thành Công.";  // Trả về thông báo thành công
                } else {
                    return "Có lỗi xảy ra khi xóa Hồ Sơ Bệnh Nhân.";  // Trả về thông báo lỗi
                }
            }
            return "Không thể kết nối đến cơ sở dữ liệu.";  // Trường hợp không kết nối được DB
        }
    public function getHSBNById($MaBN) {
        $p = new clsKetNoi();
        $conn = $p->ketNoiDB();
        if ($conn) {
            $query = "SELECT * FROM benhnhan WHERE MaBN = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $MaBN); // Bind tham số
            $stmt->execute();
            $result = $stmt->get_result();
            $p->closeKetNoi($conn);
    
            // Trả về kết quả
            return $result->fetch_assoc(); // Trả về mảng kết hợp chứa dữ liệu hồ sơ
        } else {
            return false; // Nếu không kết nối được
        }
    }
    public function checkHSBNExists($MaBN) {
        $p = new clsKetNoi();
        $conn = $p->ketNoiDB();
        if ($conn) {
            $query = "SELECT COUNT(*) as count FROM benhnhan WHERE MaBN = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $MaBN); // Gán tham số
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch(); // Lấy kết quả từ bind_result
            
            $p->closeKetNoi($conn);
    
            return $count > 0; // Trả về true nếu mã hồ sơ tồn tại
        }
        return false;
    }
    public function updateHSBN($MaBN, $Ten, $NgaySinh, $GioiTinh, $DiaChi, $SoDienThoai, $ThongTinBaoHiem) {
        // Kiểm tra giá trị đầu vào, đảm bảo không để trống hoặc sai kiểu dữ liệu
        if (empty($Ten) || !is_string($Ten)) {
            return "Tên không hợp lệ."; // Trả về lỗi nếu tên không hợp lệ
        }
    
        // Kiểm tra nếu thông tin bảo hiểm để trống, gán giá trị mặc định là 'Không'
        if (empty($ThongTinBaoHiem)) {
            $ThongTinBaoHiem = 'Không';
        }
    
        $p = new clsKetNoi();
        $conn = $p->ketNoiDB(); // Kết nối cơ sở dữ liệu
    
        if ($conn) {
            // Câu truy vấn cập nhật hồ sơ bệnh nhân
            $updateHSBNQuery = "UPDATE benhnhan
                                SET Ten = ?, NgaySinh = ?, GioiTinh = ?, DiaChi = ?, SoDienThoai = ?, ThongTinBaoHiem = ?
                                WHERE MaBN = ?";
    
            // Chuẩn bị câu truy vấn
            $stmt = $conn->prepare($updateHSBNQuery);
    
            if (!$stmt) {
                $p->closeKetNoi($conn);
                return "Lỗi chuẩn bị truy vấn: " . $conn->error;
            }
    
            // Gán tham số vào câu truy vấn
            $stmt->bind_param("sssssss", $Ten, $NgaySinh, $GioiTinh, $DiaChi, $SoDienThoai, $ThongTinBaoHiem, $MaBN);
    
            // Thực thi câu truy vấn
            if ($stmt->execute()) {
                $stmt->close();
                $p->closeKetNoi($conn);
                return "Cập nhật bệnh nhân thành công."; // Trả về thành công
            } else {
                $error = $stmt->error;
                $stmt->close();
                $p->closeKetNoi($conn);
                return "Lỗi khi cập nhật bệnh nhân: " . $error; // Trả về lỗi nếu không cập nhật được
            }
        } else {
            return "Không thể kết nối tới cơ sở dữ liệu."; // Trả về lỗi nếu không kết nối được
        }
    }
    public function searchHSBN($keyword, $limit = 10, $offset = 0) {
        $p = new clsKetNoi();
        $conn = $p->ketNoiDB(); // Kết nối cơ sở dữ liệu
    
        if ($conn) {
            $query = "SELECT * FROM benhnhan WHERE Ten LIKE ? OR MaBN LIKE ? LIMIT ? OFFSET ?";
            $stmt = $conn->prepare($query); // Chuẩn bị truy vấn
    
            if ($stmt) {
                $keyword = "%" . $keyword . "%"; // Chuyển đổi từ khóa thành dạng LIKE
                $stmt->bind_param("ssii", $keyword, $keyword, $limit, $offset); // Gắn tham số
                $stmt->execute(); // Thực thi truy vấn
    
                $result = $stmt->get_result(); // Lấy kết quả
                $p->closeKetNoi($conn); // Đóng kết nối
    
                return $result; // Trả về kết quả tìm kiếm
            } else {
                $p->closeKetNoi($conn); // Đóng kết nối nếu lỗi
                return false; // Lỗi trong chuẩn bị truy vấn
            }
        } else {
            return false; // Không kết nối được cơ sở dữ liệu
        }
    }
    
    // Tính tổng số hồ sơ bệnh nhân dựa trên từ khóa tìm kiếm
    public function countSearchHSBN($keyword) {
        $p = new clsKetNoi();
        $conn = $p->ketNoiDB(); // Kết nối cơ sở dữ liệu
    
        if ($conn) {
            $query = "SELECT COUNT(*) as total FROM benhnhan WHERE Ten LIKE ? OR MaBN LIKE ?";
            $stmt = $conn->prepare($query); // Chuẩn bị truy vấn
    
            if ($stmt) {
                $keyword = "%" . $keyword . "%"; // Chuyển đổi từ khóa thành dạng LIKE
                $stmt->bind_param("ss", $keyword, $keyword); // Gắn tham số
                $stmt->execute(); // Thực thi truy vấn
    
                $stmt->bind_result($total); // Gắn kết quả với biến $total
                $stmt->fetch(); // Lấy kết quả
                $p->closeKetNoi($conn); // Đóng kết nối
    
                return $total; // Trả về tổng số kết quả
            } else {
                $p->closeKetNoi($conn); // Đóng kết nối nếu lỗi
                return 0; // Lỗi trong chuẩn bị truy vấn
            }
        } else {
            return 0; // Không kết nối được cơ sở dữ liệu
        }
    }
    
}
?>
