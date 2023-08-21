-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 12, 2023 at 12:08 PM
-- Server version: 5.7.40
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chalet_app`
--

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `first_name`, `last_name`, `username`, `account_picture`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Abdallah', 'Aziz', 'abdallahaziz2001', 'Abdallah_Aziz.jpg', '$2y$10$t.XvYRsVxmpjWP/szSNgHetUaTJV0HGCWrGZYi.X6/Mz5UKkWyixK', NULL, '2023-08-11 16:24:50', '2023-08-11 16:24:50'),
(2, 'Yousef', 'Ammar', 'yousefammar2001', 'Yousef_Ammar.jpg', '$2y$10$F4LuTDqZKzsX0/1bioz5kewIUOuFi3kuhxTyehqJRtRv3.B9POqZW', NULL, '2023-08-11 16:24:50', '2023-08-11 16:24:50'),
(3, 'Anas', 'Al-Derfil', 'anasalderfil2001', 'Anas_AlDerfil.jpg', '$2y$10$MvudUlaRtFEF3OrDzNKdMuUx6.evOTzM2aaGOoJDpHKznkAITxlVO', NULL, '2023-08-11 16:24:50', '2023-08-11 16:24:50'),
(4, 'Ahmed', 'Al-Sakani', 'ahmedalsakni2001', 'Ahmed_AlSakani.jpg', '$2y$10$1gpBT7lAM50xt2.JMLW2Q.3yXxXZjWxQzPen4iWD/msScJKJGv6e.', NULL, '2023-08-11 16:24:50', '2023-08-11 16:24:50');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
