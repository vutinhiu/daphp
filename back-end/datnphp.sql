-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 25, 2022 lúc 06:24 AM
-- Phiên bản máy phục vụ: 10.4.18-MariaDB
-- Phiên bản PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `datnphp`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `cate_id` int(11) NOT NULL,
  `cate_name` varchar(255) NOT NULL,
  `cate_pr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`cate_id`, `cate_name`, `cate_pr`) VALUES
(1, 'Áo Nam', 0),
(2, 'Áo Thun', 1),
(3, 'Áo Polo', 1),
(4, 'Áo Sơ Mi', 1),
(5, 'Áo Khoác', 1),
(6, 'Vest', 1),
(7, 'Áo Len', 1),
(8, 'Quần Nam', 0),
(9, 'Quần Jeans Nam', 8),
(10, 'Quần Kaki Nam', 8),
(11, 'Quần Vải Nam', 8),
(12, 'Quần Short Nam', 8),
(13, 'Quần Lót Nam', 8),
(14, 'Giày / Dép Nam', 0),
(15, 'Áo Nữ', 0),
(16, 'Quần Nữ', 0),
(17, 'Đầm', 0),
(18, 'Chân Váy', 0),
(19, 'Phụ Kiện', 0),
(20, 'Thắt Lưng', 19),
(21, 'Vớ', 19),
(22, 'Mũ Thời Trang', 19),
(23, 'Ví', 19),
(24, 'Túi / Balo', 19),
(25, 'Mắt Kính', 19),
(29, 'â', 28);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `cmt_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `cmt_content` text NOT NULL,
  `cmt_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`cmt_id`, `user_id`, `pro_id`, `cmt_content`, `cmt_date`) VALUES
(40, 24, 21, 'hello\r\n', '2022-05-31 23:29:00'),
(42, 37, 10, 'Đẹp quá shop ơii', '2022-07-02 22:09:10'),
(43, 37, 10, 'Tuyệt vời quá shop\r\n', '2022-07-02 22:09:20'),
(44, 37, 14, 'Áo siêu đẹp shop ơi\r\n', '2022-07-02 22:09:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_price` float NOT NULL,
  `order_date` date NOT NULL,
  `order_stt` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `order`
--

INSERT INTO `order` (`order_id`, `user_id`, `order_price`, `order_date`, `order_stt`) VALUES
(37, 24, 920000, '2022-05-30', 'Đã hủy'),
(38, 24, 240000, '2022-05-31', 'Đã hủy'),
(39, 24, 540000, '2022-06-06', 'Đang chờ xử lý'),
(40, 24, 1860000, '2022-06-19', 'Đã hủy'),
(41, 24, 940000, '2022-06-20', 'Giao hàng thành công'),
(42, 24, 2350000, '2022-06-20', 'Đang giao hàng'),
(43, 24, 240000, '2022-06-20', 'Đang chờ xử lý'),
(44, 24, 540000, '2022-06-20', 'Đang chờ xử lý'),
(45, 24, 690000, '2022-06-20', 'Đang chờ xử lý'),
(46, 24, 350000, '2022-06-20', 'Giao hàng thành công'),
(47, 24, 350000, '2022-06-20', 'Giao hàng thành công'),
(48, 24, 240000, '2022-06-21', 'Giao hàng thành công'),
(49, 37, 730000, '2022-07-02', 'Giao hàng thành công'),
(50, 42, 180000, '2022-07-04', 'Đang chờ xử lý'),
(51, 24, 1380000, '2022-07-04', 'Đang chờ xử lý');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_detail`
--

CREATE TABLE `order_detail` (
  `orderdt_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `size` varchar(4) NOT NULL,
  `orderdt_qty` int(11) NOT NULL,
  `orderdt_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `order_detail`
--

INSERT INTO `order_detail` (`orderdt_id`, `order_id`, `pro_id`, `size`, `orderdt_qty`, `orderdt_price`) VALUES
(1, 2, 14, 'L', 1, 380000),
(2, 2, 15, 'M', 2, 350000),
(3, 2, 11, 'XL', 1, 350000),
(4, 2, 10, 'XL', 5, 350000),
(5, 3, 10, 'M', 12, 350000),
(6, 4, 3, 'XL', 2, 240000),
(7, 5, 3, 'L', 1, 240000),
(8, 6, 3, 'M', 1, 240000),
(9, 7, 14, 'M', 1, 380000),
(10, 8, 46, '29', 1, 460000),
(11, 9, 15, 'M', 3, 350000),
(12, 10, 3, 'L', 6, 240000),
(13, 11, 15, 'M', 1, 350000),
(14, 12, 58, '2', 1, 200000),
(15, 13, 58, '2', 1, 200000),
(16, 14, 20, '28', 1, 480000),
(17, 15, 58, '2', 1, 200000),
(18, 16, 57, '39', 1, 85000),
(19, 17, 20, '28', 1, 480000),
(20, 18, 22, '31', 1, 480000),
(21, 19, 57, '40', 1, 85000),
(22, 20, 58, '2', 1, 200000),
(23, 21, 41, 'M', 1, 420000),
(28, 26, 42, 'M', 1, 470000),
(29, 27, 24, '29', 1, 480000),
(30, 28, 15, 'S', 2, 350000),
(31, 29, 3, 'M', 2, 240000),
(32, 30, 41, 'M', 1, 420000),
(34, 32, 5, 'S', 3, 120000),
(35, 33, 46, '29', 2, 460000),
(36, 34, 46, '29', 1, 460000),
(37, 34, 53, 'XL', 1, 340000),
(38, 35, 54, 'S', 1, 630000),
(39, 36, 43, 'L', 1, 180000),
(40, 37, 46, '31', 2, 460000),
(41, 38, 3, 'XL', 1, 240000),
(42, 39, 59, '4', 3, 180000),
(43, 40, 26, 'M', 2, 480000),
(44, 40, 60, '3', 2, 180000),
(45, 40, 43, 'L', 3, 180000),
(46, 41, 42, 'S', 2, 470000),
(47, 42, 42, 'M', 5, 470000),
(48, 43, 5, 'S', 2, 120000),
(49, 44, 59, '3', 3, 180000),
(50, 45, 35, '39', 1, 690000),
(51, 46, 10, 'L', 1, 350000),
(52, 47, 10, 'XL', 1, 350000),
(53, 48, 3, 'M', 1, 240000),
(54, 49, 14, 'M', 1, 380000),
(55, 49, 19, 'L', 1, 350000),
(56, 50, 59, '3', 1, 180000),
(57, 51, 21, '29', 2, 480000),
(58, 51, 41, 'L', 1, 420000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `pro_id` int(11) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `pro_name` varchar(255) NOT NULL,
  `pro_image` varchar(255) NOT NULL,
  `pro_price` float NOT NULL,
  `pro_sale` float NOT NULL,
  `pro_intro` text NOT NULL,
  `pro_view` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`pro_id`, `cate_id`, `pro_name`, `pro_image`, `pro_price`, `pro_sale`, `pro_intro`, `pro_view`) VALUES
(3, 2, 'Áo thun cotton form fitted - 10S20TSH045', 'aothun_3.png', 270000, 240000, '<p>Chất liệu: 100% Cotton<br />\r\nĐặc t&iacute;nh: Cảm gi&aacute;c mềm mại, thoải m&aacute;i, c&oacute; độ thấm h&uacute;t tốt, chống nhăn cao v&agrave; tr&aacute;nh b&aacute;m bụi.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường, với đồ c&oacute; m&agrave;u tương tự.- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy v&agrave; ủi ở nhiệt độ th&iacute;ch hợp.</p>\r\n', 8),
(4, 2, 'Áo thun ngắn tay form fitted - 10F19TSH001', 'aothun_4.png', 260000, 240000, '<p>Chất liệu: 57% cotton, 38% Modal, 5% Spandex<br />\r\nĐặc t&iacute;nh: Cảm gi&aacute;c mềm mại, thoải m&aacute;i, c&oacute; độ thấm h&uacute;t tốt, chống nhăn cao v&agrave; tr&aacute;nh b&aacute;m bụi.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường, với đồ c&oacute; m&agrave;u tương tự.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy v&agrave; ủi ở nhiệt độ th&iacute;ch hợp.</p>\r\n', 18),
(5, 2, 'Áo thun kẻ sọc ngang form regular - 10S20TSH019', 'aothun_5.png', 350000, 120000, '<p>Chất liệu: 100% cotton.<br />\r\nĐặc t&iacute;nh:&nbsp;Mềm mại, co gi&atilde;n tốt, c&oacute; độ thấm h&uacute;t mồ h&ocirc;i v&agrave; h&uacute;t ẩm cao, tho&aacute;ng m&aacute;t.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường, với đồ c&oacute; m&agrave;u tương tự.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy, ủi ở nhiệt độ b&igrave;nh thường.</p>\r\n', 25),
(6, 2, 'Áo Thun Nam Kẻ Sọc Ngang Form Regular 10S20TSH018', 'aothun_6.png', 260000, 240000, '<p>Chất liệu: 100% cotton.<br />\r\nĐặc t&iacute;nh:&nbsp;Mềm mại, co gi&atilde;n tốt, c&oacute; độ thấm h&uacute;t mồ h&ocirc;i v&agrave; h&uacute;t ẩm cao, tho&aacute;ng m&aacute;t.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường, với đồ c&oacute; m&agrave;u tương tự.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy, ủi ở nhiệt độ b&igrave;nh thường.</p>\r\n', 6),
(9, 2, 'Áo Thun Nam Tay Ngắn Sọc Dọc Form Regular 10S20TSH022', 'aothun_7.png', 320000, 290000, '<p>Chất liệu: 57% cotton, 5% Spandex,&nbsp;38% polyester.<br />\r\nĐặc t&iacute;nh: Cảm gi&aacute;c mềm mại, thoải m&aacute;i, c&oacute; độ thấm h&uacute;t tốt, chống nhăn cao v&agrave; tr&aacute;nh b&aacute;m bụi.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường, với đồ c&oacute; m&agrave;u tương tự.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy v&agrave; ủi ở nhiệt độ th&iacute;ch hợp.</p>\r\n', 1),
(10, 3, 'Áo polo, cổ áo phối màu form fitted - 10F20POL007', 'aopolo_1.png', 370000, 350000, '<p>Chất liệu: 100% cotton<br />\r\nĐặc t&iacute;nh: Co gi&atilde;n, h&uacute;t ẩm tốt v&agrave; thấm h&uacute;t mồ h&ocirc;i.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy.</p>\r\n', 15),
(11, 3, 'Áo thun polo form fitted - 10F20POL003', 'aopolo_2.png', 350000, 0, '<p>Chất liệu: 100% cotton.<br />\r\nĐặc t&iacute;nh: Mềm mại, độ bền cao, h&uacute;t ẩm v&agrave; h&uacute;t mồ h&ocirc;i tốt, hạ nhiệt v&agrave; l&agrave;m m&aacute;t cơ thể.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường, với đồ c&oacute; m&agrave;u tương tự.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy v&agrave; ủi ở nhiệt độ th&iacute;ch hợp.</p>\r\n', 8),
(12, 3, 'Áo polo phối màu form fitted - 10F20POL005', 'aopolo_3.png', 400000, 380000, '<p>Chất liệu: 60% cotton, 40% polyester<br />\r\nĐặc t&iacute;nh: Cảm gi&aacute;c mềm mại, thoải m&aacute;i, c&oacute; độ thấm h&uacute;t tốt.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường, với đồ c&oacute; m&agrave;u tương tự.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy v&agrave; ủi ở nhiệt độ th&iacute;ch hợp.</p>\r\n', 1),
(14, 3, 'Áo polo contrast sleeves form fitted - 10F20POL009', 'aopolo_4.png', 400000, 380000, '<p>Chất liệu: 60% cotton, 40% polyester<br />\r\nĐặc t&iacute;nh: Cảm gi&aacute;c mềm mại, thoải m&aacute;i, c&oacute; độ thấm h&uacute;t tốt.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường, với đồ c&oacute; m&agrave;u tương tự.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy v&agrave; ủi ở nhiệt độ th&iacute;ch hợp.</p>\r\n', 137),
(15, 3, 'Áo polo EMB form fitted - 10F20POL006', 'aopolo_5.png', 350000, 0, '<p>Chất liệu: 60% cotton, 40% polyester.<br />\r\nĐặc t&iacute;nh: Cảm gi&aacute;c mềm mại, thoải m&aacute;i, c&oacute; độ thấm h&uacute;t tốt, chống nhăn cao v&agrave; tr&aacute;nh b&aacute;m bụi.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường, với đồ c&oacute; m&agrave;u tương tự.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy v&agrave; ủi ở nhiệt độ th&iacute;ch hợp</p>\r\n', 56),
(16, 2, 'Áo thun cotton ngắn tay form fitted - 10S20TSH042', 'aothun_2.png', 220000, 0, '<p>Chất liệu: 100% Cotton<br />\r\nĐặc t&iacute;nh: Cảm gi&aacute;c mềm mại, thoải m&aacute;i, c&oacute; độ thấm h&uacute;t tốt, chống nhăn cao v&agrave; tr&aacute;nh b&aacute;m bụi<br />\r\n.Hướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường, với đồ c&oacute; m&agrave;u tương tự.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy v&agrave; ủi ở nhiệt độ th&iacute;ch hợp.</p>\r\n', 0),
(17, 2, 'Áo thun tay ngắn sọc đứng form regular - 10S20TSH021', 'ao_thun1.jpg', 250000, 200000, '<p>Chất liệu: 100% Cotton<br />\r\nĐặc t&iacute;nh: Cảm gi&aacute;c mềm mại, thoải m&aacute;i, c&oacute; độ thấm h&uacute;t tốt, chống nhăn cao v&agrave; tr&aacute;nh b&aacute;m bụi.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường, với đồ c&oacute; m&agrave;u tương tự.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy v&agrave; ủi ở nhiệt độ th&iacute;ch hợp.</p>\r\n', 2),
(18, 3, 'Áo Thun Polo Ngắn Tay Nam Form Fitted 10S20POL007', 'aopolo_6.png', 230000, 200000, '<p>Chất liệu: 96% cotton, 4% Spandex<br />\r\nĐặc t&iacute;nh: Cảm gi&aacute;c mềm mại, thoải m&aacute;i, c&oacute; độ thấm h&uacute;t tốt, chống nhăn cao v&agrave; tr&aacute;nh b&aacute;m bụi.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường, với đồ c&oacute; m&agrave;u tương tự.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy v&agrave; ủi ở nhiệt độ th&iacute;ch hợp.</p>\r\n', 1),
(19, 3, 'Áo polo phối màu - 10S20POL008', 'aopolo_7.png', 350000, 0, '<p>Chất liệu: 96% cotton, 4% Spandex<br />\r\nĐặc t&iacute;nh: Cảm gi&aacute;c mềm mại, thoải m&aacute;i, c&oacute; độ thấm h&uacute;t tốt, chống nhăn cao v&agrave; tr&aacute;nh b&aacute;m bụi.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường, với đồ c&oacute; m&agrave;u tương tự.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy v&agrave; ủi ở nhiệt độ th&iacute;ch hợp.</p>\r\n', 3),
(20, 9, 'Quần jean trơn form jogger - 10F20DPA105', 'quanjean_1.png', 480000, 0, '<p>Chất liệu: 70% cotton, 20% polyester, 8% rayon, 2% spandex.<br />\r\nĐặc t&iacute;nh: Co gi&atilde;n, h&uacute;t ẩm tốt v&agrave; thấm h&uacute;t mồ h&ocirc;i.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy</p>\r\n', 6),
(21, 9, 'Quần jean rách gối form slim - 10F20DPA028', 'quanjean_2.png', 500000, 480000, '<p>Chất liệu: 100% cotton.<br />\r\nĐặc t&iacute;nh: Co gi&atilde;n, h&uacute;t ẩm tốt v&agrave; thấm h&uacute;t mồ h&ocirc;i.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy.</p>\r\n', 56),
(22, 9, 'Quần jean trơn form loose - 10F20DPA040', 'quanjean_3.png', 480000, 0, '<p>Chất liệu: 100% cotton.<br />\r\nĐặc t&iacute;nh: Co gi&atilde;n, h&uacute;t ẩm tốt v&agrave; thấm h&uacute;t mồ h&ocirc;i.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy.</p>\r\n', 8),
(23, 9, 'Quần Jean rách gối form jogger - 10F20DPA034', 'quanjean_4.png', 500000, 470000, '<p>Chất liệu: 70% cotton, 20% polyester, 8% rayon, 2% spandex<br />\r\nĐặc t&iacute;nh: Co gi&atilde;n, h&uacute;t ẩm tốt v&agrave; thấm h&uacute;t mồ h&ocirc;i.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy.</p>\r\n', 1),
(24, 9, 'Quần jean trơn form slim crop - 10F20DPA064', 'quanjean_5.png', 500000, 480000, '<p>Chất liệu: 98% cotton, 2% spandex.<br />\r\nĐặc t&iacute;nh: Co gi&atilde;n, h&uacute;t ẩm tốt v&agrave; thấm h&uacute;t mồ h&ocirc;i.&lt;&gt;Hướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy.</p>\r\n', 6),
(25, 9, 'Quần jean trơn form slim crop - 10F20DPA031', 'quanjean_6.png', 500000, 0, '<p>Chất liệu: 98% cotton, 2% spandex.<br />\r\nĐặc t&iacute;nh: Co gi&atilde;n, h&uacute;t ẩm tốt v&agrave; thấm h&uacute;t mồ h&ocirc;i.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy.</p>\r\n', 0),
(26, 9, 'Quần jean rách gối form slim crop - 10F20DPA017', 'quanjean_7.png', 500000, 480000, '<p>Chất liệu: 98% cotton, 2% spandex.<br />\r\nĐặc t&iacute;nh: Co gi&atilde;n, h&uacute;t ẩm tốt v&agrave; thấm h&uacute;t mồ h&ocirc;i.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy.</p>\r\n', 22),
(27, 10, 'Quần kaki nam trơn form slim fit - 10F20PCA017', 'quankaki_1.png', 450000, 420000, '<p>Chất liệu: 97% cotton, 3% spandex.<br />\r\nĐặc t&iacute;nh: Mềm nhẹ, co gi&atilde;n, h&uacute;t ẩm tốt v&agrave; thấm h&uacute;t mồ h&ocirc;i.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ấm ở nhiệt độ kh&ocirc;ng qu&aacute; 40độC.<br />\r\n- Giặt mặt tr&aacute;i với đồ c&oacute; m&agrave;u tương tự.<br />\r\n- Kh&ocirc;ng sử dụng chất tẩy.<br />\r\n- Sấy ở nhiệt độ trung b&igrave;nh hoặc phơi trong b&oacute;ng r&acirc;m.</p>\r\n', 9),
(28, 10, 'Quần kaki form slim crop -10F20PCA005', 'quankaki_2.png', 480000, 450000, '<p>Chất liệu: 96% cotton,4% spandex<br />\r\nĐặc t&iacute;nh: Co gi&atilde;n, h&uacute;t ẩm tốt v&agrave; thấm h&uacute;t mồ h&ocirc;i.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ấm ở nhiệt độ kh&ocirc;ng qu&aacute; 40độC.<br />\r\n- Giặt mặt tr&aacute;i với đồ c&oacute; m&agrave;u tương tự.<br />\r\n- Kh&ocirc;ng sử dụng chất tẩy.<br />\r\n- Sấy ở nhiệt độ trung b&igrave;nh hoặc phơi trong b&oacute;ng r&acirc;m.</p>\r\n', 8),
(29, 10, 'Quần kaki form slim crop - 10F20PCA004', 'quankaki_3.png', 450000, 0, '<p>Chất liệu: 96% cotton, 4% spandex.<br />\r\nĐặc t&iacute;nh: Co gi&atilde;n, h&uacute;t ẩm tốt v&agrave; thấm h&uacute;t mồ h&ocirc;i.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ấm ở nhiệt độ kh&ocirc;ng qu&aacute; 40độC.<br />\r\n- Giặt mặt tr&aacute;i với đồ c&oacute; m&agrave;u tương tự.<br />\r\n- Kh&ocirc;ng sử dụng chất tẩy.<br />\r\n- Sấy ở nhiệt độ trung b&igrave;nh hoặc phơi trong b&oacute;ng r&acirc;m.</p>\r\n', 5),
(30, 10, 'Quần khaki form slim crop - 10F20PCA007', 'quankaki_4.png', 500000, 470000, '<p>Chất liệu: 96% Cotton, 4% Spandex<br />\r\nĐặc t&iacute;nh: Co gi&atilde;n, thấm h&uacute;t nhanh v&agrave; mềm nhẹ.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ấm ở nhiệt độ kh&ocirc;ng qu&aacute; 40độC.<br />\r\n- Giặt mặt tr&aacute;i với đồ c&oacute; m&agrave;u tương tự.<br />\r\n- Kh&ocirc;ng sử dụng chất tẩy.<br />\r\n- Sấy ở nhiệt độ trung b&igrave;nh hoặc phơi trong b&oacute;ng r&acirc;m.</p>\r\n', 1),
(31, 10, 'Quần kaki dài cotton form carrot - 10S20PCA002', 'quankaki_5.png', 450000, 430000, '<p>Chất liệu: 100% cotton<br />\r\nĐặc t&iacute;nh: Co gi&atilde;n, h&uacute;t ẩm tốt v&agrave; thấm h&uacute;t mồ h&ocirc;i.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ấm ở nhiệt độ kh&ocirc;ng qu&aacute; 40độC.<br />\r\n- Giặt mặt tr&aacute;i với đồ c&oacute; m&agrave;u tương tự.<br />\r\n- Kh&ocirc;ng sử dụng chất tẩy.<br />\r\n- Sấy ở nhiệt độ trung b&igrave;nh hoặc phơi trong b&oacute;ng r&acirc;m.</p>\r\n', 0),
(32, 10, 'Quần Kaki linen kẻ sọc - 10S20PCA007', 'quankaki_6.png', 340000, 0, '<p>Chất liệu: 49% Linen, 51% Viscose<br />\r\nĐặc t&iacute;nh: Co gi&atilde;n, h&uacute;t ẩm tốt v&agrave; thấm h&uacute;t mồ h&ocirc;i.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ấm ở nhiệt độ kh&ocirc;ng qu&aacute; 40độC.<br />\r\n- Giặt mặt tr&aacute;i với đồ c&oacute; m&agrave;u tương tự.<br />\r\n- Kh&ocirc;ng sử dụng chất tẩy.<br />\r\n- Sấy ở nhiệt độ trung b&igrave;nh hoặc phơi trong b&oacute;ng r&acirc;m.</p>\r\n', 0),
(33, 10, 'Quần Kaki Nam Form Carrot 10S20PCA002', 'quankaki_7.png', 650000, 600000, '<p>Chất liệu: 100% cotton.<br />\r\nĐặc t&iacute;nh: Co gi&atilde;n, h&uacute;t ẩm tốt v&agrave; thấm h&uacute;t mồ h&ocirc;i.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ấm ở nhiệt độ kh&ocirc;ng qu&aacute; 40độC.<br />\r\n- Giặt mặt tr&aacute;i với đồ c&oacute; m&agrave;u tương tự.<br />\r\n- Kh&ocirc;ng sử dụng chất tẩy.<br />\r\n- Sấy ở nhiệt độ trung b&igrave;nh hoặc phơi trong b&oacute;ng r&acirc;m.</p>\r\n', 0),
(34, 14, 'Giày Sneaker 10S20SHO001', 'giaydep_1.png', 700000, 680000, '<p>Chất liệu bền đẹp, form snecker &ocirc;m s&aacute;t b&agrave;n ch&acirc;n, tạo cảm gi&aacute;c &ecirc;m &aacute;i, dễ chịu.</p>\r\n', 0),
(35, 14, 'Giày Nam Slip On Da Lộn - GI107003', 'giaydep_2.png', 690000, 0, '<p>Slip on<br />\r\nMẫu gi&agrave;y ho&agrave;n to&agrave;n mới thiết kế đơn giản với m&agrave;u navy dễ phối đồ cho c&aacute;c ch&agrave;ng trai, chất&nbsp; da lộn mang lại sự tinh tế, mềm mại dễ chịu cho đ&ocirc;i b&agrave;n ch&acirc;n.</p>\r\n', 3),
(36, 14, 'Giày Nam Sneaker Đáp Xanh Rêu - GI212030', 'giaydep_3.png', 1300000, 1250000, '<p>White Sneaker<br />\r\nVới mẫu gi&agrave;y ho&agrave;n to&agrave;n mới thiết kế basic đ&aacute;p xanh r&ecirc;u ở ph&iacute;a sau gam m&agrave;u trắng tinh tế mềm mại, dễ chịu cho đ&ocirc;i ch&acirc;n.</p>\r\n', 0),
(37, 14, 'Giày Nam Chukka GI30700', 'giaydep_4.png', 1500000, 1300000, '<p>VŨ KH&Iacute; PH&Aacute;I MẠNH -&nbsp; CHUKKA<br />\r\n&ldquo;CHUKKA BOOTS Da Lộn&rdquo; l&agrave; sự lựa chọn th&uacute; vị cho phong c&aacute;ch h&agrave;ng ng&agrave;y với một ch&agrave;ng trai y&ecirc;u th&iacute;ch phong c&aacute;ch bụi bặm m&agrave; kh&ocirc;ng k&eacute;m phần &quot;bảnh bao&quot;<br />\r\nM&agrave;u đen cổ điển của da lộn ch&iacute;nh l&agrave; người bạn đồng h&agrave;nh trong lối mix đồ của nam giới. Nhưng bạn muốn tho&aacute;t khỏi v&ugrave;ng an to&agrave;n th&igrave; đừng qu&ecirc;n m&agrave;u Beige thời thượng v&agrave; th&acirc;n thiện.</p>\r\n', 2),
(38, 14, 'Dép Nam Xỏ Ngón Flip Flop - DE1170', 'giaydep_5.png', 150000, 0, '<p>&nbsp;D&eacute;p xỏ ng&oacute;n, họa tiết nhiệt đới, &ecirc;m nhẹ.</p>\r\n', 4),
(39, 14, 'Dép Nam Sandal 2 Bản Có Quai - DE312002', 'giaydep_6.png', 500000, 460000, '<p>Xăng đan nam m&agrave;u đen 2 bản, c&oacute; quai, đ&iacute;nh khuy kim loại loại tạo điểm nhấn.</p>\r\n', 0),
(40, 14, 'Giày Nam Sneaker Canvas GI207003', 'giaydep_7.png', 860000, 800000, '<p>SNEAKER CANVAS - Bước ch&acirc;n vững chắc cho ph&aacute;i mạnh!<br />\r\nChất liệu canvas v&agrave; da b&ograve; bền bỉ, cứng c&aacute;p. Thiết kế trẻ trung, năng động c&ugrave;ng đế gi&agrave;y b&aacute;m chắc, lớp l&oacute;t c&oacute; khả năng thấm h&uacute;t mồ h&ocirc;i tốt sẽ mang đến sự tự tin tr&ecirc;n mỗi bước ch&acirc;n của bạn.</p>\r\n', 0),
(41, 15, 'Áo sơ mi nữ, tay dài - 10F20SHLW044', 'aonu_1.png', 420000, 0, '<p>Chất liệu: 100% rayon.<br />\r\nĐặc t&iacute;nh: Mềm mại, h&uacute;t ẩm tốt, thấm h&uacute;t tốt.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy</p>\r\n', 42),
(42, 15, 'Áo khoác jean nữ - 10F20DJAW003', 'aonu_2.png', 500000, 470000, '<p>Chất liệu:<br />\r\nĐặc t&iacute;nh: Chống thấm nước tốt, tr&aacute;nh b&aacute;m bụi.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy.</p>\r\n', 28),
(43, 15, 'Áo thun nữ tay ngắn, cổ V - 10F20TSHW001', 'aonu_3.png', 180000, 0, '<p>Chất liệu:&lt;br&gt;Đặc t&iacute;nh: Chống thấm nước tốt, tr&aacute;nh b&aacute;m bụi.&lt;br&gt;Hướng dẫn sử dụng:&lt;br&gt;- Giặt ở nhiệt độ b&igrave;nh thường.&lt;br&gt;- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.&lt;br&gt;- Hạn chế sử dụng m&aacute;y sấy.</p>\r\n', 14),
(44, 15, 'Áo thun tay ngắn nữ, có print - 10F20TSHW002', 'aonu_4.png', 210000, 195000, '<p>Chất lượng:<br />\r\nĐặc t&iacute;nh: Chống thấm nước tốt, tr&aacute;nh b&aacute;m bụi.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy</p>\r\n', 6),
(45, 16, ' Quần jean nữ destroy - 10F20DPAW042', 'quannu_1.png', 450000, 0, '<p>Chất liệu: 100% cotton.<br />\r\nĐặc t&iacute;nh: Mềm mại, h&uacute;t ẩm tốt, thấm h&uacute;t tốt.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy</p>\r\n', 8),
(46, 16, 'Quần jean nữ trơn form carrot - 10F20DPAW045', 'quannu_2.png', 480000, 460000, '<p>Chất liệu: 100% cotton.<br />\r\nĐặc t&iacute;nh: mềm mại, thấm h&uacute;t tốt, h&uacute;t ẩm tốt.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy.</p>\r\n', 56),
(47, 16, 'Quần jean nữ trơn form straight - 10F20DPAW024', 'quannu_3.png', 550000, 0, '<p>Chất liệu:<br />\r\nĐặc t&iacute;nh: Chống thấm nước tốt, tr&aacute;nh b&aacute;m bụi.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy.</p>\r\n', 1),
(48, 16, 'Quần jean nữ tưa lai - 10F20DPAW026', 'quannu_4.png', 410000, 390000, '<p>Chất liệu: 75% cotton, 23% polyester, 2% spandex.<br />\r\nĐặc t&iacute;nh: Mềm mại, thấm h&uacute;t nước, h&uacute;t ẩm tốt, &iacute;t b&aacute;m bụi.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy.</p>\r\n', 0),
(49, 16, 'Quần jeans nữ ống loe - 10F20DPAW027', 'quannu_5.png', 440000, 0, '<p>Chất liệu: 75% cotton, 23% polyester, 2% spandex.&lt;br&gt;Đặc t&iacute;nh: Thấm nước tốt, h&uacute;t ẩm tốt, &iacute;t b&aacute;m bụi.&lt;br&gt;Hướng dẫn sử dụng:br&lt;&gt;- Giặt ở nhiệt độ b&igrave;nh thường.&lt;br&gt;- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.&lt;br&gt;- Hạn chế sử dụng m&aacute;y sấy.</p>\r\n', 0),
(50, 16, 'Quần jeans nữ ống loe - 10F20DPAW044', 'quannu_6.png', 650000, 635000, '<p>Chất liệu: 70% cotton, 20% polyester, 8% rayon, 2% spandex.<br />\r\nĐặc t&iacute;nh: Mềm mại, bền, h&uacute;t ẩm tốt, &iacute;t nhăn, &iacute;t b&aacute;m bụi.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy</p>\r\n', 4),
(51, 16, ' Quần kaki nữ thắt dây - 10F20PCAW003', 'quannu_7.png', 550000, 0, '<p>Chất liệu: 98% cotton, 2% spandex.<br />\r\nĐặc t&iacute;nh: Mềm mại, độ bền cao, h&uacute;t ẩm v&agrave; h&uacute;t mồ h&ocirc;i tốt, hạ nhiệt v&agrave; l&agrave;m m&aacute;t cơ thể.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp<br />\r\n- Hạn chế sử dụng m&aacute;y sấy.</p>\r\n', 0),
(52, 17, 'Đầm nữ dài sát nách, xẻ trụ - 10F20DREW023', 'dam_1.png', 500000, 480000, '<p>Chất liệu: 100% rayon.<br />\r\nĐặc t&iacute;nh: Mềm mại, m&aacute;t, thoải m&aacute;i, h&uacute;t ẩm tốt.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy</p>\r\n', 13),
(53, 17, 'Đầm nữ dài, 2 dây - 10F20DREW027', 'dam_2.png', 340000, 0, '<p>Chất liệu: 52% linen, 48% cotton.<br />\r\nĐặc t&iacute;nh: Mềm mại, h&uacute;t ẩm tốt, tho&aacute;ng kh&iacute;, m&aacute;t.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy</p>\r\n', 30),
(54, 17, 'Đầm nữ suông, xẻ trụ có lá cổ - 10F20DREW050', 'dam_3.png', 650000, 630000, '<p>Chất liệu: 55% linen, 45% viscose.<br />\r\nĐặc t&iacute;nh: Mềm mại, tho&aacute;ng kh&iacute;, thoải m&aacute;i.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy, ủi ở nhiệt độ th&iacute;ch hợp.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy</p>\r\n', 27),
(55, 21, 'Vớ dài họa tiết form freesize - 10F20SOC004', 'vo_1.png', 120000, 0, '<p>Chất liệu: 85% Polyester, 10% Linen, 5% Polyester&lt;br&gt;Giặt ở chế độ b&igrave;nh thường. &lt;br&gt;Kh&ocirc;ng sử dụng chất tẩy &lt;br&gt;Sấy ở nhiệt độ thấp&lt;br&gt;Kh&ocirc;ng ủi</p>\r\n', 3),
(56, 21, ' Vớ dài solid - 10F20SOC002', 'vo_2.png', 130000, 0, '<p>Chất liệu: 85% Polyester, 10% Linen, 5% Polyester<br />\r\nGiặt ở chế độ b&igrave;nh thường.<br />\r\nKh&ocirc;ng sử dụng chất tẩy<br />\r\nSấy ở nhiệt độ thấp<br />\r\nKh&ocirc;ng ủi</p>\r\n', 1),
(57, 21, 'Vớ hài cotton - 10S20SOC009', 'vo_3.png', 85000, 0, '<p>Chất liệu: 73% Cotton, 22% Polyester, 5% poly<br />\r\nGiặt ở chế độ b&igrave;nh thường.&nbsp;<br />\r\nKh&ocirc;ng sử dụng chất tẩy<br />\r\nSấy ở nhiệt độ thấp<br />\r\nKh&ocirc;ng ủi</p>\r\n', 9),
(58, 22, 'Nón lưỡi trai, có thêu form freesize - 10F20CAP013', 'mu_1.png', 210000, 200000, '<p>Ch&acirc;t liệu: 100% cotton.<br />\r\nĐặc t&iacute;nh:&nbsp;Mềm mại, c&oacute; độ thấm h&uacute;t mồ h&ocirc;i v&agrave; h&uacute;t ẩm cao, tho&aacute;ng m&aacute;t.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy, ủi ở nhiệt độ b&igrave;nh thường.</p>\r\n', 48),
(59, 22, 'Nón tròn không vành prints form freesize - 10F20CAP012', 'mu_2.png', 180000, 0, '<p>Ch&acirc;t liệu: 100% cotton.<br />\r\nĐặc t&iacute;nh:&nbsp;Mềm mại, c&oacute; độ thấm h&uacute;t mồ h&ocirc;i v&agrave; h&uacute;t ẩm cao, tho&aacute;ng m&aacute;t.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy, ủi ở nhiệt độ b&igrave;nh thường.</p>\r\n', 24),
(60, 22, 'Nón vành, nhãn point trang trí form freesize - 10F20CAP006', 'mu_3.png', 180000, 0, '<p>Ch&acirc;t liệu: 100% cotton.<br />\r\nĐặc t&iacute;nh:&nbsp;Mềm mại, c&oacute; độ thấm h&uacute;t mồ h&ocirc;i v&agrave; h&uacute;t ẩm cao, tho&aacute;ng m&aacute;t.<br />\r\nHướng dẫn sử dụng:<br />\r\n- Giặt ở nhiệt độ b&igrave;nh thường.<br />\r\n- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy.<br />\r\n- Hạn chế sử dụng m&aacute;y sấy, ủi ở nhiệt độ b&igrave;nh thường.</p>\r\n', 11),
(63, 10, 'Quần sóc ', 'quan_soc.png', 350000, 320000, '<p>Quần s&oacute;c d&aacute;ng đẹp gi&aacute; hợp l&yacute; , chất vải d&agrave;y</p>\r\n', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products_detail`
--

CREATE TABLE `products_detail` (
  `prodt_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `size` varchar(50) NOT NULL,
  `quantity` int(4) NOT NULL,
  `sold` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `products_detail`
--

INSERT INTO `products_detail` (`prodt_id`, `pro_id`, `size`, `quantity`, `sold`) VALUES
(15, 15, 'S', 1, 5),
(16, 15, 'M', 4, 2),
(18, 3, 'M', 9, 15),
(19, 4, 'M', 12, 3),
(20, 3, 'L', 12, 0),
(21, 3, 'XL', 23, 0),
(22, 4, 'L', 12, 0),
(23, 5, 'S', 23, 0),
(24, 5, 'M', 2, 0),
(25, 4, 'XL', 199, 99),
(26, 4, 'XXL', 7, 0),
(27, 5, 'L', 4, 0),
(28, 5, 'XL', 10, 0),
(29, 6, 'M', 11, 0),
(30, 6, 'L', 3, 0),
(31, 6, 'XL', 5, 0),
(32, 9, 'S', 12, 0),
(33, 9, 'M', 19, 0),
(34, 9, 'L', 7, 0),
(35, 10, 'M', 12, 0),
(36, 10, 'L', 9, 2),
(37, 10, 'XL', 8, 1),
(38, 10, 'XXL', 9, 0),
(39, 11, 'S', 5, 0),
(40, 11, 'M', 5, 0),
(41, 11, 'L', 7, 0),
(42, 11, 'XL', 7, 0),
(43, 12, 'M', 45, 0),
(44, 12, 'L', 4, 0),
(45, 12, 'XL', 43, 0),
(46, 14, 'S', 1, 0),
(47, 14, 'M', 6, 1),
(48, 14, 'L', 7, 0),
(49, 16, 'L', 9, 0),
(50, 16, 'XL', 11, 0),
(51, 16, 'XXL', 9, 0),
(52, 16, '2XXL', 8, 0),
(53, 17, 'S', 9, 0),
(54, 17, 'M', 9, 0),
(55, 17, 'L', 19, 0),
(56, 18, 'M', 3, 0),
(57, 18, 'L', 7, 0),
(58, 18, 'XL', 7, 0),
(59, 19, 'M', 5, 0),
(60, 19, 'L', 4, 1),
(61, 19, 'XL', 9, 0),
(62, 20, '28', 6, 1),
(63, 20, '29', 32, 0),
(64, 20, '30', 3, 0),
(65, 20, '31', 8, 0),
(66, 21, '28', 7, 0),
(67, 21, '29', 7, 0),
(68, 21, '30', 14, 0),
(69, 22, '29', 54, 0),
(70, 22, '30', 5, 0),
(71, 22, '31', 9, 0),
(72, 23, '28', 7, 0),
(73, 23, '29', 23, 0),
(74, 23, '30', 2, 0),
(75, 23, '31', 21, 0),
(76, 24, '28', 32, 0),
(77, 24, '29', 3, 0),
(78, 24, '30', 9, 0),
(79, 25, '27', 8, 0),
(80, 25, '28', 8, 0),
(81, 25, '29', 5, 0),
(82, 25, '30', 5, 0),
(83, 31, '28', 22, 0),
(84, 31, '29', 20, 0),
(85, 31, '30', 26, 0),
(86, 32, '30', 6, 0),
(87, 32, '31', 8, 0),
(88, 33, '30', 8, 0),
(89, 33, '31', 8, 0),
(90, 34, '39', 32, 0),
(91, 34, '40', 7, 0),
(92, 34, '41', 34, 0),
(93, 34, '42', 23, 0),
(94, 35, '39', 8, 0),
(95, 35, '40', 9, 0),
(96, 35, '41', 4, 0),
(97, 36, '39', 5, 0),
(98, 36, '40', 4, 0),
(99, 36, '41', 4, 0),
(100, 37, '40', 5, 0),
(101, 37, '41', 6, 0),
(102, 37, '42', 9, 0),
(103, 38, '40', 7, 0),
(104, 38, '41', 7, 0),
(105, 39, '39', 22, 0),
(106, 39, '40', 2, 0),
(107, 39, '41', 7, 0),
(108, 40, '38', 5, 0),
(109, 40, '39', 7, 0),
(110, 40, '40', 4, 0),
(111, 40, '41', 7, 0),
(112, 40, '42', 7, 0),
(113, 41, 'M', 4, 1),
(114, 41, 'L', 6, 0),
(115, 41, 'XL', 5, 0),
(116, 42, 'S', 20, 2),
(117, 42, 'M', 19, 1),
(118, 42, 'L', 12, 0),
(119, 43, 'M', 8, 0),
(120, 43, 'L', 9, 0),
(121, 43, 'XL', 9, 0),
(122, 44, 'S', 43, 0),
(123, 44, 'M', 6, 0),
(124, 44, 'L', 6, 0),
(125, 45, '26', 6, 0),
(126, 45, '27', 8, 0),
(127, 45, '28', 9, 0),
(128, 45, '29', 9, 0),
(129, 46, '29', 34, 0),
(130, 46, '30', 3, 0),
(131, 46, '31', 13, 0),
(132, 47, '28', 33, 0),
(133, 47, '29', 32, 0),
(134, 47, '30', 12, 0),
(135, 48, '28', 28, 0),
(136, 48, '29', 2, 0),
(137, 48, '30', 2, 0),
(138, 49, '28', 12, 0),
(139, 49, '29', 15, 0),
(140, 49, '30', 15, 0),
(141, 50, '29', 12, 0),
(142, 50, '30', 4, 0),
(143, 50, '31', 4, 0),
(144, 51, '28', 4, 0),
(145, 51, '29', 9, 0),
(146, 51, '30', 9, 0),
(147, 52, 'M', 11, 0),
(148, 52, 'L', 12, 0),
(149, 52, 'XL', 11, 0),
(150, 53, 'L', 2, 1),
(151, 53, 'XL', 9, 0),
(152, 54, 'S', 23, 0),
(153, 54, 'M', 20, 1),
(154, 54, 'L', 2, 0),
(155, 55, '39', 100, 0),
(156, 55, '40', 80, 0),
(157, 56, '39', 77, 0),
(158, 56, '40', 20, 0),
(159, 57, '39', 5, 0),
(160, 57, '40', 8, 1),
(161, 57, '41', 40, 0),
(162, 58, '4', 78, 0),
(163, 58, '2', 76, 2),
(164, 58, '3', 9, 0),
(165, 59, '2', 56, 0),
(166, 59, '3', 5, 0),
(167, 59, '4', 23, 0),
(168, 60, '2', 9, 0),
(169, 60, '3', 50, 0),
(170, 60, '4', 23, 0),
(171, 26, 'M', 12, 0),
(172, 27, '28', 34, 0),
(173, 28, '28', 45, 0),
(174, 3, 'xxl', 23, 0),
(175, 63, '37,38,39', 213, 0),
(176, 64, '2', 3, 0),
(177, 4, 'X', 150, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `slides`
--

CREATE TABLE `slides` (
  `slide_id` int(11) NOT NULL,
  `slide_image` varchar(255) NOT NULL,
  `slide_link` varchar(255) NOT NULL,
  `slide_pr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `slides`
--

INSERT INTO `slides` (`slide_id`, `slide_image`, `slide_link`, `slide_pr`) VALUES
(1, 'slide1.png', '', 1),
(2, 'slide2.png', '', 1),
(3, 'slide3.png', '', 1),
(4, '999.jpg', 'http://localhost/daphp/front-end/detail.php?cate_id=9&pro_id=20', 2),
(5, 'slide5.png', 'http://localhost/daphp/front-end/detail.php?cate_id=3&pro_id=10', 2),
(6, 'slide6.png', 'http://localhost/daphp/front-end/detail.php?cate_id=9&pro_id=26', 2),
(7, 'slide7.png', 'http://localhost/daphp/front-end/detail.php?cate_id=9&pro_id=26', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `theme`
--

CREATE TABLE `theme` (
  `theme_id` int(11) NOT NULL,
  `theme_logo` varchar(255) NOT NULL,
  `theme_phone` varchar(20) NOT NULL,
  `theme_email` varchar(100) NOT NULL,
  `theme_add` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `theme`
--

INSERT INTO `theme` (`theme_id`, `theme_logo`, `theme_phone`, `theme_email`, `theme_add`) VALUES
(1, 'logo.png', '0368414131', 'vutienhieu91100@gmail.com', '175 Tây sơn, Đống đa, Hà nội');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `password` varchar(70) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `avatar`, `email`, `role`) VALUES
(24, 'admin', '$2y$10$Rw/UN3M6sQh/KDTgt07zeuopjgAczJlmQYg.3zhItNU2xJ7nBMQeu', '272767260_3035301346783210_565194018402450724_n.jpg', 'admin@gmail.com', 2),
(32, '123ghi', '$2y$10$csPEY.XRxNxZOQ4.9qn3/ukL3rMeSnW9OIcAcEE078qPrRUFMHhVS', 'none.png', 'ghi@gmail.com', 0),
(33, '123ghi2', '$2y$10$KWhjDDJjmaAxSRPTNgievulVcQAwf2NK.r4VMmznfXEbLXk.Ra66C', 'none.png', 'ghi22@gmail.com', 0),
(34, '1234567', '$2y$10$DWNdOU67z679S/QuPZZeSuGTiNUC/t8NNY97lWRqYSDu8Xn72QW6W', 'none.png', '12345@gmail.com', 0),
(35, 'vutienhieu', '$2y$10$YUxRn9LNPWjKPOvfkYMyI.zdczW1IeSfs3HPfuV4lOJayz8R4rCFO', 'none.png', 'vutienhieu91100@gmail.com', 0),
(36, 'vutinhiu', '$2y$10$sVDMIsiUVT5QcCOEcsXHQOYlDg9n6.4AFydYt4Nvf8uq8nJrOcCj2', 'none.png', '123@gmail.com', 0),
(37, 'nguyenvana', '$2y$10$qDPIdVIO2C/KgHP.HSiu3OkGDW8IHs9hT9TIim0bduL.pPhlsFfMW', 'none.png', 'nguyenvana@gmail.com', 0),
(38, 'nguyenvanb', '$2y$10$u8RyAd0UfE1C9jObfmb6LuMxzUjinKsuqQlhGSFHXX.CxvE.L3Z7S', 'none.png', 'nguyenvanb@gmail.com', 1),
(39, 'nguyenvanc', '$2y$10$/9.SE1dod1fr/SR3uNh8S.may7PnEdJ/9/bmFHNb3FrVxMektnJNa', 'none.png', 'nguyenvanc@gmail.com', 0),
(40, 'nguyenvand', '$2y$10$MVh9H0OM0TB6MkMKft/3c.MaE5Xe9xqV2m6d9yHNJ1oAkJG1ATKcO', 'none.png', 'nguyenvand@gmail.com', 0),
(41, 'nguyevane', '$2y$10$zolL3YBF0GWgkv3rqHww9OTeCCVN9FxoclsH2rn6peKe9v5HVIuFu', 'none.png', 'nguyenvane@gmail.com', 0),
(42, 'nguyenvan', '$2y$10$ghK1a/pHcMav28S6iKFhnujx9x5jBnS1vAp/h.heitg7bg.YT9hKa', 'none.png', 'nguyenvan@gmail.com', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users_detail`
--

CREATE TABLE `users_detail` (
  `userdt_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_add` varchar(255) NOT NULL,
  `fullname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `users_detail`
--

INSERT INTO `users_detail` (`userdt_id`, `user_id`, `user_phone`, `user_add`, `fullname`) VALUES
(23, 24, '0368414131', '175 Tây sơn đống đa - Hà nội', 'Hiệu Vũ'),
(30, 31, '', '', ''),
(31, 32, '', '', ''),
(32, 33, '', '', ''),
(33, 34, '', '', ''),
(34, 35, '', '', ''),
(35, 36, '', '', ''),
(36, 37, '012345679', 'Hà nội', 'Nguyễn Văn A'),
(37, 38, '', '', ''),
(38, 39, '', '', ''),
(39, 40, '', '', ''),
(40, 41, '', '', ''),
(41, 42, '123456', 'ad', 'das');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cate_id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`cmt_id`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`);

--
-- Chỉ mục cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`orderdt_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pro_id`);

--
-- Chỉ mục cho bảng `products_detail`
--
ALTER TABLE `products_detail`
  ADD PRIMARY KEY (`prodt_id`);

--
-- Chỉ mục cho bảng `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`slide_id`);

--
-- Chỉ mục cho bảng `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`theme_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Chỉ mục cho bảng `users_detail`
--
ALTER TABLE `users_detail`
  ADD PRIMARY KEY (`userdt_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `cate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `cmt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT cho bảng `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `orderdt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT cho bảng `products_detail`
--
ALTER TABLE `products_detail`
  MODIFY `prodt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT cho bảng `slides`
--
ALTER TABLE `slides`
  MODIFY `slide_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `theme`
--
ALTER TABLE `theme`
  MODIFY `theme_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT cho bảng `users_detail`
--
ALTER TABLE `users_detail`
  MODIFY `userdt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
