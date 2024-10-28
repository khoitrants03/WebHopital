-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 28, 2024 lúc 12:23 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `laptop_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `image` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `khoa` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `image`, `description`, `khoa`) VALUES
(1, 'THẠC SĨ, BS LÊ THỊ THU HÀ', 'Tổng quát', 22000000, 'BS-HA-KHOA-DD.png', 'Chủ nhiệm khoa tổng quát\r\n\r\n', ''),
(2, 'BSCKII. TRẦN ĐĂNG KHOA', 'Razer', 52130000, 'bs-Khoa-4x6-1-433x650.jpg', 'Sản phẩm với cấu hình mạnh mẽ, với con chip cân tất cả mọi tựa game hiện nay! Mua ngay với mức giá đầy ưu đãi!\r\n', ''),
(3, 'BSCKII. Thân Hồng Anh', 'Acer', 20500000, 'BS-Than-Hong-Anh-433x650.jpg', 'Sản phẩm với cấu hình mạnh mẽ, với con chip cân tất cả mọi tựa game hiện nay! Mua ngay với mức giá đầy ưu đãi!\r\n', ''),
(4, 'BS TRƯƠNG MINH THƯƠNG', 'Msi', 21490000, 'CNK_c8.jpg', 'Sản phẩm với cấu hình mạnh mẽ, với con chip cân tất cả mọi tựa game hiện nay! Mua ngay với mức giá đầy ưu đãi!\r\n', ''),
(5, 'BSCKII ĐỖ HỮU LƯƠNG', 'Asus', 12999000, 'CNK_YHTT.jpg', 'Sản phẩm với cấu hình mạnh mẽ, với con chip cân tất cả mọi tựa game hiện nay! Mua ngay với mức giá đầy ưu đãi!\r\n', ''),
(6, 'BS NG.THỊ HUYỀN TRANG', 'Msi', 20390000, 'NguyenThiHuyenTrang.jpg', 'Sản phẩm với cấu hình mạnh mẽ, với con chip cân tất cả mọi tựa game hiện nay! Mua ngay với mức giá đầy ưu đãi!\r\n', '');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
