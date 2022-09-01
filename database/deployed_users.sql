-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 01, 2022 at 06:05 PM
-- Server version: 8.0.30-0ubuntu0.22.04.1
-- PHP Version: 8.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pbmisdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middlename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ext` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `approver_id` bigint UNSIGNED DEFAULT NULL,
  `pos_id` bigint UNSIGNED DEFAULT NULL,
  `divsec_id` bigint UNSIGNED DEFAULT NULL,
  `serreg_id` bigint UNSIGNED DEFAULT NULL,
  `current_team_id` bigint UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `ext`, `gender`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `status`, `approver_id`, `pos_id`, `divsec_id`, `serreg_id`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Telmo ', '', 'Solutions', NULL, NULL, 'dev@telmosolutions.com', '2022-08-30 00:00:00', '$2y$10$ypDl63ktbCGgrmukmfKGle7Icr1..8qUv4MyhUyFDDDlTu/y9y3pa', NULL, NULL, NULL, '1', 1, 17, 10, 21, NULL, NULL, '2022-08-30 02:25:07', '2022-09-01 09:55:31'),
(2, 'Super Admin', 'System', 'Tester', NULL, NULL, 'pbmis-test.superadmin@ocd.gov.ph', '2022-08-30 00:00:00', '$2y$10$ypDl63ktbCGgrmukmfKGle7Icr1..8qUv4MyhUyFDDDlTu/y9y3pa', NULL, NULL, NULL, '1', 1, 17, 10, 21, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(3, 'Plans Administrator', 'System', 'Tester', NULL, NULL, 'pbmis-test.plansadmin@ocd.gov.ph ', '2022-08-30 00:00:00', '$2y$10$ypDl63ktbCGgrmukmfKGle7Icr1..8qUv4MyhUyFDDDlTu/y9y3pa', NULL, NULL, NULL, '1', 1, 17, 10, 21, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(4, 'Budget Admin', 'System', 'Tester', NULL, NULL, 'pbmis-test.budgetadmin@ocd.gov.ph ', '2022-08-30 00:00:00', '$2y$10$ypDl63ktbCGgrmukmfKGle7Icr1..8qUv4MyhUyFDDDlTu/y9y3pa', NULL, NULL, NULL, '1', 1, 17, 10, 21, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(5, 'Procurement Admin', 'System', 'Tester', NULL, NULL, 'pbmis-test.procurement@ocd.gov.ph ', '2022-08-30 00:00:00', '$2y$10$ypDl63ktbCGgrmukmfKGle7Icr1..8qUv4MyhUyFDDDlTu/y9y3pa', NULL, NULL, NULL, '1', 1, 17, 10, 21, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(6, 'Technical Working Group', 'System', 'Tester', NULL, NULL, 'pbmis-test.twg@ocd.gov.ph ', '2022-08-30 00:00:00', '$2y$10$ypDl63ktbCGgrmukmfKGle7Icr1..8qUv4MyhUyFDDDlTu/y9y3pa', NULL, NULL, NULL, '1', 1, 17, 10, 21, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(7, 'Planning Focal', 'System', 'Tester', NULL, NULL, 'pbmis-test.pfo@ocd.gov.ph ', '2022-08-30 00:00:00', '$2y$10$ypDl63ktbCGgrmukmfKGle7Icr1..8qUv4MyhUyFDDDlTu/y9y3pa', NULL, NULL, NULL, '1', 1, 17, 10, 21, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(8, 'Encoder', 'System', 'Tester', NULL, NULL, 'pbmis-test.encoder@ocd.gov.ph ', '2022-08-30 00:00:00', '$2y$10$ypDl63ktbCGgrmukmfKGle7Icr1..8qUv4MyhUyFDDDlTu/y9y3pa', NULL, NULL, NULL, '1', 1, 17, 10, 21, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(9, 'Paolo Jonas', NULL, 'Alan', NULL, NULL, 'paolojonasalan@ocd.gov.ph', '2022-08-30 02:25:07', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 1, 1, 1, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(10, 'Janine', 'Tomines', 'Casimiro', NULL, NULL, 'janinetcasimiro@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 4, 8, 19, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(11, 'Karen Marie', 'Ondin', 'Valdehueza', NULL, NULL, 'karenvaldehueza321@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 6, 8, 19, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(12, 'Gia Mae', 'Realis', 'Resaba', NULL, NULL, 'giamaeresaba@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 13, 22, 22, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(13, 'Emanuel', 'Turao', 'Balajadia', NULL, NULL, 'eman.balajadia@ocd.gov.ph', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 14, 22, 22, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(14, 'James', 'Balverde', 'Dimalanta', NULL, NULL, 'dota2jamesdimalanta@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 4, 19, 22, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(15, 'Julius Ismael', 'N/A', 'Deza', NULL, NULL, 'julius.deza@ocd.gov.ph', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 17, 10, 21, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(16, 'Karen Kaye', 'Gargantiel', 'Caballero', NULL, NULL, 'karenkaye.caballero@ocd.gov.ph', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 14, 23, 21, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(17, 'Wilmina', 'Ancheta', 'Cabrera', NULL, NULL, 'cabrera.wilmina@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 25, 11, 24, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(18, 'Romina ', 'Baldonado', 'Marasigan', NULL, NULL, 'ocda.ocd@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 23, 14, 24, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(19, 'Myrabeth', 'Escobar', 'Alicias', NULL, NULL, 'mealicias@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 14, 15, 20, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(20, 'Jamelah', '', 'Josr', NULL, NULL, 'jamelahkayjose@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 25, 14, 24, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(21, 'Al-Emran', 'Arakan', 'Asani', NULL, NULL, 'alemran.asani@ocd.gov.ph', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 13, 1, 10, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(22, 'David Ison ', 'Lorenzo', 'Edmalin', NULL, NULL, 'david.edmalin@ocd.gov.ph', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 12, 1, 21, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(23, 'Ricardo', 'Suyat', 'Mago', NULL, NULL, 'magojr.jhun@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 25, 14, 24, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(24, 'Michael', 'Maido', 'Losbañes', NULL, NULL, 'michael.losbanes@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 4, 19, 19, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(25, 'Verna', 'Cavan', 'Viejo', NULL, NULL, 'viejoverna@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 3, 9, 19, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(26, 'Melly Joy ', 'Falculan ', 'Fajilagmago ', NULL, NULL, 'mellyjoy.fajilagmago@ocd.gov.ph', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 13, 3, 5, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(27, 'Rachelle Grace', 'De Guzman', 'Cacas', NULL, NULL, 'cordillerapdpsocd@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 13, 18, 17, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(28, 'Ferdinand ', 'Alamo', 'Tamulto', NULL, NULL, 'tamulto.f0504@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 14, 18, 17, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(29, 'Julleah Sheena', '', 'Narag', NULL, NULL, 'sheenanarag20@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 25, 18, 18, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(30, 'Sheila', 'Marginado', 'Hallig', NULL, NULL, 's.marginado@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 14, 18, 13, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(31, 'Ronald', 'Libron', 'Villa', NULL, NULL, 'NorAlliv@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 14, 16, 2, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(32, 'Phoenicia Achaia', 'Sungahid', 'Dela Merced', NULL, NULL, ' phoenicia.delamerced@ocd.gov.ph', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 13, 5, 23, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(33, 'Julius', 'B.', 'Hontiveros', NULL, NULL, 'julshontiveros03@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 14, 5, 23, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(34, 'Michelle', 'A', 'Mabbagu', NULL, NULL, 'michelle.mabbagu@ocd.gov.ph', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 22, 17, 24, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(35, 'Andrea Louise', 'Chua', 'Seguin', NULL, NULL, 'a.louiseguin@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 25, 12, 22, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(36, 'Monique Raizza', 'Panela', 'Jacob', NULL, NULL, 'moniqueraizza.jacob@ocd.gov.ph', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 13, 6, 22, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(37, 'Ria Danielle', 'Ferrer', 'Madrideo', NULL, NULL, 'riamadrideo98@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 25, 25, 22, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(38, 'Mary Anne', 'Magnaye', 'Bambico', NULL, NULL, 'mbambico88@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 25, 11, 24, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(39, 'Domingo', 'L', 'Leoncio', NULL, NULL, 'domsleoncio.ocdcbts@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 26, 4, 20, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(40, 'Jerone', 'Vigilia', 'Cayabyab', NULL, NULL, 'cayabyabjerone7@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 12, 1, 21, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(41, 'Denise Anne', '', 'Untalan', NULL, NULL, 'dennuntalanxx@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 1, 8, 19, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(42, 'Mary May', 'S', 'Baclig', NULL, NULL, 'mmsolivabaclig@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 14, 18, 2, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(43, 'Marc Rembrandt', 'Prado', 'Victore', NULL, NULL, 'marc_victore@yahoo.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 10, 22, 5, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(44, 'Richard', 'Castillo', 'Santos', NULL, NULL, 'richard.santos@ocd.gov.ph', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 14, 18, 3, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(45, 'April Rose Anne ', 'Sanchez', 'Elmedulan', NULL, NULL, 'aprilroseannesanchez060713@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 25, 18, 14, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(46, 'Louis Jonas', 'Mata', 'Lauraya', NULL, NULL, 'lauraya.ocsppmo@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 8, 18, 6, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(47, 'Janice', 'Montes', 'Padagdag', NULL, NULL, 'janice.padagdag0820@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 13, 18, 8, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(48, 'Paolo Jesus', 'Morris', 'Roxas', NULL, NULL, 'paolojesus.roxas@ocd.gov.ph', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 12, 18, 18, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(49, 'Empress ', 'Jaramillo', 'Nacor', NULL, NULL, 'empress.nacor@ocd.gov.ph', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 19, 18, 1, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(50, 'Juvy Grace', 'De Belen', 'Abarquez', NULL, NULL, 'juvygrace.abarquez@ocd.gov.ph', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 21, 21, 4, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(51, 'Morris Jan', 'Daco', 'Auxillos', NULL, NULL, 'Auxillos010193@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 12, 18, 3, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(52, 'Raymond', 'Cao', 'Garcia', NULL, NULL, 'raymondemiliegarcia@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 21, 18, 3, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(53, 'Kelvin John', 'Hipolito', 'Reyes', NULL, NULL, 'kelvinjohnreyespogi@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 8, 21, 4, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(54, 'Diane', 'Man-On', 'Truz', NULL, NULL, 'ocd7acctg@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 11, 3, 8, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(55, 'Romeo ', 'Basilio', 'Lucas', NULL, NULL, 'ocd2.finance@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 12, 3, 2, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(56, 'Lory Jean', '', 'Franco', NULL, NULL, 'ljcfranco@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 24, 3, 15, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(57, 'Estella Marie', 'Salta', 'Mallari', NULL, NULL, 'financeocd3@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 9, 3, 3, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(58, 'Christian Karl', 'Tactac', 'Ibañez', NULL, NULL, 'ibanezkarl000@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 25, 18, 2, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(59, 'Alexa Mae ', 'Segovia', 'San Esteban', NULL, NULL, 'alexamae1202@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 20, 16, 3, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(60, 'Mark Joseph', 'Ordoña', 'Bañaga', NULL, NULL, 'mjban21@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 25, 7, 13, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(61, 'Jonalyn', 'Lego', 'Rombo', NULL, NULL, 'jonalynrombo@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 3, 3, 9, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(62, 'Bernadette', 'Gapasin', 'Abubo', NULL, NULL, 'abubobadet@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 13, 2, 1, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(63, 'Brainard', '', 'Carballo', NULL, NULL, 'brainardcarballo@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 18, 7, 13, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(64, 'Ruth', 'Manarang', 'Bengco', NULL, NULL, 'rmbengco@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 2, 2, 3, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(65, 'Aizy Lyn', 'Paglinawan', 'Joloyohoy', NULL, NULL, 'aizyjoloyohoy@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 6, 7, 14, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(66, 'Angie Lina', 'Payosalan', 'Dela Cruz', NULL, NULL, 'anjpayosalan@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 19, 7, 12, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(67, 'Toni Gail', 'Nobleza', 'Jariolne', NULL, NULL, 'ocd10rrms@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 12, 7, 11, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(68, 'Melly Joy', 'Falculan', 'Fajilagmago', NULL, NULL, 'mellyjoyfajilagmago@ocd.gov.ph', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 13, 2, 5, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(69, 'Bai April', 'Cang', 'Sinsuat', NULL, NULL, 'asinsuat13@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 12, 7, 13, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(70, 'Janilyn Astrid', 'Tiaga', 'Bartolome', NULL, NULL, 'janilynbartolome@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 14, 7, 13, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(71, 'Marlyn', 'Ogaa', 'Trozo', NULL, NULL, 'ocdnorminos@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 16, 7, 11, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(72, 'Menchie', 'Gonzales', 'Ganzon', NULL, NULL, 'mgganzon@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 6, 7, 4, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(73, 'Ma. Criselda', 'Galvez', 'Abrajano-Gonzales', NULL, NULL, 'macriselda.abrajano@ocd.gov.ph', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 13, 7, 1, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(74, 'Kristian', 'Aguila', 'Tabisaura', NULL, NULL, 'kristian.tabisaura@ocd.gov.ph', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 14, 7, 1, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(75, 'Francesca', 'Tarenio', 'Quizon', NULL, NULL, 'ocd3.cbts@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 19, 7, 3, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(76, 'Roda', 'Simbillo', 'Dizon', NULL, NULL, 'r3.rdrrmc.ocd@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 13, 7, 3, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(77, 'Juvy Grace', 'de Belen', 'Abarquez', NULL, NULL, 'jvygrcbrqz@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 21, 7, 4, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(78, 'Romeo', 'Basilio', 'Lucas', NULL, NULL, 'rlucasjr21@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 12, 2, 2, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(79, 'Trestan Rey', 'Adarne', 'Ebare', NULL, NULL, 'cbtsrox@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 14, 7, 11, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(80, 'Marvin', 'Dioso', 'Samson', NULL, NULL, 'marvin.samson@ocd.gov.ph', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 14, 7, 12, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(81, 'Marie Lynn', '', 'Tadle', NULL, NULL, 'marielynntadle@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 13, 7, 14, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(82, 'Neko', 'Parano', 'Tupaz', NULL, NULL, 'neko20141tupaz@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 25, 7, 9, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(83, 'Ray Francis', 'Bacarisas', 'Alingasa', NULL, NULL, 'rayfrancisalingasa2@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 2, 7, 14, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(84, 'Fren Elias', 'De Veyra', 'Malinao', NULL, NULL, 'frenelias@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 25, 7, 14, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(85, 'Eirene', 'Mahusay', 'Canlom', NULL, NULL, 'aiaimahusay@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 13, 7, 12, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(86, 'Alicia Marie', 'Espinosa', 'Galito', NULL, NULL, 'ocd10finance@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 12, 2, 11, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(87, 'Judy Mae', 'Moreno', 'Adalin', NULL, NULL, 'brinx.adalin0728@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 5, 7, 2, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(88, 'Clyde Jewel', 'Cabiago', 'Solis', NULL, NULL, 'solisclyde14@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 17, 7, 5, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(89, 'Gieneva', 'Cruz', 'Ginez', NULL, NULL, 'ginnikolai@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 3, 2, 1, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(90, 'Adrian Mishael', 'Arancon', 'Morallas', NULL, NULL, 'amgmorallas@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 14, 7, 13, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(91, 'Franz', 'Navaja', 'Irag', NULL, NULL, 'franz.irag@ocd.gov.ph', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 16, 2, 12, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07'),
(92, 'Jayvee', 'Trillo', 'Gustilo', NULL, NULL, 'cbts.ocdcaraga@gmail.com', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 17, 7, 14, NULL, NULL, '2022-08-30 02:25:07', '2022-09-01 09:50:28'),
(93, 'Elvis', 'Dela Raga', 'Quitalig', NULL, NULL, 'elvis.quitalig@ocd.gov.ph', '2022-08-30 00:00:00', '$2y$10$3a9BXEnyd3h8QCV2qV2MFOHa/43UZvPt2kuBkGI.PshjwdAuIOgpS', NULL, NULL, NULL, '1', 1, 14, 7, 1, NULL, NULL, '2022-08-30 02:25:07', '2022-08-30 02:25:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_approver_id_foreign` (`approver_id`),
  ADD KEY `users_pos_id_foreign` (`pos_id`),
  ADD KEY `users_divsec_id_foreign` (`divsec_id`),
  ADD KEY `users_serreg_id_foreign` (`serreg_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_approver_id_foreign` FOREIGN KEY (`approver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_divsec_id_foreign` FOREIGN KEY (`divsec_id`) REFERENCES `division_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_pos_id_foreign` FOREIGN KEY (`pos_id`) REFERENCES `positions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_serreg_id_foreign` FOREIGN KEY (`serreg_id`) REFERENCES `service_regions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
