-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 08, 2018 lúc 05:37 AM
-- Phiên bản máy phục vụ: 10.1.31-MariaDB
-- Phiên bản PHP: 5.6.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `autoreup`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `channel`
--

CREATE TABLE `channel` (
  `pk_channel_id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `c_name` varchar(500) NOT NULL,
  `ghichu` varchar(500) DEFAULT NULL,
  `c_link` varchar(500) NOT NULL,
  `c_sub` varchar(500) NOT NULL,
  `c_view` varchar(500) NOT NULL,
  `c_subtang` int(11) NOT NULL DEFAULT '0',
  `c_viewtang` int(11) NOT NULL DEFAULT '0',
  `c_publish` varchar(500) NOT NULL,
  `c_tongvideo` varchar(500) NOT NULL,
  `c_date` varchar(500) NOT NULL,
  `c_time` varchar(500) NOT NULL,
  `c_time1` int(15) NOT NULL DEFAULT '0',
  `date` varchar(500) NOT NULL DEFAULT '0',
  `die` int(11) NOT NULL DEFAULT '0',
  `die_do` varchar(5000) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `info`
--

CREATE TABLE `info` (
  `pk_info_id` int(11) NOT NULL,
  `fk_users_id` int(11) NOT NULL,
  `ngaykichhoat` varchar(500) NOT NULL,
  `time` int(20) NOT NULL DEFAULT '0',
  `goi` int(11) NOT NULL,
  `api` varchar(500) NOT NULL,
  `clientID` varchar(500) NOT NULL,
  `clientSecret` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `info`
--

INSERT INTO `info` (`pk_info_id`, `fk_users_id`, `ngaykichhoat`, `time`, `goi`, `api`, `clientID`, `clientSecret`) VALUES
(1, 1, '08:48 2018/08/07', 1533606523, 90, 'AIzaSyCp-0c7LK32uSSjRKTKlEEEYrGCTx2Kk2o', '76613693806-a825vdh5pmrmhk4556pbjl6tk6b3jie8.apps.googleusercontent.com', 'LH2dztu9fKweCbaXSKP4gr4k');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reupchannel`
--

CREATE TABLE `reupchannel` (
  `pk_reupchannel_id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `link` varchar(500) NOT NULL,
  `linkreup` varchar(500) NOT NULL,
  `name` text NOT NULL,
  `img` varchar(500) NOT NULL DEFAULT '0',
  `publish` varchar(500) NOT NULL,
  `log` varchar(500) NOT NULL,
  `clientID` varchar(500) NOT NULL DEFAULT '0',
  `clientSecret` varchar(500) NOT NULL DEFAULT '0',
  `auto` int(11) NOT NULL DEFAULT '0',
  `tieude` text NOT NULL,
  `mota` text NOT NULL,
  `tag` text NOT NULL,
  `mota_type` int(11) NOT NULL DEFAULT '0',
  `tieude_type` int(11) NOT NULL DEFAULT '0',
  `tag_type` int(11) NOT NULL DEFAULT '0',
  `ghichu` text NOT NULL,
  `catdau` int(11) NOT NULL DEFAULT '5',
  `catduoi` int(11) NOT NULL DEFAULT '5',
  `gian` int(11) NOT NULL DEFAULT '5',
  `lap` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `die` int(11) NOT NULL DEFAULT '0',
  `running` int(11) NOT NULL DEFAULT '0',
  `loi` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reupchanneltd`
--

CREATE TABLE `reupchanneltd` (
  `pk_reupchanneltd_id` int(11) NOT NULL,
  `fk_reupchannel_id` int(11) NOT NULL,
  `link` varchar(500) NOT NULL,
  `die` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reupvideo`
--

CREATE TABLE `reupvideo` (
  `pk_reupvideo_id` int(11) NOT NULL,
  `fk_reupchannel_id` int(11) NOT NULL,
  `link` varchar(500) NOT NULL,
  `linkreup` varchar(500) NOT NULL,
  `name` varchar(2000) NOT NULL,
  `img` varchar(500) NOT NULL,
  `view` varchar(500) NOT NULL,
  `duration` varchar(500) NOT NULL,
  `description` text NOT NULL,
  `tag` text NOT NULL,
  `status` varchar(500) NOT NULL DEFAULT '1',
  `run` int(11) NOT NULL DEFAULT '0',
  `trangthai` int(11) NOT NULL DEFAULT '0',
  `trangthai1` int(11) NOT NULL DEFAULT '0',
  `sua` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `sau` int(11) NOT NULL DEFAULT '0',
  `die` int(11) NOT NULL DEFAULT '0',
  `do` varchar(500) NOT NULL,
  `running` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_key`
--

CREATE TABLE `tbl_key` (
  `pk_key_id` int(11) NOT NULL,
  `c_key` varchar(500) NOT NULL,
  `c_time` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `tbl_key`
--

INSERT INTO `tbl_key` (`pk_key_id`, `c_key`, `c_time`) VALUES
(1, 'test view', '09:13 2018/08/07'),
(2, 'test view', '09:15 2018/08/07'),
(3, 'test view', '09:27 2018/08/07'),
(4, 'test view', '09:29 2018/08/07'),
(5, 'test view', '09:34 2018/08/07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_video`
--

CREATE TABLE `tbl_video` (
  `pk_video_id` int(11) NOT NULL,
  `fk_video_id` int(11) NOT NULL,
  `c_img` varchar(500) NOT NULL,
  `c_name` varchar(2000) NOT NULL,
  `c_view` varchar(500) NOT NULL,
  `c_viewtang` int(15) NOT NULL DEFAULT '0',
  `c_link` varchar(500) NOT NULL,
  `c_publish` varchar(500) NOT NULL,
  `c_die` varchar(500) NOT NULL,
  `die_do` varchar(5000) NOT NULL DEFAULT '0',
  `c_song` varchar(500) NOT NULL,
  `c_died` int(11) NOT NULL,
  `c_time` varchar(500) NOT NULL,
  `c_time1` int(15) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `reup` int(11) NOT NULL DEFAULT '0',
  `kenhreup` int(11) NOT NULL DEFAULT '10',
  `sl` int(11) NOT NULL DEFAULT '50',
  `sl_sub` int(11) NOT NULL DEFAULT '0',
  `sl_kenhrac` int(11) NOT NULL DEFAULT '20'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `status`, `reup`, `kenhreup`, `sl`, `sl_sub`, `sl_kenhrac`) VALUES
(1, 'test', 'test@gmail.com', '$2y$10$Ie6QlSQakI9s1zgX77WutOUjL8xBl4oOqdEdG1SzciJsAGDfs5e22', NULL, '2018-04-01 00:15:35', '2018-04-01 00:15:35', 1, 1, 11, 50, 0, 20);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `channel`
--
ALTER TABLE `channel`
  ADD PRIMARY KEY (`pk_channel_id`);

--
-- Chỉ mục cho bảng `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`pk_info_id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reupchannel`
--
ALTER TABLE `reupchannel`
  ADD PRIMARY KEY (`pk_reupchannel_id`);

--
-- Chỉ mục cho bảng `reupchanneltd`
--
ALTER TABLE `reupchanneltd`
  ADD PRIMARY KEY (`pk_reupchanneltd_id`);

--
-- Chỉ mục cho bảng `reupvideo`
--
ALTER TABLE `reupvideo`
  ADD PRIMARY KEY (`pk_reupvideo_id`);

--
-- Chỉ mục cho bảng `tbl_key`
--
ALTER TABLE `tbl_key`
  ADD PRIMARY KEY (`pk_key_id`);

--
-- Chỉ mục cho bảng `tbl_video`
--
ALTER TABLE `tbl_video`
  ADD PRIMARY KEY (`pk_video_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `channel`
--
ALTER TABLE `channel`
  MODIFY `pk_channel_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `info`
--
ALTER TABLE `info`
  MODIFY `pk_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reupchannel`
--
ALTER TABLE `reupchannel`
  MODIFY `pk_reupchannel_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reupchanneltd`
--
ALTER TABLE `reupchanneltd`
  MODIFY `pk_reupchanneltd_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reupvideo`
--
ALTER TABLE `reupvideo`
  MODIFY `pk_reupvideo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_key`
--
ALTER TABLE `tbl_key`
  MODIFY `pk_key_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `tbl_video`
--
ALTER TABLE `tbl_video`
  MODIFY `pk_video_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
