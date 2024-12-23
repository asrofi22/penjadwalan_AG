-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2024 at 06:29 AM
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
-- Database: `penjadwalan_ga2`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` int(11) UNSIGNED NOT NULL,
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
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
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
(31, '::1', 'coba@gmail.com', 2, '2024-12-23 04:22:11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions`
--

CREATE TABLE `auth_permissions` (
  `id` int(11) UNSIGNED NOT NULL,
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
  `id` int(11) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `auth_users_permissions`
--

CREATE TABLE `auth_users_permissions` (
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id` int(10) NOT NULL,
  `nip` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `nama` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `alamat` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `telp` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `password` varchar(100) CHARACTER SET latin1 NOT NULL,
  `status_dosen` int(3) NOT NULL,
  `id_dosen` varchar(10) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id`, `nip`, `nama`, `alamat`, `telp`, `password`, `status_dosen`, `id_dosen`) VALUES
(1, NULL, 'Asrofi, M.Kom', NULL, 'agama', '', 1, 'D94'),
(2, NULL, 'Dr. Ropi, M.Eng', NULL, NULL, '', 1, 'D42'),
(3, '1234', 'Dr. rofi, S.SI., M.Kom.', 'gading', '0823', '', 1, 'D20'),
(4, NULL, 'Melky, ST', NULL, NULL, '', 1, 'D156'),
(5, NULL, 'Alif, S.Si', NULL, NULL, '', 1, 'D163'),
(6, NULL, 'Arsyad  Sanusi, M.Ag', NULL, NULL, '', 1, 'D69'),
(7, NULL, 'M. Ilham, S.Kom', NULL, NULL, '', 1, 'D154'),
(8, NULL, 'Hidayah Mecca, M.Kom', NULL, NULL, '', 1, 'D06'),
(9, NULL, 'Arivai', NULL, NULL, '', 1, 'D103'),
(10, NULL, 'Rizky Ilahi', NULL, NULL, '', 1, 'D84'),
(11, NULL, 'Sarwoto, S.Kom., MIT', NULL, NULL, '', 1, 'D04'),
(12, NULL, 'Jumirah, M.Kom', NULL, NULL, '', 1, 'D106'),
(13, NULL, 'Fariz, M.Kom', NULL, NULL, '', 1, 'D10'),
(14, NULL, 'Faraz, ST, MIT', NULL, NULL, '', 1, 'D96'),
(15, NULL, 'Pol Metra, M.Kom', NULL, NULL, '', 1, 'D93'),
(16, NULL, 'Bastomi Baharsyah, M.Kom', NULL, NULL, '', 1, 'D137'),
(17, NULL, 'Sugiatno', NULL, NULL, '', 1, 'D105'),
(18, NULL, 'Hendra, S.Pd.', NULL, NULL, '', 1, 'D162'),
(19, NULL, 'Ardikal Bali, S.Th., M.Th.', NULL, NULL, '', 1, 'D08'),
(20, NULL, 'Pdt. Md. Sonika, S.Ag., M.Pd', NULL, NULL, '', 1, 'D122'),
(21, NULL, 'Putu Senawa, S.Pd.', NULL, NULL, '', 1, 'D133'),
(22, NULL, 'Ir. Rusmadi Awza, S.Sos., M.Si.', NULL, NULL, '', 1, 'D104'),
(23, NULL, 'Al Aminuddin, ST., M.Sc.', NULL, NULL, '', 1, 'D05'),
(24, NULL, 'Yuliantoro, S.Pd, M.Pd', NULL, NULL, '', 1, 'D161'),
(25, NULL, 'Roza Afifah, S.Pd SD', NULL, NULL, '', 1, 'D138');

-- --------------------------------------------------------

--
-- Table structure for table `hari`
--

CREATE TABLE `hari` (
  `id` int(10) NOT NULL,
  `nama` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `id_hari` varchar(5) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jam`
--

CREATE TABLE `jam` (
  `id` int(10) NOT NULL,
  `range_jam` varchar(50) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jam2`
--

CREATE TABLE `jam2` (
  `id` int(10) NOT NULL,
  `range_jam` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `sks` int(2) DEFAULT NULL,
  `sesi` int(2) DEFAULT NULL,
  `id_jam` varchar(5) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(10, '10.10-11:00', 1, 2, 'T02'),
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
  `nama_kelas` varchar(10) CHARACTER SET latin1 NOT NULL,
  `id_prodi` int(3) NOT NULL,
  `id_kelas` varchar(5) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama_kelas`, `id_prodi`, `id_kelas`) VALUES
(1, 'A', 1, 'K01'),
(2, 'B', 1, 'K02'),
(3, 'C', 1, 'K03'),
(4, 'D', 1, 'K04'),
(5, 'E', 1, 'K05');

-- --------------------------------------------------------

--
-- Table structure for table `matakuliah`
--

CREATE TABLE `matakuliah` (
  `id` int(10) NOT NULL,
  `nama` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `jumlah_jam` int(6) DEFAULT NULL,
  `semester` int(2) DEFAULT NULL,
  `aktif` enum('True','False') CHARACTER SET latin1 DEFAULT 'True',
  `jenis` enum('TEORI','PRAKTIKUM') CHARACTER SET latin1 DEFAULT 'TEORI',
  `nama_kode` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `id_prodi` int(5) DEFAULT NULL,
  `id_mk` varchar(10) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `matakuliah`
--

INSERT INTO `matakuliah` (`id`, `nama`, `jumlah_jam`, `semester`, `aktif`, `jenis`, `nama_kode`, `id_prodi`, `id_mk`) VALUES
(1, 'Manajemen dan Organisasi', 2, 1, 'True', 'TEORI', 'PAS11003', 1, 'M19'),
(2, 'Pengembangan Sistem Informasi Berbasis Web Lanjut', 3, 1, 'True', 'TEORI', 'PAS31132', 1, 'M08'),
(3, 'Kapita Selekta SIG', 3, 1, 'True', 'TEORI', 'MAS4111', 1, 'M27'),
(4, 'Kapita Selekta Bisnis', 3, 1, 'True', 'TEORI', 'MAS4121', 1, 'M14'),
(5, 'Perencanaan Sumber daya Perusahaan', 3, 1, 'True', 'TEORI', 'PAS31028', 1, 'M04'),
(6, 'Metode Penelitian', 2, 1, 'True', 'TEORI', 'MAS3102', 1, 'M21'),
(7, 'Komunikasi Antar Pribadi', 2, 1, 'True', 'TEORI', 'PAS31027', 1, 'M10'),
(8, 'Analisis dan Perancangan Berorientasi Objek', 3, 1, 'True', 'TEORI', 'PAS31024', 1, 'M29'),
(9, 'Aplikasi Mobile', 3, 1, 'True', 'TEORI', 'MAS4102', 1, 'M17'),
(10, 'Pengembangan Antarmuka Pengguna Sistem Informasi', 3, 1, 'True', 'TEORI', 'PAS21012', 1, 'M07'),
(11, 'Sistem Pendukung Keputusan', 3, 1, 'True', 'TEORI', 'PAS31133', 1, 'M24'),
(12, 'Rekayasa Perangkat Lunak', 3, 1, 'True', 'TEORI', 'PAS21014', 1, 'M12'),
(13, 'Konsep Pemograman', 2, 1, 'True', 'TEORI', 'PAS11002', 1, 'M01'),
(14, 'Sistem Enterprise', 3, 1, 'True', 'TEORI', 'PAS31030', 1, 'M18'),
(15, 'Pengantar Analisis Real', 3, 1, 'True', 'TEORI', 'PAM33025', 4, 'M87'),
(16, 'Fungsi Var. Kompleks', 3, 1, 'True', 'TEORI', 'PAM33025', 4, 'M105'),
(17, 'Kalkulus I', 2, 1, 'True', 'TEORI', 'PAM13001', 4, 'M93'),
(18, 'Agama Protestan', 2, 1, 'True', 'TEORI', 'UXN11055', 7, 'M260'),
(19, 'Agama Buddha', 2, 1, 'True', 'TEORI', 'UXN11139', 7, 'M262'),
(20, 'Agama Katolik', 2, 1, 'True', 'TEORI', 'UXN11097', 7, 'M261'),
(21, 'Statistika dan Probabilitas', 3, 1, 'True', 'TEORI', 'MIP11065', 1, 'M26'),
(22, 'Matematika Komputasi', 3, 1, 'True', 'PRAKTIKUM', 'PAM21011', 4, 'M96'),
(23, 'Kewirausahaan', 2, 1, 'True', 'TEORI', 'MAS4103', 1, 'M03'),
(24, 'Matematika Diskrit', 3, 1, 'True', 'TEORI', 'PAS11001', 1, 'M20'),
(25, 'Bahasa Indonesia', 2, 1, 'True', 'TEORI', 'UXN12096', 1, 'M09'),
(26, 'Pendidikan Agama', 3, 1, 'True', 'TEORI', 'UXN11013', 1, 'M28'),
(27, 'Pendidikan Pancasila', 2, 1, 'True', 'TEORI', 'UXN11181', 1, 'M15'),
(28, 'Sistem Informasi Geografis Terdistribusi', 3, 1, 'True', 'TEORI', 'PAS32037', 1, 'M05'),
(29, 'Tata Kelola Sistem Informasi', 3, 1, 'True', 'TEORI', 'PAS31029', 1, 'M22'),
(30, 'Bahasa Inggris', 2, 1, 'True', 'TEORI', 'UXN12162', 1, 'M11'),
(31, 'Metode Diskrit', 3, 1, 'True', 'TEORI', 'PAM13001', 4, 'M110'),
(32, 'Pengantar Teknologi dan Sistem Informasi', 3, 1, 'True', 'TEORI', 'MIP11057', 2, 'M43'),
(33, 'Multimedia', 3, 1, 'True', 'PRAKTIKUM', 'PAI31032', 2, 'M33'),
(34, 'Manajemen dan Organisasi', 3, 1, 'True', 'TEORI', 'PAI21013', 2, 'M48'),
(35, 'Konsep Pemrograman', 4, 1, 'True', 'TEORI', 'PAI11003', 2, 'M40'),
(36, 'Matematika Diskrit', 3, 1, 'True', 'TEORI', 'PAI11001', 2, 'M30'),
(37, 'Algoritma dan Struktur Data', 3, 1, 'True', 'PRAKTIKUM', 'PAI21015', 2, 'M45'),
(38, 'Sistem Informasi Geografis II', 3, 1, 'True', 'PRAKTIKUM', 'PAI31031', 2, 'M35'),
(39, 'Sistem Informasi Manajemen', 2, 1, 'True', 'TEORI', 'PAI21012', 2, 'M49'),
(40, 'Keamanan Sistem Informasi', 3, 1, 'True', 'PRAKTIKUM', 'PAI31027', 2, 'M41'),
(41, 'Pendidikan Pancasila', 2, 1, 'True', 'TEORI', 'UXN11182', 2, 'M31'),
(42, 'Agama Islam', 2, 1, 'True', 'TEORI', 'UXN11014', 2, 'M46'),
(43, 'Pemograman Web Lanjut', 3, 1, 'True', 'PRAKTIKUM', 'PAI21018', 2, 'M36'),
(44, 'Aplikasi Perkantoran', 3, 1, 'True', 'PRAKTIKUM', 'PAI11004', 2, 'M50'),
(45, 'Etika Profesi', 2, 1, 'True', 'TEORI', 'PAI31026', 2, 'M42'),
(46, 'Kewarganegaraan', 2, 1, 'True', 'TEORI', 'UXN12125', 2, 'M32'),
(47, 'Pemograman Visual', 3, 1, 'True', 'PRAKTIKUM', 'PAI21017', 2, 'M47'),
(48, 'Manajemen Infrastruktur Sistem Informasi', 3, 1, 'True', 'TEORI', 'PAI21014', 2, 'M38'),
(49, 'Perancangan Antar Muka', 3, 1, 'True', 'PRAKTIKUM', 'PAI31030', 2, 'M52'),
(50, 'Pengantar Teknologi dan Sistem Informasi', 3, 1, 'True', 'TEORI', 'MIP11055', 1, 'M16'),
(51, 'Algoritma dan Struktur Data', 3, 1, 'True', 'TEORI', 'PAS21011', 1, 'M06'),
(52, 'Jaringan Komputer', 3, 1, 'True', 'TEORI', 'PAS21013', 1, 'M23'),
(53, 'Bahasa Inggris I', 2, 1, 'True', 'TEORI', 'UXN12163', 2, 'M39');

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
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
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
  `kuota` int(5) DEFAULT NULL,
  `id_ruang` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengampu`
--

INSERT INTO `pengampu` (`id`, `id_mk`, `id_dosen`, `kelas`, `tahun_akademik`, `id_prodi`, `semester`, `kuota`, `id_ruang`) VALUES
(1, 1, 1, 1, 1, 2, 1, 0, 0),
(2, 2, 2, 4, 1, 1, 3, 0, 0),
(3, 3, 3, 2, 1, 1, 3, 0, 0),
(4, 4, 4, 3, 1, 1, 3, 0, 0),
(5, 5, 5, 1, 1, 4, 3, 0, 0),
(6, 6, 6, 1, 1, 2, 3, 0, 0),
(7, 7, 7, 2, 1, 2, 3, 0, 0),
(8, 8, 8, 1, 1, 6, 3, 0, 0),
(9, 9, 9, 2, 1, 2, 3, 0, 0),
(10, 10, 10, 1, 1, 1, 1, 0, 0),
(11, 11, 11, 2, 1, 1, 1, 0, 0),
(12, 12, 12, 3, 1, 1, 1, 0, 0),
(13, 13, 13, 1, 1, 4, 1, 0, 0),
(14, 14, 14, 2, 1, 2, 1, 0, 0),
(15, 15, 15, 1, 1, 6, 3, 0, 0),
(16, 16, 16, 1, 1, 3, 1, 20, 0),
(17, 17, 17, 1, 1, 3, 3, 30, 0),
(18, 18, 18, 1, 1, 3, 7, 30, 0),
(19, 19, 19, 1, 1, 3, 1, 40, 0),
(20, 20, 20, 1, 1, 3, 5, 35, 0),
(21, 21, 21, 1, 1, 3, 5, 30, 0),
(22, 22, 22, 1, 1, 3, 3, 30, 0),
(23, 23, 23, 1, 1, 3, 5, 30, 0),
(24, 24, 24, 1, 1, 5, 5, 40, 0),
(25, 25, 25, 1, 1, 5, 1, 40, 0),
(26, 26, 25, 2, 1, 2, 3, 0, 0),
(27, 27, 24, 1, 1, 1, 3, 0, 0),
(28, 28, 23, 2, 1, 1, 3, 0, 0),
(29, 29, 22, 3, 1, 1, 3, 0, 0),
(30, 30, 21, 1, 1, 4, 1, 0, 0),
(31, 31, 20, 1, 1, 2, 3, 0, 0),
(32, 32, 19, 2, 1, 2, 3, 0, 0),
(33, 33, 18, 1, 1, 2, 3, 0, 0),
(34, 34, 17, 2, 1, 2, 3, 0, 0),
(35, 35, 16, 1, 1, 3, 1, 40, 0),
(36, 36, 15, 1, 1, 3, 3, 35, 0),
(37, 37, 14, 2, 1, 3, 3, 20, 0),
(38, 38, 13, 1, 1, 3, 3, 35, 0),
(39, 39, 12, 1, 1, 3, 5, 30, 0),
(40, 40, 11, 2, 1, 3, 1, 20, 0),
(41, 41, 10, 1, 1, 3, 1, 40, 0),
(42, 42, 9, 1, 1, 3, 5, 35, 0),
(43, 43, 8, 1, 1, 3, 1, 40, 0),
(44, 44, 7, 1, 1, 1, 5, 0, 0),
(45, 45, 6, 3, 1, 1, 5, 0, 0),
(46, 46, 5, 3, 1, 1, 5, 0, 0),
(47, 47, 4, 1, 1, 4, 5, 0, 0),
(48, 48, 3, 1, 1, 3, 5, 0, 0),
(49, 49, 2, 2, 1, 3, 5, 0, 0),
(50, 50, 1, 1, 1, 2, 5, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `id` int(11) NOT NULL,
  `prodi` varchar(50) CHARACTER SET latin1 NOT NULL,
  `id_prodi` varchar(5) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`id`, `prodi`, `id_prodi`) VALUES
(1, 'Sistem Informasi', 'P01'),
(2, 'Fisika', 'P02'),
(3, 'Statistika', 'P03'),
(4, 'Biologi', 'P05'),
(5, 'Kimia', 'P06'),
(6, 'Sains Informasi Geografi', 'P07'),
(7, 'AArsitektur', 'P08');

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

-- --------------------------------------------------------

--
-- Table structure for table `ruang`
--

CREATE TABLE `ruang` (
  `id` int(10) NOT NULL,
  `nama` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `kapasitas` int(10) DEFAULT NULL,
  `jenis` enum('TEORI','LABORATORIUM') CHARACTER SET latin1 DEFAULT NULL,
  `id_prodi` int(5) NOT NULL,
  `lantai` int(3) NOT NULL,
  `id_ruang` varchar(5) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ruang`
--

INSERT INTO `ruang` (`id`, `nama`, `kapasitas`, `jenis`, `id_prodi`, `lantai`, `id_ruang`) VALUES
(0, 'Acak', 0, NULL, 0, 1, 'R00'),
(1, 'Ruang 101', 50, 'TEORI', 2, 1, 'R1'),
(2, 'Ruang 102', 45, 'TEORI', 5, 1, 'R2'),
(3, 'Ruang 103', 40, 'TEORI', 1, 1, 'R3'),
(4, 'Ruang 105', 35, 'TEORI', 5, 1, 'R4'),
(5, 'Ruang 106', 45, 'TEORI', 4, 1, 'R5'),
(6, 'Ruang 107', 45, 'TEORI', 3, 1, 'R6'),
(7, 'Ruang 201', 50, 'TEORI', 3, 2, 'R7'),
(8, 'Ruang 202', 45, 'TEORI', 2, 2, 'R8'),
(9, 'Ruang 203', 40, 'TEORI', 1, 2, 'R9'),
(10, 'Ruang 206', 45, 'TEORI', 5, 2, 'R10'),
(11, 'Ruang 207', 45, 'TEORI', 3, 2, 'R11'),
(12, 'Ruang 208', 45, 'TEORI', 3, 2, 'R12'),
(13, 'Ruang 301', 50, 'TEORI', 1, 3, 'R13'),
(14, 'Ruang 302', 45, 'TEORI', 2, 3, 'R14'),
(15, 'Ruang 303', 50, 'TEORI', 1, 3, 'R15'),
(16, 'Ruang 304', 45, 'TEORI', 2, 3, 'R16'),
(17, 'Ruang 305', 45, 'TEORI', 4, 3, 'R17'),
(18, 'Ruang 306', 45, 'TEORI', 5, 3, 'R18'),
(19, 'Ruang 307', 45, 'TEORI', 3, 3, 'R19'),
(20, 'Ruang 308', 45, 'TEORI', 2, 3, 'R20'),
(21, 'Ruang 309', 50, 'TEORI', 1, 3, 'R21'),
(22, 'Dekanat 202', 40, 'TEORI', 2, 2, 'R22'),
(23, 'Dekanat 204', 40, 'TEORI', 2, 2, 'R23'),
(24, 'Dekanat 207', 40, 'TEORI', 5, 2, 'R24'),
(25, 'Dekanat 208', 40, 'TEORI', 5, 2, 'R25'),
(26, 'Ruang Seminar I', 45, 'TEORI', 4, 1, 'R26'),
(27, 'Ruang Seminar II', 45, 'TEORI', 4, 1, 'R27'),
(28, 'Lab. Fisika Dasar', 45, 'LABORATORIUM', 0, 1, 'R28'),
(29, 'Lab. Kimia Dasar', 45, 'LABORATORIUM', 0, 1, 'R29'),
(30, 'Lab. Kimia Fisik', 45, 'LABORATORIUM', 0, 1, 'R30'),
(31, 'Lab. Organik', 45, 'LABORATORIUM', 4, 1, 'R31'),
(32, 'Lab. Anorganik', 45, 'LABORATORIUM', 4, 1, 'R32'),
(33, 'Lab. Analitik', 45, 'LABORATORIUM', 4, 1, 'R33'),
(34, 'Lab. Kom Matematika', 20, 'LABORATORIUM', 2, 1, 'R34'),
(35, 'Audit Fisika', 50, 'TEORI', 5, 1, 'R35'),
(36, 'Lab. Elka', 45, 'LABORATORIUM', 5, 1, 'R36'),
(37, 'Lab. Multimedia', 50, 'LABORATORIUM', 1, 2, 'R37'),
(38, 'Lab. SIKOM', 35, 'LABORATORIUM', 1, 1, 'R38'),
(39, 'EDP', 35, 'TEORI', 1, 2, 'R39'),
(40, 'Lab. Zoologi', 0, 'LABORATORIUM', 3, 1, 'R40'),
(41, 'Lab. Botani', 0, 'LABORATORIUM', 3, 1, 'R41'),
(42, 'Lab. Ekologi', 0, 'LABORATORIUM', 3, 1, 'R42'),
(43, 'Lab. Genetika', 0, 'LABORATORIUM', 3, 1, 'R43'),
(44, 'Lab. Mikrobiologi', 0, 'LABORATORIUM', 3, 1, 'R44'),
(45, 'Lab. Riset', 0, 'LABORATORIUM', 3, 1, 'R45'),
(46, 'Lab. Mikroteknik', 0, 'LABORATORIUM', 3, 1, 'R46'),
(47, 'Ruang 205', 45, 'TEORI', 4, 2, 'R47');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `id` int(2) NOT NULL,
  `nama_semester` varchar(10) CHARACTER SET latin1 NOT NULL,
  `semester_tipe` int(10) NOT NULL,
  `id_semester` varchar(5) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(8, 'VIII', 2, 'S08');

-- --------------------------------------------------------

--
-- Table structure for table `semester_tipe`
--

CREATE TABLE `semester_tipe` (
  `id` int(2) NOT NULL,
  `tipe_semester` varchar(10) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `id` int(11) NOT NULL,
  `status` varchar(15) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status_dosen`
--

INSERT INTO `status_dosen` (`id`, `status`) VALUES
(1, 'Aktif'),
(2, 'Non-aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_akademik`
--

CREATE TABLE `tahun_akademik` (
  `id` int(10) NOT NULL,
  `tahun` varchar(20) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tahun_akademik`
--

INSERT INTO `tahun_akademik` (`id`, `tahun`) VALUES
(1, '2024-2025'),
(3, '2023-2024');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `user_image` varchar(255) NOT NULL DEFAULT 'default.svg',
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `fullname`, `user_image`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'asrofibinsarwoto@gmail.com', 'Asrofi', NULL, 'default.svg', '$2y$10$mMZtMjfpnVFlgk4CKtrd9eKxSl4A1ekojJvJcTMd17ueEI8Z4BMKG', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2024-12-04 10:27:32', '2024-12-04 10:27:32', NULL),
(2, 'coba@gmail.com', 'Coba', NULL, 'default.svg', '$2y$10$ixA25UxAh6ewyWNF7Flssu73iUOzibxf5elpCMCbjk8TKkex9rpZe', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2024-12-06 03:56:16', '2024-12-06 03:56:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `waktu_tidak_bersedia`
--

CREATE TABLE `waktu_tidak_bersedia` (
  `id` int(10) NOT NULL,
  `id_dosen` int(10) DEFAULT NULL,
  `id_hari` int(10) DEFAULT NULL,
  `id_jam` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `group_id_permission_id` (`group_id`,`permission_id`);

--
-- Indexes for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`),
  ADD KEY `group_id_user_id` (`group_id`,`user_id`);

--
-- Indexes for table `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_tokens_user_id_foreign` (`user_id`),
  ADD KEY `selector` (`selector`);

--
-- Indexes for table `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `user_id_permission_id` (`user_id`,`permission_id`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_dosen` (`status_dosen`);

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
  ADD KEY `id_pengampu` (`id_pengampu`),
  ADD KEY `id_jam` (`id_jam`),
  ADD KEY `id_hari` (`id_hari`),
  ADD KEY `id_ruang` (`id_ruang`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_ibfk_1` (`id_prodi`);

--
-- Indexes for table `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_prodi` (`id_prodi`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengampu`
--
ALTER TABLE `pengampu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mk` (`id_mk`),
  ADD KEY `id_dosen` (`id_dosen`),
  ADD KEY `kelas` (`kelas`),
  ADD KEY `tahun_akademik` (`tahun_akademik`),
  ADD KEY `id_prodi` (`id_prodi`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_ruang` (`id_ruang`);

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
  ADD KEY `id_jam` (`id_jam`),
  ADD KEY `id_ruang` (`id_ruang`);

--
-- Indexes for table `ruang`
--
ALTER TABLE `ruang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_prodi` (`id_prodi`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`id`),
  ADD KEY `semester_tipe` (`semester_tipe`),
  ADD KEY `tipe_semester_2` (`semester_tipe`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `waktu_tidak_bersedia`
--
ALTER TABLE `waktu_tidak_bersedia`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_dosen` (`id_dosen`),
  ADD KEY `id_guru` (`id_dosen`),
  ADD KEY `id_hari` (`id_hari`),
  ADD KEY `id_jam` (`id_jam`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `hari`
--
ALTER TABLE `hari`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jadwalkuliah`
--
ALTER TABLE `jadwalkuliah`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jam`
--
ALTER TABLE `jam`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jam2`
--
ALTER TABLE `jam2`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `matakuliah`
--
ALTER TABLE `matakuliah`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengampu`
--
ALTER TABLE `pengampu`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `riwayat_penjadwalan`
--
ALTER TABLE `riwayat_penjadwalan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ruang`
--
ALTER TABLE `ruang`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `semester_tipe`
--
ALTER TABLE `semester_tipe`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status_dosen`
--
ALTER TABLE `status_dosen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tahun_akademik`
--
ALTER TABLE `tahun_akademik`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `waktu_tidak_bersedia`
--
ALTER TABLE `waktu_tidak_bersedia`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_ibfk_1` FOREIGN KEY (`status_dosen`) REFERENCES `status_dosen` (`id`);

--
-- Constraints for table `jadwalkuliah`
--
ALTER TABLE `jadwalkuliah`
  ADD CONSTRAINT `jadwalkuliah_ibfk_1` FOREIGN KEY (`id_hari`) REFERENCES `hari` (`id`),
  ADD CONSTRAINT `jadwalkuliah_ibfk_2` FOREIGN KEY (`id_jam`) REFERENCES `jam2` (`id`);

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id`);

--
-- Constraints for table `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD CONSTRAINT `matakuliah_ibfk_1` FOREIGN KEY (`semester`) REFERENCES `semester_tipe` (`id`);

--
-- Constraints for table `riwayat_penjadwalan`
--
ALTER TABLE `riwayat_penjadwalan`
  ADD CONSTRAINT `riwayat_penjadwalan_ibfk_1` FOREIGN KEY (`id_jam`) REFERENCES `jam2` (`id`);

--
-- Constraints for table `waktu_tidak_bersedia`
--
ALTER TABLE `waktu_tidak_bersedia`
  ADD CONSTRAINT `waktu_tidak_bersedia_ibfk_1` FOREIGN KEY (`id_dosen`) REFERENCES `dosen` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
