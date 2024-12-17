-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 06:09 AM
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
(19, '::1', 'coba@gmail.com', 2, '2024-12-16 16:15:48', 1);

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
(1, '45', 'Asrofi', 'dajbk', '121821', '$2y$10$f328nGsdg27luDIUo4tp7.Y5msfiPgAv8lRaFr4M7yEzrK9KEqow.', 1, NULL),
(3, '122', 'Ropi', 'jambi', '28737', '$2y$10$RfbBa6zVjfMXDTf1178xEOsdMUjJsmt1F9mJCmPyIJzhuKpEz0ubm', 1, NULL);

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
(3, 'Senin', '1'),
(4, 'Selasa', '2'),
(5, 'Rabu', '3');

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
(4, '10.00-12.40', 3, 2, 'T12');

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
(1, 'A01', 1, 'K01'),
(2, 'A02', 1, 'K02');

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
(1, 'Programming', 3, 1, 'True', 'TEORI', 'MK01', 1, NULL),
(2, 'Pemrograman', 3, 1, 'True', 'TEORI', 'MK02', 1, NULL),
(3, 'CRM', 3, 1, 'True', 'TEORI', 'MK03', 1, NULL);

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
(1, 1, 1, 1, 1, 1, 1, 40, 2),
(8, 3, 3, 1, 1, 1, 1, 80, 0),
(9, 2, 1, 2, 1, 1, 1, 80, 0),
(10, 3, 1, 1, 1, 1, 1, 90, 0);

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
(1, 'Sistem Informasi', '1'),
(2, 'Sastra Informatika', '2');

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
(1, 'A001', 100, 'TEORI', 1, 9, 'R02'),
(2, 'A002', 100, 'TEORI', 1, 7, 'R01');

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
(1, 'I', 1, '1'),
(8, 'III', 1, '3');

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
(1, 'Ganjil'),
(2, 'Genap');

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
(1, '2021-2022'),
(3, '2020-2021');

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
-- Dumping data for table `waktu_tidak_bersedia`
--

INSERT INTO `waktu_tidak_bersedia` (`id`, `id_dosen`, `id_hari`, `id_jam`) VALUES
(2, 1, 3, 1);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hari`
--
ALTER TABLE `hari`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jadwalkuliah`
--
ALTER TABLE `jadwalkuliah`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jam`
--
ALTER TABLE `jam`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jam2`
--
ALTER TABLE `jam2`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `matakuliah`
--
ALTER TABLE `matakuliah`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengampu`
--
ALTER TABLE `pengampu`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `riwayat_penjadwalan`
--
ALTER TABLE `riwayat_penjadwalan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ruang`
--
ALTER TABLE `ruang`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
