-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2025 at 05:35 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ga2`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auth_groups`
--

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Site Administrator'),
(2, 'user', 'Regular User');

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_permissions`
--

CREATE TABLE `auth_groups_permissions` (
  `group_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `group_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'asrofibinsarwoto@gmail.com', 1, '2024-12-04 10:27:47', 1),
(2, '::1', 'coba@gmail.com', 2, '2024-12-06 03:56:31', 1),
(3, '::1', 'coba@gmail.com', 2, '2024-12-06 12:38:45', 1),
(4, '::1', 'coba@gmail.com', 2, '2024-12-06 16:09:56', 1),
(5, '::1', 'coba@gmail.com', 2, '2024-12-06 16:34:38', 1),
(6, '::1', 'coba@gmail.com', 2, '2024-12-07 00:53:08', 1),
(7, '::1', 'coba@gmail.com', 2, '2024-12-07 06:29:15', 1),
(8, '::1', 'coba@gmail.com', 2, '2024-12-08 01:22:09', 1),
(9, '::1', 'coba@gmail.com', 2, '2024-12-12 03:55:03', 1),
(10, '::1', 'coba@gmail.com', 2, '2024-12-12 12:58:02', 1),
(11, '::1', 'coba@gmail.com', 2, '2024-12-13 04:13:43', 1),
(12, '::1', 'coba@gmail.com', 2, '2024-12-13 09:49:54', 1),
(13, '::1', 'coba@gmail.com', 2, '2024-12-13 18:20:15', 1),
(14, '::1', 'coba@gmail.com', NULL, '2024-12-14 17:13:13', 0),
(15, '::1', 'coba@gmail.com', 2, '2024-12-14 17:13:24', 1),
(16, '::1', 'coba@gmail.com', 2, '2024-12-15 17:00:12', 1),
(17, '::1', 'coba@gmail.com', 2, '2024-12-16 07:24:50', 1),
(18, '::1', 'coba@gmail.com', 2, '2024-12-16 12:11:40', 1),
(19, '::1', 'coba@gmail.com', 2, '2024-12-16 16:15:48', 1),
(20, '::1', 'coba@gmail.com', 2, '2024-12-17 05:36:23', 1),
(21, '::1', 'coba@gmail.com', NULL, '2024-12-18 06:55:39', 0),
(22, '::1', 'coba@gmail.com', 2, '2024-12-18 06:55:46', 1),
(23, '::1', 'coba@gmail.com', 2, '2024-12-19 12:13:39', 1),
(24, '::1', 'coba@gmail.com', 2, '2024-12-20 17:54:56', 1),
(25, '::1', 'coba@gmail.com', 2, '2024-12-21 07:40:48', 1),
(26, '::1', 'coba@gmail.com', 2, '2024-12-21 18:04:58', 1),
(27, '::1', 'coba@gmail.com', 2, '2024-12-22 16:45:28', 1),
(28, '::1', 'coba@gmail.com', 2, '2024-12-22 18:25:58', 1),
(29, '::1', 'coba@gmail.com', 2, '2024-12-22 18:33:42', 1),
(30, '::1', 'coba@gmail.com', 2, '2024-12-22 18:35:09', 1),
(31, '::1', 'coba@gmail.com', 2, '2024-12-23 04:22:11', 1),
(32, '::1', 'coba@gmail.com', 2, '2024-12-24 04:09:58', 1),
(33, '::1', 'coba@gmail.com', 2, '2024-12-27 19:10:28', 1),
(34, '::1', 'coba@gmail.com', 2, '2024-12-28 02:44:51', 1),
(35, '::1', 'coba@gmail.com', NULL, '2024-12-29 05:10:57', 0),
(36, '::1', 'coba@gmail.com', 2, '2024-12-29 05:11:05', 1),
(37, '::1', 'admin', NULL, '2024-12-29 08:43:02', 0),
(38, '::1', 'Asrofi', NULL, '2024-12-29 08:43:27', 0),
(39, '::1', 'asrofibinsarwoto@gmail.com', NULL, '2024-12-29 08:46:09', 0),
(40, '::1', 'asrofi', NULL, '2024-12-29 08:55:59', 0),
(41, '::1', 'xxx', NULL, '2024-12-29 09:00:07', 0),
(42, '::1', 'asrofibinsarwoto@gmail.com', 1, '2024-12-29 09:18:56', 1),
(43, '::1', 'asrofibinsarwoto@gmail.com', 1, '2024-12-29 13:57:39', 1),
(44, '::1', 'asrofibinsarwoto@gmail.com', 1, '2024-12-29 16:08:47', 1),
(45, '::1', 'asrofibinsarwoto@gmail.com', 1, '2024-12-30 02:34:52', 1),
(46, '::1', 'asrofibinsarwoto@gmail.com', 1, '2024-12-30 09:37:21', 1),
(47, '::1', 'asrofibinsarwoto@gmail.com', 1, '2024-12-30 17:06:17', 1),
(48, '::1', 'asrofibinsarwoto@gmail.com', 1, '2025-01-01 10:55:15', 1),
(0, '::1', 'coba@gmail.com', NULL, '2025-01-14 17:26:01', 0),
(0, '::1', 'coba@gmail.com', NULL, '2025-01-14 17:26:09', 0),
(0, '::1', 'coba@gmail.com', 1, '2025-01-14 17:26:59', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-15 02:51:30', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-15 09:27:55', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-15 16:04:59', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-16 15:35:27', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-16 16:34:17', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-16 16:38:31', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-16 17:17:35', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-16 17:21:12', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-16 18:49:17', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-17 16:19:14', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-18 15:17:00', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-19 14:07:25', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-20 02:19:57', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-20 02:36:42', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-20 03:09:31', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-20 03:23:23', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-20 03:27:31', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-20 04:08:23', 1),
(0, '::1', 'coba@gmail.com', NULL, '2025-01-20 04:19:41', 0),
(0, '::1', 'coba@gmail.com', 1, '2025-01-20 04:19:48', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-20 04:37:22', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-20 06:13:37', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-20 06:32:39', 1),
(0, '::1', 'coba@gmail.com', 1, '2025-01-21 04:46:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions`
--

CREATE TABLE `auth_permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auth_permissions`
--

INSERT INTO `auth_permissions` (`id`, `name`, `description`) VALUES
(1, 'manage-users', 'Manage all users'),
(2, 'manage-profile', 'Manage user\'s profile');

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `auth_users_permissions`
--

CREATE TABLE `auth_users_permissions` (
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id` int(2) NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `telp` varchar(50) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `status_dosen` int(3) NOT NULL,
  `id_dosen` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id`, `nip`, `nama`, `alamat`, `telp`, `password`, `status_dosen`, `id_dosen`) VALUES
(85, '123', 'A. Mustaniruddin, M.Ag.', 'jambi', '098', '', 1, NULL),
(86, '', 'Abdul Walid, S.Pd., M.Pd.', '', '', '', 1, 'D42'),
(87, '', 'Ade Novia Maulana, M.Sc.', '', '', '', 1, 'D20'),
(88, '', 'Ahmad Nasukha, S.Hum., M.S.I', '', '', '', 1, 'D156'),
(89, '', 'Ahmad Sayuti Nainggolan, S.Pd., M.Pd.', '', '', '', 1, 'D163'),
(90, '', 'Ahmad Syukron Prasaja, M.Sc.', '', '', '', 1, 'D69'),
(91, '', 'Aini Qomariah Manurung, M.Si.', '', '', '', 1, 'D154'),
(92, '', 'Albet Triadi, M.Kom', '', '', '', 1, 'D06'),
(93, '', 'Andeka Widodo, MM', '', '', '', 1, 'D103'),
(94, '', 'Andreo Yudherta, M.Eng', '', '', '', 1, 'D84'),
(95, '', 'Angger Hidayat, M.Par', '', '', '', 1, 'D04'),
(96, '', 'Annisa, M.Pd', '', '', '', 1, 'D106'),
(97, '', 'Ardeni Iwan Setyawan, S.T., M.T., IAI', '', '', '', 1, 'D10'),
(98, '', 'Arman Abdul Rochman, S.Pd., M.Si.', '', '', '', 1, 'D96'),
(99, '', 'Asriyadi, M.Ag', '', '', '', 1, 'D93'),
(100, '', 'Ayu Mardalena, M.Si', '', '', '', 1, 'D137'),
(101, '', 'Badariah, S.Pd., M.Pd.', '', '', '', 1, 'D105'),
(102, '', 'Bastomi Baharsyah, M.Kom', '', '', '', 1, 'D162'),
(103, '', 'Bayu Kurniawan, M.Sc.', '', '', '', 1, 'D08'),
(104, '', 'Betri Wendra, M.Sc', '', '', '', 1, 'D122'),
(105, '', 'Burhanuddin, S.H.I., M.H', '', '', '', 1, 'D133'),
(106, '', 'Candra Purnama, M.Ag', '', '', '', 1, 'D104'),
(107, '', 'Damiri, S.Ud., M.Ag', '', '', '', 1, 'D05'),
(108, '', 'Darmadi, S.Ag., M.Ud', '', '', '', 1, 'D161'),
(109, '', 'DEFINA DWI BULAN, S.Pd.,\nM.Sc.', '', '', '', 1, 'D138'),
(110, '', 'DELLA AMRINA YUSRA,\nS.Pd., M.Pd', '', '', '', 1, 'D134'),
(111, '', 'DESI RAHMAWARNI, S.Pd.,\nM.Pd', '', '', '', 1, 'D142'),
(113, '', 'DIAH DWI SANTRI, M.Pd', '', '', '', 1, 'D14'),
(114, '', 'DIANDA ULHAQ, M.Ag ', '', '', '', 1, 'D109'),
(115, '', 'DILA NURLAILA, M.Kom', '', '', '', 1, 'D70'),
(116, '', 'DIRA MERITHA WIYAGA,\nM.Si', '', '', '', 1, 'D83'),
(117, '', 'DODI IRAWAN, M.Kom', '', '', '', 1, 'D150'),
(118, '', 'DODO TOMI, M.Pd', '', '', '', 1, 'D147'),
(119, '', 'DORI FITRIA, M.Si.', '', '', '', 1, 'D89'),
(120, '', 'Dr. DAREX SUSANTO,\nM.Kom', '', '', '', 1, 'D139'),
(121, '', 'Dr. DIANA ROZELIN,\nS.S.,M.Hum.', '', '', '', 1, 'D74'),
(122, '', 'Dr. M. HURMAINI, M.Pd.', '', '', '', 1, 'D17'),
(123, '', 'Dr. MICHRUN NISA RAMLI,\nM.PMat', '', '', '', 1, 'D148'),
(124, '', 'Dr. MINNAH EL WIDDAH,\nM.Ag', '', '', '', 1, 'D98'),
(125, '', 'Dr. TANTI, S.Si., M.Si', '', '', '', 1, 'D146'),
(126, '', 'Dr. USMAN FAHMY ,\nS.Pd.I, M.Pd.I', '', '', '', 1, 'D152'),
(127, '', 'Dr. WAHYUDI , M.Pd', '', '', '', 1, 'D153'),
(128, '', 'EFITRA , M.Kom', '', '', '', 2, 'D81'),
(145, '', 'ERWANTONI, M.Kom', '', '0823', '', 1, 'D118'),
(148, '', 'ERWIN, S.Pd, MA', '', '0823', '', 1, 'D49'),
(194, '', 'EVA GUSMIRA, S.Si., M.Si', '', '', '', 1, 'D27'),
(195, '', 'FATIMA FELAWATI, M.Kom', '', '', '', 1, 'D59'),
(196, '1234', 'FENY SAFITRI, M.Kom', '', '0823', '', 1, 'D01'),
(197, '', 'FEVI MAWADHAH PUTRI,\nS.Si., M.Si', '', '', '', 1, 'D48'),
(198, '', 'FIQI NURMANDA SARI,\nM.Pd', '', '', '', 1, 'D165'),
(199, '', 'FIRNA JUMIRA, S.Si, M.Si.', '', '', '', 1, 'D73'),
(201, '', 'GALANG ISTO\'IN CHOIRUL,\nM.Kom', '', '', '', 1, 'D03'),
(202, '', 'GHINA NABILAH EFFENDI,\nM.IP', '', '', '', 1, 'D62'),
(203, '', 'HARIYANTO, M.H', '', '', '', 1, 'D31'),
(204, '', 'HENDRA GUNAWAN,\nM.Hum', '', '', '', 1, 'D28'),
(205, '', 'HERU KURNIAWAN,\nM,Kom', '', '', '', 1, 'D120'),
(206, '', 'HERY AFRIYADI, SE.,\nS.Kom,M.Si', '', '', '', 1, 'D144'),
(208, '', 'HESTI RIANY, M.Si', '', '', '', 1, 'D86'),
(209, '', 'ICA WANDARI ANISIA,\nS.Pd., M.Pd', '', '', '', 1, 'D78'),
(210, '', 'IDRIS, S.S., M.H', '', '', '', 1, 'D157'),
(211, '', 'IMAM ROFI\'I, S.Kom,\nM.Kom', '', '', '', 1, 'D124'),
(212, '', 'INTAN NOVIARNI, M.Si.', '', '', '', 1, 'D39'),
(213, '', 'IRFAN , S.Pd.I., M.Pd', '', '', '', 1, 'D41'),
(214, '', 'KHOTIMAH MAHMUDAH,\nM.Pd', '', '', '', 1, 'D88'),
(215, '', 'KRISNA SURYANTI, S.Pd.,\nM.Si', '', '', '', 1, 'D58'),
(216, '', 'LAILA GUSRI, S.T, M.Sc', '', '', '', 1, 'D63'),
(217, '', 'LAINATUSSIFA, M.Ag', '', '', '', 1, 'D123'),
(218, '', 'LATUSI ANGGRIANI, M.Si.', '', '', '', 1, 'D132'),
(219, '', 'LAZUARDI YUDHA P,\nS.Kom., M.Kom', '', '', '', 1, 'D95'),
(220, '', 'LIDIA GUSFI MARNI, M.Si', '', '', '', 1, 'D127'),
(221, '', 'M. NUR FALEVI, M.Ag', '', '', '', 1, 'D131'),
(222, '', 'M. YUSUF, M.S.I', '', '', '', 1, 'D91'),
(223, '', 'MAIMUNAH PERMATA\nHATI HASIBUAN, S.Sos.,\nM.Si', '', '', '', 1, 'D37'),
(224, '', 'MAULANA ABDUL\nGHAFFAR, S.IP, M.Si', '', '', '', 1, 'D38'),
(225, '', 'MAWADDAH\nWARAHMAH,S.Pd,M.Pd', '', '', '', 4, 'D90'),
(226, '', 'MHD. THEO ARI BANGSA,\nM.Cs', '', '', '', 1, 'D72'),
(227, '', 'MISKI YULIANDRI, S. Sos.,\nM. I. Kom', '', '', '', 1, 'D97'),
(228, '', 'MUHAMMAD AL FARABY,\nM.P.W.K', '', '', '', 1, 'D15'),
(229, '', 'MUHAMMAD IKHSAN,\nM.Kom', '', '', '', 1, 'D135'),
(230, '', 'MURTADHA, M.Si', '', '', '', 2, 'D130'),
(231, '', 'MUSI ARIAWIJAYA,\nS.Kom.,M.S.', '', '', '', 1, 'D159'),
(232, '', 'MUSTAR, M.Pd.I ', '', '', '', 1, 'D85'),
(233, '', 'MUTAMASSIKIN, M.Kom', '', '', '', 1, 'D47'),
(234, '', 'NANDA GUSRIANI, M.Pd ', '', '', '', 1, 'D117'),
(235, '', 'NENG AYU SAADAH, M.Sos', '', '', '', 1, 'D56'),
(236, '', 'NERVIANA TRESELI\nM.Kom', '', '', '', 1, 'D102'),
(238, '2332', 'NETTI ZURNELLI, S.Pd.,\nM.Pd.', '', '0823', '', 1, 'D143'),
(239, '', 'NINDYA MAYA KARTIKA,\nM.Pd', '', '', '', 1, 'D11'),
(240, '', 'NISSA SUKMAWATI, S.Si.,\nM.S', '', '', '', 1, 'D46'),
(241, '1234', 'NOFI NURMAN, S.Pd., M.Si', '', '0823', '', 1, 'D111'),
(242, '', 'NORRA ERISHA, M. A', '', '', '', 1, 'D129'),
(243, '', 'NURFADLIYATI, M.A', '', '', '', 1, 'D64'),
(244, '', 'NURFAZZILAH,\nS.Fil.I.,M.Sos', '', '', '', 1, 'D75'),
(245, '', 'NURHASANAH, M.Ag', '', '', '', 1, 'D54'),
(246, '', 'NURMALA RUSTIANTI, M.Si', '', '', '', 1, 'D26'),
(247, '', 'POL METRA, M.Kom', '', '', '', 1, 'D110'),
(248, '', 'RADEN MUHAMMAD\nARDDIANSYAH\nKURNIAWAN. M.Hum', '', '', '', 1, 'D99'),
(249, '', 'RESDIANA SAFITHRI, M.Pd', '', '', '', 1, 'D140'),
(250, '', 'RESTU FITRIANI, M.Si', '', '', '', 1, 'D12'),
(251, '', 'REZA PAHLEPI, S.Fil.I.,\nM.Ag', '', '', '', 1, 'D87'),
(252, '', 'RICE RIONALDO, M.Kom', '', '', '', 1, 'D77'),
(253, '', 'RICO FARDIANSYAH, M.Ag', '', '', '', 1, 'D115'),
(254, '', 'RIFQI MUSTOPA,M.Hum', '', '', '', 1, 'D13'),
(255, '', 'RIKHEL SAPUTRI, M.Pd', '', '', '', 1, 'D121'),
(256, '', 'RIKO APRIANTO, M.Pd.', '', '', '', 1, 'D71'),
(257, '', 'RINI WARTI, S.Si., M.Si', '', '', '', 1, 'D02'),
(258, '', 'RISKI DWIMALIDA PUTRI,\nM.Si', '', '', '', 1, 'D18'),
(259, '', 'ROBY SETIAWAN, S.Kom,\nM.S.I', '', '', '', 1, 'D22'),
(260, '', 'SALDI YULISTIAN, M.Ars.', '', '', '', 1, 'D128'),
(261, '', 'SALMAN ALFARISI, M.Pd', '', '', '', 1, 'D101'),
(262, '', 'SATRIA FITRIO,S.T., M.T', '', '', '', 1, 'D145'),
(263, '', 'SEPRIANO, M.Kom', '', '', '', 1, 'D107'),
(264, '', 'SHINTA\nOKTAVIANI,S.T.,M.P.W.K', '', '', '', 1, 'D114'),
(265, '', 'SITI FATHUROH, M.Si', '', '', '', 1, 'D36'),
(266, '', 'SUHENDRA, S.T., M.Sc.', '', '', '', 1, 'D29'),
(268, '', 'SUROTO, S.Kom., M.Kom.', '', '', '', 1, 'D57'),
(269, '', 'SUSI MARISA, M.Si', '', '', '', 1, 'D40'),
(270, '', 'SYAMSU HADI J, S.Ag.,\nM.H', '', '', '', 1, 'D80'),
(271, '', 'SYUKRYA NINGSIH, M.Si.', '', '', '', 1, 'D68'),
(272, '', 'TIRA MARIANA, SS.,\nM.Hum', '', '', '', 1, 'D126'),
(273, '', 'TITIN AGUSTIN NENGSIH,\nM.Si', '', '', '', 1, 'D30'),
(274, '', 'TURINO ADI IRAWAN, M.Pd', '', '', '', 1, 'D79'),
(275, '', 'URWAWUSKA LADINI,\nS.Stat., M.S', '', '', '', 1, 'D82'),
(276, '', 'UTAMI MIZANI PUTRI, S.T.,\nM.Kom', '', '', '', 1, 'D53'),
(277, '', 'VANDRI AHMAD ISNAINI,\nS.Si., M.Si', '', '', '', 1, 'D155'),
(278, '', 'VINNY YULIANI SUNDARA,\nM.Si', '', '', '', 1, 'D35'),
(280, '', 'WAHYU ANGGORO, M.Kom', '', '', '', 1, 'D21'),
(281, '', 'WIDIA BELA OKTAVIANI,\nM.Biomed', '', '', '', 1, 'D61'),
(282, '', 'WIJI UTAMI, M.Sc', '', '0823', '', 1, 'D44'),
(283, '2332', 'YAYAN AGUSDI, M.Kom', '', '0823', '', 1, 'D52'),
(284, '', 'YERIX RAMADHANI,\nM.Kom', '', '', '', 1, 'D60'),
(285, '', 'YOLANDA, M.Kom', '', '', '', 1, 'D51'),
(286, '1234', 'YUDI KURNIAWAN, S.Pd.,\nM.Pd', '', '0823', '', 1, 'D76'),
(287, '', 'ZAKIYATUNNISA AL\nMUBAROQAH,M.Pd', '', '', '', 1, 'D43'),
(288, '', 'ZUBAIDAH, M.Si', '', '', '', 1, 'D92'),
(289, '', 'ZUL KARIMAN, S.Pi., M.Sc.', '', '', '', 1, 'D19');

-- --------------------------------------------------------

--
-- Table structure for table `hari`
--

CREATE TABLE `hari` (
  `id` int(10) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `id_hari` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hari`
--

INSERT INTO `hari` (`id`, `nama`, `id_hari`) VALUES
(1, 'Senin', 'H01'),
(2, 'Selasa', 'H02'),
(3, 'Rabu', 'H03'),
(4, 'Kamis', 'H04'),
(5, 'Jumat', 'H05');

-- --------------------------------------------------------

--
-- Table structure for table `jadwalkuliah`
--

CREATE TABLE `jadwalkuliah` (
  `id` int(10) NOT NULL,
  `id_pengampu` int(10) DEFAULT NULL,
  `id_jam` int(10) DEFAULT NULL,
  `id_hari` int(10) DEFAULT NULL,
  `id_ruang` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='hasil proses';

--
-- Dumping data for table `jadwalkuliah`
--

INSERT INTO `jadwalkuliah` (`id`, `id_pengampu`, `id_jam`, `id_hari`, `id_ruang`) VALUES
(1, 1361, 12, 4, 40),
(2, 1365, 3, 3, 28),
(3, 1366, 8, 1, 27),
(4, 1367, 8, 4, 27),
(5, 1368, 7, 1, 26),
(6, 1369, 1, 5, 27),
(7, 1370, 5, 2, 28),
(8, 1371, 14, 5, 26),
(9, 1372, 5, 3, 28),
(10, 1373, 6, 5, 27),
(11, 1374, 2, 2, 27),
(12, 1375, 11, 4, 40),
(13, 1376, 7, 1, 28),
(14, 1377, 2, 4, 27),
(15, 1378, 10, 1, 40),
(16, 1379, 1, 5, 28),
(17, 1380, 1, 2, 26),
(18, 1381, 12, 3, 40),
(19, 1382, 12, 2, 40),
(20, 1383, 3, 3, 27),
(21, 1384, 10, 2, 40),
(22, 1385, 2, 3, 26),
(23, 1386, 9, 1, 40),
(24, 1387, 3, 2, 27),
(25, 1388, 6, 1, 28),
(26, 1389, 8, 2, 27),
(27, 1390, 5, 1, 26),
(28, 1391, 14, 5, 27),
(29, 1392, 5, 4, 28),
(30, 1393, 8, 2, 26),
(31, 1394, 8, 1, 26),
(32, 1395, 8, 1, 28),
(33, 1396, 5, 1, 28),
(34, 1397, 11, 3, 40),
(35, 1399, 1, 3, 27),
(36, 1400, 6, 2, 28),
(37, 1402, 7, 4, 27),
(38, 1400, 7, 4, 28);

-- --------------------------------------------------------

--
-- Table structure for table `jam`
--

CREATE TABLE `jam` (
  `id` int(10) NOT NULL,
  `range_jam` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jam`
--

INSERT INTO `jam` (`id`, `range_jam`) VALUES
(1, '07.30-08.20'),
(2, '08.20-09.10'),
(3, '09.10-10.00'),
(4, '10.10-11.00'),
(5, '11.00-11.50'),
(6, '11.50-12.40'),
(7, '12.40-13.30'),
(8, '13.30-14.20'),
(9, '14.20-15.10'),
(10, '15:10-16:00'),
(11, '16.00-16.50'),
(12, '16.50-17.40');

-- --------------------------------------------------------

--
-- Table structure for table `jam2`
--

CREATE TABLE `jam2` (
  `id` int(10) NOT NULL,
  `range_jam` varchar(50) DEFAULT NULL,
  `sks` int(2) DEFAULT NULL,
  `sesi` int(2) DEFAULT NULL,
  `id_jam` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jam2`
--

INSERT INTO `jam2` (`id`, `range_jam`, `sks`, `sesi`, `id_jam`) VALUES
(1, '07.30-10.00', 3, 1, 'T11'),
(2, '10.10-12.40', 3, 2, 'T12'),
(3, '13.00-15.30', 3, 3, 'T13'),
(4, '15.30-18.00', 3, 4, 'T14'),
(5, '07.30-09.10', 2, 1, 'T05'),
(6, '10.10-11.50', 2, 2, 'T06'),
(7, '13.00-14.40', 2, 3, 'T07'),
(8, '15.30-17.10', 2, 4, 'T08'),
(9, '07.30-08.20', 1, 1, 'T01'),
(10, '10.10-11.00', 1, 2, 'T02'),
(11, '13.00-13.50', 1, 3, 'T03'),
(12, '15.30-16.20', 1, 4, 'T04'),
(13, '13.30-16.00', 3, 5, 'T15'),
(14, '13.30-15.10', 2, 5, 'T09'),
(15, '16.00-17.40', 2, 6, 'T10'),
(16, '07.30-09.10', 4, 1, 'T16'),
(17, '10.10-11.50', 4, 2, 'T17'),
(18, '13.00-14.40', 4, 3, 'T18'),
(19, '15.30-17.10', 4, 4, 'T19'),
(20, '13.30-15.10', 4, 5, 'T20'),
(21, '16.00-17.40', 4, 6, 'T21');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `nama_kelas` varchar(10) NOT NULL,
  `id_prodi` int(3) NOT NULL,
  `id_kelas` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama_kelas`, `id_prodi`, `id_kelas`) VALUES
(1, 'A', 1, 'K01'),
(2, 'B', 1, 'K02'),
(3, 'C', 1, 'K03'),
(4, 'D', 1, 'K04'),
(6, 'E', 1, 'K05'),
(7, 'F', 1, 'K06'),
(8, 'G', 1, 'K07'),
(9, 'H', 1, 'K08'),
(10, 'I', 1, 'K09'),
(11, 'J', 1, 'K10'),
(12, 'K', 1, 'K11'),
(13, 'L', 1, 'K12'),
(14, 'M', 1, 'K13');

-- --------------------------------------------------------

--
-- Table structure for table `matakuliah`
--

CREATE TABLE `matakuliah` (
  `id` int(10) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `jumlah_jam` int(6) DEFAULT NULL,
  `semester` int(2) DEFAULT NULL,
  `aktif` enum('True','False') DEFAULT 'True',
  `jenis` enum('TEORI','PRAKTIKUM') DEFAULT 'TEORI',
  `nama_id` varchar(10) DEFAULT NULL,
  `id_prodi` int(5) DEFAULT NULL,
  `ket_mk` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='example kode_mk = 0765109 ';

--
-- Dumping data for table `matakuliah`
--

INSERT INTO `matakuliah` (`id`, `nama`, `jumlah_jam`, `semester`, `aktif`, `jenis`, `nama_id`, `id_prodi`, `ket_mk`) VALUES
(498, 'Matematika Dasar', 3, 1, 'True', 'TEORI', 'FSIF61001', 1, 'Wajib Fakultas'),
(499, 'Pancasila', 2, 1, 'True', 'TEORI', 'UIN60001', 1, 'MK2'),
(500, 'Studi Hukum Islam', 2, 1, 'True', 'TEORI', 'UIN60006', 1, 'MK3'),
(501, 'Pemikiran Islam dan Filsafat', 2, 1, 'True', 'TEORI', 'UIN60007', 1, 'MK4'),
(502, 'Matematika Diskrit dan Logika', 3, 1, 'True', 'TEORI', 'SIF61001', 1, 'MK5'),
(503, 'Dasar Pemrograman', 3, 1, 'True', 'TEORI', 'SIF61002', 1, 'MK6'),
(504, 'Pengantar Ilmu Komputer', 3, 1, 'True', 'TEORI', 'FSIF61002', 1, 'MK7'),
(505, 'Jaringan dan Komunikasi Data', 3, 1, 'True', 'TEORI', 'SIF63003', 1, 'MK8'),
(506, 'Perencanaan dan Strategi Sistem Informasi', 3, 1, 'True', 'TEORI', 'SIF63002', 1, 'MK9'),
(507, 'Struktur Data dan Algoritma', 4, 1, 'True', 'TEORI', 'SIF63005', 1, 'MK10'),
(508, 'Interaksi Manusia dan Komputer', 3, 1, 'True', 'TEORI', 'SIF63001', 1, 'MK11'),
(509, 'Pemrograman Web 2', 4, 1, 'True', 'TEORI', 'SIF63004', 1, 'MK12'),
(510, 'Manajemen Resiko', 3, 1, 'True', 'TEORI', 'SIF65002', 1, 'MK13'),
(511, 'Rekayasa Perangkat Lunak', 3, 1, 'True', 'TEORI', 'SIF65003', 1, 'MK14'),
(512, 'Testing dan Implementasi System', 3, 1, 'True', 'TEORI', 'SIF65004', 1, 'MK15'),
(513, 'Pemrograman Mobile', 4, 1, 'True', 'TEORI', 'SIF65005', 1, 'MK16'),
(514, 'Multimedia', 4, 1, 'True', 'TEORI', 'SIF65006', 1, 'MK17'),
(515, 'Technopreneurship', 3, 1, 'True', 'TEORI', 'SIF65001', 1, 'MK18'),
(516, 'Costumer Relationship Management', 3, 1, 'True', 'TEORI', 'SIF6P006', 1, 'MK19'),
(517, 'Islam Peradaban Melayu', 2, 1, 'True', 'TEORI', 'USIF60008', 1, 'MK20'),
(518, 'Bahasa Inggris', 2, 1, 'True', 'TEORI', 'USIF60005', 1, 'MK21'),
(519, 'Pancasila', 2, 1, 'True', 'TEORI', 'UIN60001', 2, 'MK22'),
(520, 'Kewarganegaraan', 2, 1, 'True', 'TEORI', 'UIN60002', 2, 'MK23'),
(521, 'Gambar Arsitektur', 3, 1, 'True', 'TEORI', '70761001', 2, 'MK24'),
(522, 'Fisika Dasar', 2, 1, 'True', 'TEORI', '70761003', 2, 'MK25'),
(523, 'Sejarah Arsitektur Nusantara', 2, 1, 'True', 'TEORI', '70763004', 2, 'MK26'),
(524, 'Perencanaan Kawasan dan Wisata', 2, 1, 'True', 'TEORI', '70763007', 2, 'MK27'),
(525, 'Arsitektur Islam', 2, 1, 'True', 'TEORI', '70763008', 2, 'MK28'),
(526, 'Studio Perancangan Arsitektur 2', 5, 1, 'True', 'TEORI', '70763002', 2, 'MK29'),
(527, 'Perumahan dan Permukiman', 2, 1, 'True', 'TEORI', '70763005', 2, 'MK30'),
(528, 'Bahasa Arab', 2, 1, 'True', 'TEORI', 'UIN60008', 2, 'MK31'),
(529, 'Kalkulus Dasar', 3, 1, 'True', 'TEORI', '70661002', 3, 'MK32'),
(530, 'Matematika Dasar', 3, 1, 'True', 'TEORI', '70661001', 3, 'MK33'),
(531, 'Statistika Dasar', 2, 1, 'True', 'TEORI', '70261004', 3, 'MK34'),
(532, 'Teori Peluang', 3, 1, 'True', 'TEORI', '70663002', 3, 'MK35'),
(533, 'Analisis Regresi', 3, 1, 'True', 'TEORI', '70663003', 3, 'MK36'),
(534, 'Perancangan Percobaan', 3, 1, 'True', 'TEORI', '70663006', 3, 'MK37'),
(535, 'Statistika Sekoral', 3, 1, 'True', 'TEORI', '70663004', 3, 'MK38'),
(536, 'Teknik Pengambilan Sample', 2, 1, 'True', 'TEORI', '70663005', 3, 'MK39'),
(537, 'Islamic Entrepreneurship', 2, 1, 'True', 'TEORI', 'UIN60009', 3, 'MK40'),
(538, 'Kartografi Dasar', 2, 1, 'True', 'TEORI', '70561004', 4, 'MK41'),
(539, 'Pengantar Geografi', 2, 1, 'True', 'TEORI', '70561001', 4, 'MK42'),
(540, 'Geografi Manusia', 2, 1, 'True', 'TEORI', '70561003', 4, 'MK43'),
(541, 'Geologi Dasar', 2, 1, 'True', 'TEORI', '70561002', 4, 'MK44'),
(542, 'Global Navigation Satelit System (GNSS)', 3, 1, 'True', 'TEORI', '70563001', 4, 'MK45'),
(543, 'Pengantar Sains Informasi Geografi', 2, 1, 'True', 'TEORI', '70563003', 4, 'MK46'),
(544, 'Kartografi Tematik', 3, 1, 'True', 'TEORI', '70563004', 4, 'MK47'),
(545, 'Biogeografi', 2, 1, 'True', 'TEORI', '70563007', 4, 'MK48'),
(546, 'Hidrologi Sungai dan Danau', 3, 1, 'True', 'TEORI', '70563006', 4, 'MK49'),
(547, 'Ekologi dan Ilmu Lingkungan', 3, 1, 'True', 'TEORI', '70563002', 4, 'MK50'),
(548, 'Hidrosfer dan Atmosfer', 2, 1, 'True', 'TEORI', '70561005', 4, 'MK51'),
(549, 'Oseanografi', 2, 1, 'True', 'TEORI', '70561005', 4, 'MK52'),
(550, 'Biologi Umum', 3, 1, 'True', 'TEORI', '70461001', 5, 'MK53'),
(551, 'Sistematika Hewan', 3, 1, 'True', 'TEORI', '70463005', 5, 'MK54'),
(552, 'Praktikum Sistematika Hewan', 1, 1, 'True', 'PRAKTIKUM', '70463006', 5, NULL),
(553, 'Struktur dan Perkembangan Hewan', 3, 1, 'True', 'TEORI', '70463001', 5, 'MK56'),
(554, 'Praktikum Struktur dan Perkembangan Hewan', 1, 1, 'True', 'PRAKTIKUM', '70463002', 5, NULL),
(555, 'Genetika', 3, 1, 'True', 'TEORI', '70463009', 5, 'MK58'),
(556, 'Praktikum Genetika', 1, 1, 'True', 'PRAKTIKUM', '70463010', 5, NULL),
(557, 'Mikrobiologi', 3, 1, 'True', 'TEORI', '70463007', 5, 'MK60'),
(558, 'Praktikum Mikrobiologi', 1, 1, 'True', 'PRAKTIKUM', '70463008', 5, NULL),
(559, 'Sistematika Tumbuhan', 3, 1, 'True', 'TEORI', '70463003', 5, 'MK62'),
(560, 'Praktikum Sistematika Tumbuhan', 1, 1, 'True', 'PRAKTIKUM', '70463004', 5, NULL),
(561, 'Bahasa Indonesia', 2, 1, 'True', 'TEORI', 'UIN60003', 5, 'MK64'),
(562, 'Bahasa Inggris', 2, 1, 'True', 'TEORI', 'UIN60004', 5, 'MK65'),
(563, 'Studi Al-Qur\'an dan Hadits', 2, 1, 'True', 'TEORI', 'UIN60005', 6, 'MK66'),
(564, 'Pancasila', 2, 1, 'True', 'TEORI', 'UIN60001', 6, 'MK67'),
(565, 'Matematika Kimia', 3, 1, 'True', 'TEORI', '70161001', 6, 'MK68'),
(566, 'Kimia Dasar', 3, 1, 'True', 'TEORI', '70161003', 6, 'MK69'),
(567, 'Praktikum Kimia Dasar', 1, 1, 'True', 'PRAKTIKUM', '70161004', 6, NULL),
(568, 'Biologi Umum', 2, 1, 'True', 'TEORI', '70161005', 6, 'MK71'),
(569, 'Kimia Anorganik I', 3, 1, 'True', 'TEORI', '70163002', 6, 'MK72'),
(570, 'Kimia Analitik I', 3, 1, 'True', 'TEORI', '70163003', 6, 'MK73'),
(571, 'Praktikum Kimia Analitik I', 1, 1, 'True', 'PRAKTIKUM', '70163008', 6, NULL),
(572, 'Kimia Fisika I', 3, 1, 'True', 'TEORI', '70163005', 6, 'MK75'),
(573, 'Praktikum Kimia Fisika I', 1, 1, 'True', 'PRAKTIKUM', '70163006', 6, NULL),
(574, 'Kimia Organik I', 3, 1, 'True', 'TEORI', '70163004', 6, 'MK77'),
(575, 'Praktikum Kimia Organik I', 1, 1, 'True', 'PRAKTIKUM', '70163005', 6, NULL),
(576, 'Kimia Dalam Islam', 2, 1, 'True', 'TEORI', '70163010', 6, 'MK79'),
(577, 'Analisis Instrumen', 2, 1, 'True', 'TEORI', '70165002', 6, 'MK80'),
(578, 'Kimia Katalisis', 2, 1, 'True', 'TEORI', '70165006', 6, 'MK81'),
(579, 'Kimia Industri', 2, 1, 'True', 'TEORI', '70165009', 6, 'MK82'),
(580, 'Kimia Zat Padat', 2, 1, 'True', 'TEORI', '70165010', 6, 'MK83'),
(581, 'Analisis Dampak Lingkungan', 3, 1, 'True', 'TEORI', '70165013', 6, 'MK84'),
(582, 'Bahasa Inggris', 2, 1, 'True', 'TEORI', 'UIN60004', 6, 'MK85'),
(583, 'Fisika Dasar', 3, 1, 'True', 'TEORI', '70261001', 7, 'MK86'),
(584, 'Matematika Dasar 1', 3, 1, 'True', 'TEORI', '70261003', 7, 'MK87'),
(585, 'Pengantar Ilmu Komputer', 3, 1, 'True', 'TEORI', '70261005', 7, 'MK88'),
(586, 'Statistika Dasar', 2, 1, 'True', 'TEORI', '70261004', 7, 'MK89'),
(587, 'Fisika Modern', 3, 1, 'True', 'TEORI', '70263006', 7, 'MK90'),
(588, 'Eksperimen Fisika', 3, 1, 'True', 'TEORI', '70263004', 7, 'MK91'),
(589, 'Listrik Magnet', 3, 1, 'True', 'TEORI', '70265004', 7, 'MK92'),
(590, 'Fisika Quantum', 3, 1, 'True', 'TEORI', '70265002', 7, 'MK93'),
(591, 'Fisika Atmosfer', 3, 1, 'True', 'TEORI', '70265050', 7, 'MK94'),
(592, 'Ilmu Pengetahuan Bumi dan Antariksa', 3, 1, 'True', 'TEORI', '70265051', 7, 'MK95'),
(593, 'Gelombang dan Optik', 3, 1, 'True', 'TEORI', '70265001', 7, 'MK96'),
(594, 'Termodinamika', 3, 1, 'True', 'TEORI', '70265003', 7, 'MK97'),
(595, 'Metode Geolistrik dan Geomagnet', 2, 1, 'True', 'TEORI', '70265009', 7, 'MK98'),
(596, 'Bahasa Indonesia', 2, 1, 'True', 'TEORI', 'UIN60003', 7, 'MK99'),
(598, 'Kimia Sintesis Senyawa Organik', 2, 1, 'True', 'TEORI', 'MK03193', 6, NULL),
(599, 'Kimia Organik Bahan Alam', 2, 1, 'True', 'TEORI', 'MK03194', 6, NULL),
(600, 'Praktikum Analisis Instrumen', 1, 1, 'True', 'PRAKTIKUM', 'mk09099', 6, NULL),
(602, 'Kimia Oleo', 2, 1, 'True', 'TEORI', 'mk23131', 6, NULL),
(603, 'Kimia Pangan', 2, 1, 'True', 'TEORI', 'mk23132', 6, NULL),
(604, 'Biokimia I', 3, 1, 'True', 'TEORI', 'mk4245', 6, NULL),
(605, 'Praktikum Biokumua I', 1, 1, 'True', 'PRAKTIKUM', 'mk42432', 6, NULL),
(606, 'Praktikum Kimia Anorganik I', 1, 1, 'True', 'PRAKTIKUM', 'mk42432', 6, NULL),
(607, 'Ikatan Kimia', 3, 1, 'True', 'TEORI', 'mk42432', 6, NULL),
(608, 'Kimia Analitik I', 3, 1, 'True', 'TEORI', 'mk42432', 6, NULL),
(609, 'Pemisahan dan Elektroanalisis', 2, 1, 'True', 'TEORI', 'mk42432', 6, NULL),
(610, 'Analisis Non Preparatif', 2, 1, 'True', 'TEORI', 'mk42432', 6, NULL),
(611, 'Analisis Non Preparatif 2', 2, 1, 'True', 'TEORI', 'mk42438', 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2017-11-20-223112', 'Myth\\Auth\\Database\\Migrations\\CreateAuthTables', 'default', 'Myth\\Auth', 1733232525, 1),
(1, '2017-11-20-223112', 'Myth\\Auth\\Database\\Migrations\\CreateAuthTables', 'default', 'Myth\\Auth', 1733232525, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pengampu`
--

CREATE TABLE `pengampu` (
  `id` int(10) NOT NULL,
  `id_mk` int(10) DEFAULT NULL,
  `id_dosen` int(10) DEFAULT NULL,
  `kelas` int(10) DEFAULT NULL,
  `tahun_akademik` int(10) DEFAULT NULL,
  `id_prodi` int(11) DEFAULT NULL,
  `semester` int(2) DEFAULT NULL,
  `id_ruang` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengampu`
--

INSERT INTO `pengampu` (`id`, `id_mk`, `id_dosen`, `kelas`, `tahun_akademik`, `id_prodi`, `semester`, `id_ruang`) VALUES
(1361, 575, 119, 2, 10, 6, 3, 0),
(1365, 550, 103, 1, 10, 6, 1, 0),
(1366, 576, 101, 2, 10, 6, 3, 0),
(1367, 564, 89, 1, 10, 6, 1, 0),
(1368, 563, 85, 1, 10, 6, 1, 0),
(1369, 569, 282, 2, 10, 6, 3, 0),
(1370, 578, 282, 3, 10, 6, 5, 0),
(1371, 579, 282, 3, 10, 6, 5, 0),
(1372, 580, 282, 3, 10, 6, 5, 0),
(1373, 577, 271, 3, 10, 6, 5, 0),
(1374, 581, 266, 3, 10, 6, 5, 0),
(1375, 600, 258, 3, 10, 6, 5, 0),
(1376, 602, 258, 3, 10, 6, 5, 0),
(1377, 604, 258, 2, 10, 6, 3, 0),
(1378, 605, 258, 2, 10, 6, 3, 0),
(1379, 566, 220, 1, 10, 6, 1, 0),
(1380, 572, 220, 2, 10, 6, 3, 0),
(1381, 573, 220, 2, 10, 6, 3, 0),
(1382, 606, 220, 2, 10, 6, 3, 0),
(1383, 607, 220, 3, 10, 6, 5, 0),
(1384, 567, 220, 1, 10, 6, 1, 0),
(1385, 570, 212, 2, 10, 6, 3, 0),
(1386, 571, 212, 2, 10, 6, 3, 0),
(1387, 608, 212, 2, 10, 6, 3, 0),
(1388, 609, 212, 3, 10, 6, 5, 0),
(1389, 610, 212, 2, 10, 6, 5, 0),
(1390, 522, 199, 1, 10, 6, 1, 0),
(1391, 561, 198, 2, 10, 6, 3, 0),
(1392, 517, 124, 2, 10, 6, 3, 0),
(1393, 501, 124, 1, 10, 6, 1, 0),
(1394, 518, 121, 1, 10, 6, 1, 0),
(1395, 599, 119, 3, 10, 6, 5, 0),
(1396, 598, 119, 3, 10, 6, 5, 0),
(1397, 575, 119, 2, 10, 6, 3, 0),
(1399, 550, 103, 1, 10, 6, 1, 0),
(1400, 576, 101, 2, 10, 6, 3, 0),
(1402, 563, 85, 1, 10, 6, 1, 0),
(1407, 498, 85, 1, 10, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `id` int(11) NOT NULL,
  `nama_prodi` varchar(50) NOT NULL,
  `id_prodi` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`id`, `nama_prodi`, `id_prodi`) VALUES
(1, 'Sistem Informasi', 'P01'),
(2, 'Arsitektur', 'P02'),
(3, 'Statistika', 'P03'),
(4, 'Sains Informasi Geografi', 'P04'),
(5, 'Biologi', 'P05'),
(6, 'Kimia', 'P06'),
(7, 'Fisika', 'P07');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_penjadwalan`
--

CREATE TABLE `riwayat_penjadwalan` (
  `id` int(11) NOT NULL,
  `id_pengampu` int(10) NOT NULL,
  `id_hari` int(5) NOT NULL,
  `id_jam` int(5) NOT NULL,
  `id_ruang` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `riwayat_penjadwalan`
--

INSERT INTO `riwayat_penjadwalan` (`id`, `id_pengampu`, `id_hari`, `id_jam`, `id_ruang`) VALUES
(913, 1361, 1, 11, 40),
(914, 1365, 1, 4, 27),
(915, 1383, 1, 1, 26),
(916, 1386, 1, 9, 40),
(917, 1390, 1, 6, 28),
(918, 1400, 1, 8, 28),
(919, 1374, 2, 3, 28),
(920, 1375, 2, 9, 40),
(921, 1376, 2, 8, 26),
(922, 1380, 2, 1, 28),
(923, 1382, 2, 12, 40),
(924, 1384, 2, 10, 40),
(925, 1389, 2, 8, 28),
(926, 1391, 2, 6, 28),
(927, 1394, 2, 5, 27),
(928, 1397, 2, 11, 40),
(929, 1366, 3, 5, 26),
(930, 1367, 3, 7, 27),
(931, 1372, 3, 7, 28),
(932, 1377, 3, 3, 26),
(933, 1385, 3, 4, 27),
(934, 1388, 3, 5, 27),
(935, 1396, 3, 8, 26),
(936, 1399, 3, 2, 26),
(937, 1369, 4, 3, 27),
(938, 1371, 4, 5, 27),
(939, 1378, 4, 12, 40),
(940, 1387, 4, 2, 27),
(941, 1393, 4, 7, 26),
(942, 1395, 4, 6, 26),
(943, 1402, 4, 6, 28),
(944, 1368, 5, 5, 28),
(945, 1370, 5, 6, 27),
(946, 1373, 5, 5, 26),
(947, 1381, 5, 9, 40),
(948, 1400, 5, 6, 26);

-- --------------------------------------------------------

--
-- Table structure for table `ruang`
--

CREATE TABLE `ruang` (
  `id` int(10) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `jenis` enum('TEORI','LABORATORIUM') DEFAULT NULL,
  `id_prodi` int(5) NOT NULL,
  `lantai` int(3) NOT NULL,
  `id_ruang` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruang`
--

INSERT INTO `ruang` (`id`, `nama`, `jenis`, `id_prodi`, `lantai`, `id_ruang`) VALUES
(0, 'Acak', NULL, 0, 1, 'R0'),
(1, 'Ruang A', 'TEORI', 1, 6, 'Ruang A'),
(2, 'Ruang B', 'TEORI', 1, 6, 'Ruang B'),
(3, 'Ruang C', 'TEORI', 1, 6, 'Ruang C'),
(4, 'Ruang D', 'TEORI', 1, 6, 'Ruang D'),
(5, 'Ruang E', 'TEORI', 1, 6, 'Ruang E'),
(6, 'Ruang F', 'TEORI', 1, 6, 'Ruang F'),
(7, 'Ruang G', 'TEORI', 1, 6, 'Ruang G'),
(8, 'Ruang H', 'TEORI', 1, 6, 'Ruang H'),
(9, 'Ruang I', 'TEORI', 1, 6, 'Ruang I'),
(10, 'Ruang J', 'TEORI', 1, 6, 'Ruang J'),
(11, 'Ruang K', 'TEORI', 1, 6, 'Ruang K'),
(12, 'Ruang L', 'TEORI', 1, 6, 'Ruang L'),
(13, 'Ruang M', 'TEORI', 1, 6, 'Ruang M'),
(14, 'Ruang N', 'TEORI', 1, 6, 'Ruang N'),
(15, 'Ruang O', 'TEORI', 1, 6, 'Ruang O'),
(16, 'Ruang P', 'TEORI', 1, 6, 'Ruang P'),
(17, 'Ruang Q', 'TEORI', 1, 6, 'Ruang Q'),
(18, 'Ruang R', 'TEORI', 1, 6, 'Ruang R'),
(19, 'Ruang S', 'TEORI', 1, 6, 'Ruang S'),
(20, 'Ruang T', 'TEORI', 1, 6, 'Ruang T'),
(21, 'Ruang U', 'TEORI', 1, 6, 'Ruang U'),
(22, 'Ruang A. 605', 'TEORI', 4, 6, 'Ruang A. 605'),
(23, 'Ruang A. 606', 'TEORI', 4, 6, 'Ruang A. 606'),
(24, 'Ruang E. 603', 'TEORI', 7, 6, 'Ruang E. 603'),
(25, 'Ruang E. 604', 'TEORI', 7, 6, 'Ruang E. 604'),
(26, 'Ruang E. 605', 'TEORI', 6, 6, 'Ruang E. 605'),
(27, 'Ruang E. 606', 'TEORI', 6, 6, 'Ruang E. 606'),
(28, 'Ruang E. 607', 'TEORI', 6, 6, 'Ruang E. 607'),
(29, 'Ruang D. 604', 'TEORI', 2, 6, 'Ruang D. 604'),
(30, 'Ruang D. 605', 'TEORI', 2, 6, 'Ruang D. 605'),
(31, 'Ruang A. 601', 'TEORI', 3, 6, 'Ruang A. 601'),
(32, 'Ruang A. 607', 'TEORI', 3, 6, 'Ruang A. 607'),
(33, 'Ruang E. 601', 'TEORI', 5, 6, 'Ruang E. 601'),
(34, 'Ruang D. 607', 'TEORI', 5, 6, 'Ruang D. 607'),
(35, 'Lab. Fisika', 'LABORATORIUM', 7, 1, 'Lab. Fisika'),
(36, 'Lab. Kedokteran', 'LABORATORIUM', 5, 1, 'Lab. Kedokteran'),
(37, 'Lab. SI 1', 'LABORATORIUM', 1, 2, 'Lab. SI 1'),
(38, 'Lab. SI 2', 'LABORATORIUM', 1, 1, 'Lab. SI 2'),
(39, 'Lab. SI 3', 'LABORATORIUM', 1, 2, 'Lab. SI 3'),
(40, 'Lab. Kimia', 'LABORATORIUM', 6, 1, 'Lab. Kimia');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `id` int(2) NOT NULL,
  `nama_semester` varchar(10) NOT NULL,
  `semester_tipe` int(10) NOT NULL,
  `id_semester` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`id`, `nama_semester`, `semester_tipe`, `id_semester`) VALUES
(1, 'I', 1, 'S01'),
(2, 'II', 2, 'S02'),
(3, 'III', 1, 'S03'),
(4, 'IV', 2, 'S04'),
(5, 'V', 1, 'S05'),
(6, 'VI', 2, 'S06'),
(7, 'VII', 1, 'S07'),
(11, 'VIII', 2, 'S08');

-- --------------------------------------------------------

--
-- Table structure for table `semester_tipe`
--

CREATE TABLE `semester_tipe` (
  `id` int(2) NOT NULL,
  `tipe_semester` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `semester_tipe`
--

INSERT INTO `semester_tipe` (`id`, `tipe_semester`) VALUES
(1, 'GANJIL'),
(2, 'GENAP');

-- --------------------------------------------------------

--
-- Table structure for table `status_dosen`
--

CREATE TABLE `status_dosen` (
  `id` int(5) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status_dosen`
--

INSERT INTO `status_dosen` (`id`, `status`) VALUES
(1, 'Dosen Tetap PNS'),
(2, 'Dosen PPPK'),
(3, 'Dosen Tetap  Bukan PNS'),
(4, 'Dosen Tetap BLU'),
(5, 'Dosen Luar Biasa');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_akademik`
--

CREATE TABLE `tahun_akademik` (
  `id` int(10) NOT NULL,
  `tahun` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tahun_akademik`
--

INSERT INTO `tahun_akademik` (`id`, `tahun`) VALUES
(10, '2023-2024');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `username` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `reset_hash` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `status_message` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `fullname` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `user_image` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT 'default.svg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`, `fullname`, `user_image`) VALUES
(1, 'coba@gmail.com', 'Coba', '$2y$10$ixA25UxAh6ewyWNF7Flssu73iUOzibxf5elpCMCbjk8TKkex9rpZe', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 'admin', 'default.svg'),
(4, 'alex@gmail.com', NULL, '534b44a19bf18d20b71ecc4eb77c572f', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 'alex', 'default.svg');

-- --------------------------------------------------------

--
-- Table structure for table `waktu_tidak_bersedia`
--

CREATE TABLE `waktu_tidak_bersedia` (
  `id` int(10) NOT NULL,
  `id_dosen` int(10) DEFAULT NULL,
  `id_hari` int(10) DEFAULT NULL,
  `id_jam` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `waktu_tidak_bersedia`
--

INSERT INTO `waktu_tidak_bersedia` (`id`, `id_dosen`, `id_hari`, `id_jam`) VALUES
(1, 196, 5, 8),
(2, 196, 5, 19),
(3, 196, 5, 4),
(4, 196, 5, 15),
(5, 196, 5, 21);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guru_ibfk_1` (`status_dosen`);

--
-- Indexes for table `hari`
--
ALTER TABLE `hari`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwalkuliah`
--
ALTER TABLE `jadwalkuliah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwalpelajaran_ibfk_1` (`id_pengampu`),
  ADD KEY `kode_jam` (`id_jam`),
  ADD KEY `kode_hari` (`id_hari`),
  ADD KEY `kode_ruang` (`id_ruang`);

--
-- Indexes for table `jam`
--
ALTER TABLE `jam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jam2`
--
ALTER TABLE `jam2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matapelajaran_ibfk_1` (`semester`),
  ADD KEY `matapelajaran_ibfk_2` (`id_prodi`);

--
-- Indexes for table `pengampu`
--
ALTER TABLE `pengampu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_mk` (`id_mk`),
  ADD KEY `kode_guru` (`id_dosen`),
  ADD KEY `kelas` (`kelas`),
  ADD KEY `tahun_akademik` (`tahun_akademik`),
  ADD KEY `kode_prodi` (`id_prodi`),
  ADD KEY `semester` (`semester`),
  ADD KEY `kode_ruang` (`id_ruang`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat_penjadwalan`
--
ALTER TABLE `riwayat_penjadwalan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengampu` (`id_pengampu`),
  ADD KEY `id_hari` (`id_hari`),
  ADD KEY `id_ruang` (`id_ruang`),
  ADD KEY `id_jam` (`id_jam`);

--
-- Indexes for table `ruang`
--
ALTER TABLE `ruang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ruang_ibfk_1` (`id_prodi`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`id`),
  ADD KEY `semester_ibfk_1` (`semester_tipe`);

--
-- Indexes for table `semester_tipe`
--
ALTER TABLE `semester_tipe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_dosen`
--
ALTER TABLE `status_dosen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tahun_akademik`
--
ALTER TABLE `tahun_akademik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `waktu_tidak_bersedia`
--
ALTER TABLE `waktu_tidak_bersedia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `waktu_tidak_bersedia_ibfk_2` (`id_dosen`),
  ADD KEY `waktu_tidak_bersedia_ibfk_1` (`id_hari`),
  ADD KEY `waktu_tidak_bersedia_ibfk_3` (`id_jam`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=323;

--
-- AUTO_INCREMENT for table `hari`
--
ALTER TABLE `hari`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jadwalkuliah`
--
ALTER TABLE `jadwalkuliah`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `jam`
--
ALTER TABLE `jam`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jam2`
--
ALTER TABLE `jam2`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `matakuliah`
--
ALTER TABLE `matakuliah`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=613;

--
-- AUTO_INCREMENT for table `pengampu`
--
ALTER TABLE `pengampu`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1408;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `riwayat_penjadwalan`
--
ALTER TABLE `riwayat_penjadwalan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=949;

--
-- AUTO_INCREMENT for table `ruang`
--
ALTER TABLE `ruang`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `semester_tipe`
--
ALTER TABLE `semester_tipe`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status_dosen`
--
ALTER TABLE `status_dosen`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tahun_akademik`
--
ALTER TABLE `tahun_akademik`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `waktu_tidak_bersedia`
--
ALTER TABLE `waktu_tidak_bersedia`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_ibfk_1` FOREIGN KEY (`status_dosen`) REFERENCES `status_dosen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jadwalkuliah`
--
ALTER TABLE `jadwalkuliah`
  ADD CONSTRAINT `jadwalkuliah_ibfk_1` FOREIGN KEY (`id_pengampu`) REFERENCES `pengampu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwalkuliah_ibfk_2` FOREIGN KEY (`id_jam`) REFERENCES `jam2` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwalkuliah_ibfk_3` FOREIGN KEY (`id_hari`) REFERENCES `hari` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwalkuliah_ibfk_4` FOREIGN KEY (`id_ruang`) REFERENCES `ruang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD CONSTRAINT `matakuliah_ibfk_1` FOREIGN KEY (`semester`) REFERENCES `semester_tipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `matakuliah_ibfk_2` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengampu`
--
ALTER TABLE `pengampu`
  ADD CONSTRAINT `pengampu_ibfk_1` FOREIGN KEY (`id_mk`) REFERENCES `matakuliah` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengampu_ibfk_2` FOREIGN KEY (`id_dosen`) REFERENCES `dosen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengampu_ibfk_3` FOREIGN KEY (`kelas`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengampu_ibfk_4` FOREIGN KEY (`tahun_akademik`) REFERENCES `tahun_akademik` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengampu_ibfk_5` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengampu_ibfk_6` FOREIGN KEY (`semester`) REFERENCES `semester` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengampu_ibfk_7` FOREIGN KEY (`id_ruang`) REFERENCES `ruang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prodi`
--
ALTER TABLE `prodi`
  ADD CONSTRAINT `prodi_ibfk_2` FOREIGN KEY (`id`) REFERENCES `ruang` (`id_prodi`);

--
-- Constraints for table `riwayat_penjadwalan`
--
ALTER TABLE `riwayat_penjadwalan`
  ADD CONSTRAINT `riwayat_penjadwalan_ibfk_1` FOREIGN KEY (`id_pengampu`) REFERENCES `pengampu` (`id`),
  ADD CONSTRAINT `riwayat_penjadwalan_ibfk_2` FOREIGN KEY (`id_hari`) REFERENCES `hari` (`id`),
  ADD CONSTRAINT `riwayat_penjadwalan_ibfk_4` FOREIGN KEY (`id_ruang`) REFERENCES `ruang` (`id`),
  ADD CONSTRAINT `riwayat_penjadwalan_ibfk_5` FOREIGN KEY (`id_jam`) REFERENCES `jam2` (`id`);

--
-- Constraints for table `semester`
--
ALTER TABLE `semester`
  ADD CONSTRAINT `semester_ibfk_1` FOREIGN KEY (`semester_tipe`) REFERENCES `semester_tipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `waktu_tidak_bersedia`
--
ALTER TABLE `waktu_tidak_bersedia`
  ADD CONSTRAINT `waktu_tidak_bersedia_ibfk_1` FOREIGN KEY (`id_hari`) REFERENCES `hari` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `waktu_tidak_bersedia_ibfk_2` FOREIGN KEY (`id_dosen`) REFERENCES `dosen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `waktu_tidak_bersedia_ibfk_3` FOREIGN KEY (`id_jam`) REFERENCES `jam2` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
