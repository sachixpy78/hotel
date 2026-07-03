-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2026 at 06:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `level` enum('admin','resepsionis','tamu') NOT NULL,
  `status` enum('on','off','blokir') NOT NULL DEFAULT 'on',
  `login_attempts` int(11) NOT NULL DEFAULT 0,
  `otp` varchar(6) DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `username`, `password`, `gambar`, `alamat`, `no_telp`, `level`, `status`, `login_attempts`, `otp`, `otp_expires_at`, `created_at`, `updated_at`) VALUES
(1, 'akaridmonkey@gmail.com', 'ayam', 'ayam123', 'profiles/k75t6lOl4km2m1N3iWwxfLkiERrxTu32Z1sKHHN5.jpg', 'dsfdfdc', '6281513442182', 'admin', 'on', 0, NULL, NULL, NULL, '2026-04-27 03:00:22'),
(2, 'ayam@gmail.com', 'ayu', '$2y$12$8L7X6DjNKGKx7PRflDS0LulI3GRLnbXhDpc3GRJli2yWS./S.qmY6', 'profiles/1775180981_Cuplikan layar 2024-09-20 132137.png', 'bfajba', '6281513442182', 'tamu', 'off', 0, NULL, NULL, '2026-04-02 18:49:42', '2026-04-02 18:49:42'),
(3, 'kuku@gmail.com', 'kuku', '$2y$12$ce4VB71LuLNN7/OSbWJbru.RXiy1I7RgIL2jAIG2XcQShmMOxfac2', 'profiles/1775181211_Cuplikan layar 2024-09-20 132101.png', 'vjsnjkfs', '6281513442182', 'tamu', 'off', 0, NULL, NULL, '2026-04-02 18:53:31', '2026-04-02 18:53:31'),
(4, 'huhu@gmail.com', 'hdjhdchjds', 'ayam123', NULL, 'dsvsssd', '084263546', 'tamu', 'on', 0, NULL, NULL, NULL, NULL),
(5, 'akaridonkey@gmail.com', 'bjbjhb', '$2y$12$ulsb.xdWqFO3Ckm1Ta3hU.6mwv8stDcCwpm1/CUG3c/Wdbb3jNMPG', 'logo.jpg', 'csvs', '08786786', 'tamu', 'on', 0, NULL, NULL, '2026-04-03 10:58:36', '2026-04-03 10:58:36'),
(6, 'akarionkey@gmail.com', 'jnqjk', '$2y$12$.MoX0QRTadt7H0uzfB6w.uSwOMp.wg9G.QPMkZWZzKqVtZLOzV2xK', 'logo.jpg', 'hbahcbah', '08616635761', 'resepsionis', 'on', 0, NULL, NULL, '2026-04-03 11:12:59', '2026-04-06 00:30:24'),
(7, 'huhuj@gmail.com', 'jgvgvj', '$2y$12$Cpk93kT88UQTQoYwgD3Mv.9QZCdm2003webmkT81AuGggrRaombmW', 'logo.jpg', 'vhjjh', '0878764782', 'resepsionis', 'on', 0, NULL, NULL, '2026-04-04 10:01:32', '2026-04-05 18:05:54'),
(8, 'akaka@gmail.com', 'gghgu', 'ayam123', 'profiles/yYPCM4eVzeuvo6LSfQcs5OBCJXWdoBTXjwxzcPl0.gif', 'rtftf', '6285645456', 'resepsionis', 'on', 0, NULL, NULL, '2026-04-05 18:12:30', '2026-04-24 03:58:41'),
(9, 'hehe@gmail.com', 'Fitri', '888888', 'profiles/e2sgHw8HMp0zAwJb8b2rO8ukxP414kC9XkgYGM9K.png', 'ftftf', '5675765675', 'resepsionis', 'on', 0, NULL, NULL, '2026-04-05 23:47:37', '2026-04-24 02:45:50'),
(10, 'akaey@gmail.com', '767867', 'yuyu123', 'logo.jpg', 'gvgvg', '9867678678', 'resepsionis', 'off', 0, NULL, NULL, '2026-04-06 00:08:08', '2026-04-06 00:08:08'),
(11, 'akonkey@gmail.com', 'Fitrijh', 'ayam123', 'profiles/9J9WFsVPEAPpsKUhgCEtZp0X0gdilX2FWMnWSUXR.jpg', 'bsdbj', '08151342182', 'tamu', 'on', 0, NULL, NULL, '2026-04-06 06:57:20', '2026-04-09 02:08:35'),
(12, 'henny@gmail.com', 'hennyy', 'ayam123', 'profiles/4bO1Ih2wRAPCCFE2J4NgQ22IAlDhqQEEH9YGuP2I.png', 'sfdsfaf', '0876565645', 'tamu', 'on', 0, NULL, NULL, '2026-04-08 18:28:29', '2026-04-08 18:34:55'),
(13, 'elos@gmail.com', 'elos', 'elos123', 'logo.jpg', 'hyuu', '081513442182', 'resepsionis', 'on', 0, '655752', '2026-04-27 02:54:07', '2026-04-27 02:40:39', '2026-04-27 02:47:01'),
(14, 'putrimarsyanda0328@gmail.com', 'putrimarsyanda0328@gmail.com', 'yuyun123', 'logo.jpg', 'hjjh', '081513442182', 'tamu', 'on', 0, NULL, NULL, '2026-04-27 02:54:53', '2026-04-27 02:59:26'),
(16, 'elzard@gmail.com', 'elzard', 'el123', 'profiles/jsR8Ek2ADR3WSI0Ok5eWQ3dvyYbwS86T5tgevOfs.png', 'ggjhjhjh', '081513442182', 'resepsionis', 'on', 0, NULL, NULL, '2026-04-27 03:04:51', '2026-04-28 06:14:26');

-- --------------------------------------------------------

--
-- Table structure for table `kamar`
--

CREATE TABLE `kamar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_kamar` varchar(255) NOT NULL,
  `id_tipe_kamar` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('tersedia','dibersihkan','rusak','terisi') NOT NULL DEFAULT 'tersedia',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kamar`
--

INSERT INTO `kamar` (`id`, `nomor_kamar`, `id_tipe_kamar`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(9, '101', 11, 'tersedia', 'enak', '2026-04-20 00:08:18', '2026-04-24 03:56:07'),
(11, '103', 11, 'tersedia', NULL, '2026-04-20 00:08:47', '2026-04-28 06:15:09'),
(12, '104', 11, 'tersedia', NULL, '2026-04-20 00:09:47', '2026-04-20 00:09:47'),
(13, '105', 11, 'tersedia', NULL, '2026-04-20 00:10:15', '2026-04-22 05:28:09'),
(15, '109', 12, 'tersedia', 'wifi wifi', '2026-04-24 03:59:16', '2026-04-24 03:59:16'),
(16, '1010', 12, 'tersedia', 'bhhdbkd', '2026-04-28 06:15:45', '2026-04-28 06:15:45');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_15_084928_create_personal_access_tokens_table', 1),
(5, '2026_04_01_044228_create_admin_table', 2),
(6, '2026_04_01_044802_create_admin_table', 3),
(7, '2026_04_05_044344_create_tipe_kamar_table', 4),
(8, '2026_04_05_044345_create_kamar_table', 4),
(9, '2026_04_05_060703_add_foto_and_bed_type_to_tipe_kamar_table', 5),
(10, '2026_04_06_030456_create_notifications_table', 6),
(11, '2026_04_07_100514_create_pemesanan_table', 7),
(12, '2026_04_07_100543_create_pembayaran_table', 7),
(13, '2026_04_07_131455_create_pemesanan_table', 8),
(14, '2026_04_07_131516_create_pembayaran_table', 8),
(15, '2026_04_07_154829_pemesanan', 9),
(16, '2026_04_07_163419_create_pemesanan_table', 10),
(17, '2026_04_07_163448_create_pembayaran_table', 10),
(18, '2026_04_08_184459_add_qr_code_to_pemesanan_table', 11),
(19, '2026_04_08_191248_add_nama_pemesan_to_pemesanan_table', 12),
(20, '2026_04_21_165507_add_jam_terlambat_to_pemesanan_table', 13),
(21, '2026_04_21_185052_add_verified_by_to_pemesanan_table', 14);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `message`, `type`, `user_id`, `user_name`, `user_email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Resepsionis Baru Mendaftar', 'Fitri telah mendaftar sebagai resepsionis. Aktivasi akun di User Management.', 'new_resepsionis', 9, 'Fitri', 'akakey@gmail.com', 'unread', '2026-04-05 23:47:38', '2026-04-05 23:47:38'),
(2, 'Resepsionis Baru Mendaftar', '767867 telah mendaftar sebagai resepsionis. Aktivasi akun di User Management.', 'new_resepsionis', 10, '767867', 'akaey@gmail.com', 'unread', '2026-04-06 00:08:08', '2026-04-06 00:08:08');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pemesanan_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `metode` enum('transfer','tunai') NOT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `status` enum('pending','verified','failed') NOT NULL DEFAULT 'pending',
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `pemesanan_id`, `jumlah`, `metode`, `bukti_transfer`, `status`, `verified_by`, `catatan`, `verified_at`, `created_at`, `updated_at`) VALUES
(61, 74, 900000.00, 'transfer', 'bukti-transfer/bukti_1776843486_INV202604220001.jpeg', 'verified', 8, NULL, '2026-04-22 14:39:08', '2026-04-22 07:36:46', '2026-04-22 07:39:08'),
(62, 75, 900000.00, 'transfer', 'bukti-transfer/bukti_1776974897_INV202604240001.png', 'verified', 8, NULL, '2026-04-24 03:08:53', '2026-04-23 20:07:45', '2026-04-23 20:08:53'),
(63, 76, 900000.00, 'transfer', 'bukti-transfer/bukti_1777258969_INV202604270001.jpeg', 'verified', 16, NULL, '2026-04-27 10:09:22', '2026-04-27 03:02:20', '2026-04-27 03:09:22');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_pemesanan` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama_pemesan` varchar(25) NOT NULL,
  `tipe_kamar_id` bigint(20) UNSIGNED NOT NULL,
  `room_number` varchar(50) DEFAULT NULL,
  `jumlah_kamar` int(11) NOT NULL DEFAULT 1,
  `check_in` date NOT NULL,
  `waktu_checkin_aktual` datetime DEFAULT NULL,
  `check_out` date NOT NULL,
  `waktu_checkout_aktual` datetime DEFAULT NULL,
  `jumlah_malam` int(11) NOT NULL,
  `harga_per_malam` decimal(12,2) NOT NULL,
  `total_harga` decimal(12,2) NOT NULL,
  `status` enum('menunggu_pembayaran','menunggu_verifikasi','dibayar','check_in','check_out','batal') DEFAULT NULL,
  `metode_pembayaran` enum('transfer','tunai') DEFAULT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `qr_code` varchar(25) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `denda_keterlambatan` decimal(12,2) DEFAULT 0.00,
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `jam_terlambat` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `nomor_pemesanan`, `user_id`, `nama_pemesan`, `tipe_kamar_id`, `room_number`, `jumlah_kamar`, `check_in`, `waktu_checkin_aktual`, `check_out`, `waktu_checkout_aktual`, `jumlah_malam`, `harga_per_malam`, `total_harga`, `status`, `metode_pembayaran`, `bukti_transfer`, `catatan`, `qr_code`, `created_at`, `updated_at`, `denda_keterlambatan`, `verified_by`, `jam_terlambat`) VALUES
(74, 'INV202604220001', 12, 'hennyy', 11, '101', 1, '2026-04-22', '2026-04-22 00:00:00', '2026-04-23', '2026-04-23 13:01:37', 1, 900000.00, 900000.00, 'check_out', 'transfer', 'bukti-transfer/bukti_1776843486_INV202604220001.jpeg', NULL, NULL, '2026-04-22 07:36:46', '2026-04-23 06:01:37', 51354.30, 9, 1),
(75, 'INV202604240001', 12, 'hennyy', 11, '101', 1, '2026-04-24', '2026-04-24 00:00:00', '2026-04-25', '2026-04-24 10:45:58', 1, 900000.00, 900000.00, 'check_out', 'transfer', 'bukti-transfer/bukti_1776974897_INV202604240001.png', NULL, NULL, '2026-04-23 20:07:43', '2026-04-24 03:45:58', 0.00, 8, 0),
(76, 'INV202604270001', 14, 'putri', 11, '103', 1, '2026-04-27', '2026-04-27 00:00:00', '2026-04-28', '2026-04-28 13:10:57', 1, 900000.00, 900000.00, 'check_out', 'transfer', 'bukti-transfer/bukti_1777258969_INV202604270001.jpeg', 'ggv', NULL, '2026-04-27 03:02:20', '2026-04-28 06:10:57', 59125.41, 16, 1);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Admin', 1, 'auth_token', '1461ca595f32dec95e8a6aa957ac4226798dd86a561d8f94b84591444961ef89', '[\"*\"]', NULL, NULL, '2026-04-02 18:36:37', '2026-04-02 18:36:37'),
(2, 'App\\Models\\Admin', 1, 'auth_token', '50c174daabfbdbca4ab8ff6fbb44901ebe59e25ffab7b0d1f3eb934579bf3272', '[\"*\"]', '2026-04-03 13:12:07', NULL, '2026-04-02 18:50:33', '2026-04-03 13:12:07'),
(3, 'App\\Models\\Admin', 1, 'auth_token', '473a370b50e0309e9d4e6e0bf0eb482fe3e33962139653d03041778ef49c39f8', '[\"*\"]', NULL, NULL, '2026-04-03 00:10:54', '2026-04-03 00:10:54'),
(4, 'App\\Models\\Admin', 1, 'auth_token', '96a9281040cda199e681ae098a475b7f49ac6c62dbb6217e6086c3c009e4ae82', '[\"*\"]', NULL, NULL, '2026-04-03 00:15:41', '2026-04-03 00:15:41'),
(5, 'App\\Models\\Admin', 1, 'auth_token', '128ebd24629e5e89a53892271f7f239bc760253fa4650848ae20b7f4e13ce0e3', '[\"*\"]', NULL, NULL, '2026-04-03 00:15:43', '2026-04-03 00:15:43'),
(6, 'App\\Models\\Admin', 1, 'auth_token', '35cc340a7d4ab75023092090bca7b9c8f29fb6c4d89d848930b2c23d06d2a8fd', '[\"*\"]', NULL, NULL, '2026-04-03 10:29:51', '2026-04-03 10:29:51'),
(7, 'App\\Models\\Admin', 1, 'auth_token', '87fdfc3df5ad54352d0b2a128ff4651ab05a7a641a10c690f4b193f143f05fbf', '[\"*\"]', NULL, NULL, '2026-04-03 10:44:42', '2026-04-03 10:44:42'),
(8, 'App\\Models\\Admin', 6, 'auth_token', '42d596273b9762e85763a72eced244a872a6e53b3bf5a567c8143b485fa617a1', '[\"*\"]', NULL, NULL, '2026-04-03 11:13:56', '2026-04-03 11:13:56'),
(9, 'App\\Models\\Admin', 6, 'auth_token', '3f17a6d3c316d84cec837a064e0d26036a6ed8bfef880528f1f556894bb923e4', '[\"*\"]', NULL, NULL, '2026-04-03 12:04:41', '2026-04-03 12:04:41'),
(10, 'App\\Models\\Admin', 1, 'auth_token', 'bb64c09a2900715b8d85a7e598d7f344f43ccbaba05c8e5d22da8f7228c46b92', '[\"*\"]', NULL, NULL, '2026-04-03 12:53:40', '2026-04-03 12:53:40'),
(11, 'App\\Models\\Admin', 1, 'auth_token', '6c3c91566eccde748c0b805352618ac482d539ba262a4ddb63c49901f3b01648', '[\"*\"]', NULL, NULL, '2026-04-03 12:54:11', '2026-04-03 12:54:11'),
(12, 'App\\Models\\Admin', 1, 'auth_token', 'fbc537111dcab191fa03888a6f3ccc1eac1c5ad63aef701b8e29f673e03ad083', '[\"*\"]', '2026-04-03 15:21:46', NULL, '2026-04-03 14:23:37', '2026-04-03 15:21:46'),
(13, 'App\\Models\\Admin', 1, 'auth_token', '69419ee74c2fece08f903560434f43237ca44058091e5ed07fd4da74ea311588', '[\"*\"]', '2026-04-04 22:46:02', NULL, '2026-04-04 20:42:50', '2026-04-04 22:46:02'),
(14, 'App\\Models\\Admin', 1, 'auth_token', 'd9fa709130e5350382484983d68edd9d7c0ca3d4e598feb662559d927d3a8d46', '[\"*\"]', '2026-04-04 23:02:54', NULL, '2026-04-04 23:02:48', '2026-04-04 23:02:54'),
(15, 'App\\Models\\Admin', 1, 'auth_token', 'c0629eb5d1e911f7fc4ed168663edebbb917cf90b54e420fb5e85dfa36d161ba', '[\"*\"]', '2026-04-04 23:04:28', NULL, '2026-04-04 23:03:52', '2026-04-04 23:04:28'),
(16, 'App\\Models\\Admin', 1, 'auth_token', '0399a398a07f2d99c0a6755ce949d5aadd2874f1b161b12619628b90de513a8b', '[\"*\"]', '2026-04-05 17:59:54', NULL, '2026-04-05 17:55:05', '2026-04-05 17:59:54'),
(17, 'App\\Models\\Admin', 1, 'auth_token', 'd4120d70696ed438702c4755461d24534ba4627ad9b54a62ab18a637877d52f4', '[\"*\"]', NULL, NULL, '2026-04-05 18:07:48', '2026-04-05 18:07:48'),
(18, 'App\\Models\\Admin', 1, 'auth_token', 'f419d071dae8d7ad313de07790deb99df9c87b4d2b563e524131c9f91c4848ef', '[\"*\"]', NULL, NULL, '2026-04-05 18:11:17', '2026-04-05 18:11:17'),
(19, 'App\\Models\\Admin', 1, 'auth_token', '04f45eb869a023c4832420df128a49db218ea40650b9d47b2fd0d6bcb568701c', '[\"*\"]', NULL, NULL, '2026-04-06 00:36:44', '2026-04-06 00:36:44'),
(20, 'App\\Models\\Admin', 11, 'auth_token', '86325c2378cb56fb6b137e278d30da5843f1ad32469baf4033603f820ee1b54f', '[\"*\"]', NULL, NULL, '2026-04-06 06:58:37', '2026-04-06 06:58:37'),
(21, 'App\\Models\\Admin', 1, 'auth_token', 'b72d04f5bb7639e4e6dc5f9caf5d05756794426c47851a8a51e400f78cf894bd', '[\"*\"]', NULL, NULL, '2026-04-07 02:55:42', '2026-04-07 02:55:42'),
(22, 'App\\Models\\Admin', 11, 'auth_token', 'df69a3ed1ea2a643f12f9bb299557a90f80d05efb3ecf56780fd23d336598916', '[\"*\"]', NULL, NULL, '2026-04-07 03:44:30', '2026-04-07 03:44:30'),
(23, 'App\\Models\\Admin', 11, 'auth_token', 'a9063e51c3dc04455e477416775ee82241f092f5479eb387b5337d6804c4b58c', '[\"*\"]', '2026-04-08 01:50:32', NULL, '2026-04-07 06:49:29', '2026-04-08 01:50:32'),
(24, 'App\\Models\\Admin', 1, 'auth_token', '3b3841b478cd9c450d7699b53ab438ddec16c2fac7a0224fb9ca5990b78b23fa', '[\"*\"]', '2026-04-08 02:28:02', NULL, '2026-04-08 02:05:03', '2026-04-08 02:28:02'),
(25, 'App\\Models\\Admin', 11, 'auth_token', 'ad5c2283192c9158536d2869e9d08b7b806cb54e2b4d63020756429f1800ce51', '[\"*\"]', '2026-04-08 02:30:14', NULL, '2026-04-08 02:28:40', '2026-04-08 02:30:14'),
(26, 'App\\Models\\Admin', 1, 'auth_token', '9796c2d5a39d8ba8de08aa988b0cabf5dfb0bb95a00e6a7b3392451694fdb8ef', '[\"*\"]', '2026-04-08 02:32:51', NULL, '2026-04-08 02:30:48', '2026-04-08 02:32:51'),
(27, 'App\\Models\\Admin', 11, 'auth_token', '77e8781d3e398ef509253d8a4a0397b54ba003234ea62aa0c6539d4bed571cd2', '[\"*\"]', '2026-04-08 02:36:14', NULL, '2026-04-08 02:33:09', '2026-04-08 02:36:14'),
(28, 'App\\Models\\Admin', 1, 'auth_token', '5c20a500a6fdba7eee7baa2418126516e267033b0a71212cde71c3aae4762f16', '[\"*\"]', '2026-04-08 02:37:40', NULL, '2026-04-08 02:36:59', '2026-04-08 02:37:40'),
(29, 'App\\Models\\Admin', 11, 'auth_token', 'c3fc92f50523eddc498c24a7796e35ed2ae96c6533c88ed46519ccb7d550530f', '[\"*\"]', '2026-04-08 14:13:36', NULL, '2026-04-08 02:41:33', '2026-04-08 14:13:36'),
(30, 'App\\Models\\Admin', 9, 'auth_token', '0c89dbf7162eddbe8e584752d7bd3bcdf9fb90031b879df0cccb886322c68203', '[\"*\"]', '2026-04-08 18:22:25', NULL, '2026-04-08 14:18:47', '2026-04-08 18:22:25'),
(31, 'App\\Models\\Admin', 1, 'auth_token', '889faad0fd7a962ecf76489035a178d80929d4262619a7a4ea9c583547e90ef7', '[\"*\"]', '2026-04-09 01:38:47', NULL, '2026-04-08 18:18:14', '2026-04-09 01:38:47'),
(32, 'App\\Models\\Admin', 11, 'auth_token', '8139fb946d271f8054714bd1669a16f8acc55caca3ffd8975c39769a55317b51', '[\"*\"]', '2026-04-09 20:19:07', NULL, '2026-04-08 18:18:48', '2026-04-09 20:19:07'),
(33, 'App\\Models\\Admin', 11, 'auth_token', '4c4580163e8d7aaecc7370af155d39b863af6d5f5488ddffdc43b0852691ea78', '[\"*\"]', '2026-04-08 20:08:35', NULL, '2026-04-08 18:25:31', '2026-04-08 20:08:35'),
(34, 'App\\Models\\Admin', 12, 'auth_token', 'c6a7ba9308d1c5ba3fa9f9dfe73e4f5a2020e9a196478d5b220df33968231c44', '[\"*\"]', '2026-04-08 20:09:16', NULL, '2026-04-08 18:29:06', '2026-04-08 20:09:16'),
(35, 'App\\Models\\Admin', 11, 'auth_token', 'fd9588743ca33bac0ec092494377cfe618590cb52cd4aa1168153655021a6a30', '[\"*\"]', '2026-04-09 21:17:44', NULL, '2026-04-09 01:53:15', '2026-04-09 21:17:44'),
(36, 'App\\Models\\Admin', 1, 'auth_token', '4cf547951eb1959f0082aeca1598ccffcea437a984fd74eb91042f38b71664a7', '[\"*\"]', NULL, NULL, '2026-04-09 02:09:39', '2026-04-09 02:09:39'),
(37, 'App\\Models\\Admin', 1, 'auth_token', '90c9af96f278a25d2a1fb1cf2342297e1e6d1c92ffa8470d57cf420bca7a106c', '[\"*\"]', NULL, NULL, '2026-04-14 18:33:44', '2026-04-14 18:33:44'),
(38, 'App\\Models\\Admin', 9, 'auth_token', 'd9793a6984059d8cf62ec91425cd3c1585e811d16e2fed71288c8e5541cb9f78', '[\"*\"]', '2026-04-16 20:04:02', NULL, '2026-04-14 18:54:39', '2026-04-16 20:04:02'),
(39, 'App\\Models\\Admin', 9, 'auth_token', 'f4e663d7fecf49edeb1de6125797c22b4a174e0bc6aa8c4adb3c509321d6bec6', '[\"*\"]', '2026-04-16 22:53:59', NULL, '2026-04-14 19:21:19', '2026-04-16 22:53:59'),
(40, 'App\\Models\\Admin', 1, 'auth_token', '02ee033090cc8bdeb4bc32294085eba84d3b4d14d402bef05125f10681ded696', '[\"*\"]', NULL, NULL, '2026-04-14 20:28:37', '2026-04-14 20:28:37'),
(41, 'App\\Models\\Admin', 12, 'auth_token', 'cad517852097bcf762813a5b3a16bb196c48e16173d7840c7d61363010283b18', '[\"*\"]', '2026-04-14 21:52:23', NULL, '2026-04-14 21:46:51', '2026-04-14 21:52:23'),
(42, 'App\\Models\\Admin', 12, 'auth_token', '2ec84230bc9ad56880b7157081c75b709d1446aa84d744f7b19b2cd25724e513', '[\"*\"]', '2026-04-17 06:49:07', NULL, '2026-04-14 22:44:18', '2026-04-17 06:49:07'),
(43, 'App\\Models\\Admin', 1, 'auth_token', 'b0f83c12403b0ebce8cbfd1614d7ddb5b281987878e62b0dfd26a94cd78ad085', '[\"*\"]', '2026-04-17 00:26:35', NULL, '2026-04-16 08:34:22', '2026-04-17 00:26:35'),
(44, 'App\\Models\\Admin', 9, 'auth_token', 'bd49194e9fa7faba7e42a42494565dc7f2b2f10e4b1ef0228f75d325dfb4e1d4', '[\"*\"]', '2026-04-17 06:49:24', NULL, '2026-04-16 22:54:34', '2026-04-17 06:49:24'),
(45, 'App\\Models\\Admin', 1, 'auth_token', '3a145c3582f70add2105db6b8589d5c1984a835805de13ce56aa413cfba43d6e', '[\"*\"]', NULL, NULL, '2026-04-17 00:52:18', '2026-04-17 00:52:18'),
(46, 'App\\Models\\Admin', 1, 'auth_token', 'c9d737161d37cc7427b1106ac06d29fe197f73f5fb417566db327257edbf0569', '[\"*\"]', '2026-04-17 06:56:16', NULL, '2026-04-17 00:53:36', '2026-04-17 06:56:16'),
(47, 'App\\Models\\Admin', 1, 'auth_token', '17f0bcb775e995df3feedeb5d66ec6bb8eb7d955947677ac704d88528beab3ad', '[\"*\"]', '2026-04-20 10:17:27', NULL, '2026-04-17 07:01:15', '2026-04-20 10:17:27'),
(48, 'App\\Models\\Admin', 9, 'auth_token', 'bdaeb5c45243ac78e2f79c4b637e37e0f5bb6eb3becfb11fa8dcb8013f410878', '[\"*\"]', '2026-04-17 07:02:41', NULL, '2026-04-17 07:02:29', '2026-04-17 07:02:41'),
(49, 'App\\Models\\Admin', 9, 'auth_token', '1d85a689974b8fe6d0d15e30b5b44a0d337a2cfb78fbd7fde6182b2683a2c3ea', '[\"*\"]', '2026-04-17 08:10:58', NULL, '2026-04-17 08:10:53', '2026-04-17 08:10:58'),
(50, 'App\\Models\\Admin', 9, 'auth_token', 'b3589846c519b0edc5857d179c75816fa081ab910eb583b6eaf6545b01de8c11', '[\"*\"]', '2026-04-17 08:16:29', NULL, '2026-04-17 08:16:25', '2026-04-17 08:16:29'),
(51, 'App\\Models\\Admin', 9, 'auth_token', '7f705fb2081d0b5d6883db12862ae13c441edb80dd3c166bcc6a989d0fe87c23', '[\"*\"]', '2026-04-21 11:10:38', NULL, '2026-04-17 08:33:45', '2026-04-21 11:10:38'),
(52, 'App\\Models\\Admin', 12, 'auth_token', 'ea5c7ca1b2d7db163ba8188dcd8b07a47b0358584102452c5fe72ed24d09ba8b', '[\"*\"]', '2026-04-27 02:41:11', NULL, '2026-04-17 10:12:21', '2026-04-27 02:41:11'),
(53, 'App\\Models\\Admin', 1, 'auth_token', '26be3e35dc37a2e75f8ec13512cf191d133b0d98d8517b6a29a64145c26af27f', '[\"*\"]', '2026-04-17 10:45:42', NULL, '2026-04-17 10:45:36', '2026-04-17 10:45:42'),
(54, 'App\\Models\\Admin', 12, 'auth_token', '2e7aeb34815df8eacb98277591fdb41ef0b2622a8c554b8841eb3048ed279815', '[\"*\"]', '2026-04-27 02:39:34', NULL, '2026-04-19 23:54:25', '2026-04-27 02:39:34'),
(55, 'App\\Models\\Admin', 1, 'auth_token', 'dcc766cc7d97aed7367d407edf96d03cb776182fa93c2417a5359306fbea0c07', '[\"*\"]', '2026-04-24 02:56:28', NULL, '2026-04-20 00:48:16', '2026-04-24 02:56:28'),
(56, 'App\\Models\\Admin', 9, 'auth_token', '1a0680e9b7d8b6018bb1e111d07451f81693029e533e11073ae6062445035f70', '[\"*\"]', '2026-04-23 00:11:05', NULL, '2026-04-21 11:11:16', '2026-04-23 00:11:05'),
(57, 'App\\Models\\Admin', 9, 'auth_token', 'c27b325d8c14ed5ad5a4bce3079a5ff7f1b88bde00220bc60803ccf7b45f3717', '[\"*\"]', '2026-04-25 06:01:36', NULL, '2026-04-21 17:29:49', '2026-04-25 06:01:36'),
(58, 'App\\Models\\Admin', 9, 'auth_token', 'b6b442aca915eef9b615df11a98c15e7746ba135624c34d57f6dff326915dec7', '[\"*\"]', '2026-04-22 04:17:41', NULL, '2026-04-25 06:02:27', '2026-04-22 04:17:41'),
(59, 'App\\Models\\Admin', 9, 'auth_token', '70d6e7d63753a813d63699bc470d04bfdfdb463c4ab4af44095107a5345bfa87', '[\"*\"]', '2026-04-22 07:34:44', NULL, '2026-04-22 04:22:30', '2026-04-22 07:34:44'),
(60, 'App\\Models\\Admin', 8, 'auth_token', '3a53a1b3c923a7e6caa0c4d23f647297c1a3829a91dd6b13b57a2f288727ef07', '[\"*\"]', '2026-04-27 02:39:33', NULL, '2026-04-22 07:38:47', '2026-04-27 02:39:33'),
(61, 'App\\Models\\Admin', 1, 'auth_token', '01a73a4b30eb2e98efedb2b7ca45ee003db94501ce7c96449206fb5f7fb42a29', '[\"*\"]', NULL, NULL, '2026-04-27 02:41:18', '2026-04-27 02:41:18'),
(62, 'App\\Models\\Admin', 13, 'auth_token', 'f05425f471d91741a3926431755f27163ccdd9dfff405b88b0bb4343238d225e', '[\"*\"]', '2026-04-27 02:51:11', NULL, '2026-04-27 02:47:01', '2026-04-27 02:51:11'),
(63, 'App\\Models\\Admin', 1, 'auth_token', '5c138430e417a3753f323f5fdbd8de9a4f742649663a2df70b45e84b206b579c', '[\"*\"]', NULL, NULL, '2026-04-27 02:55:06', '2026-04-27 02:55:06'),
(64, 'App\\Models\\Admin', 14, 'auth_token', 'f13a6bcdae4f756642524482db2dbc6241af657f7c54f29a22919620fa81847d', '[\"*\"]', '2026-04-27 03:03:18', NULL, '2026-04-27 03:01:18', '2026-04-27 03:03:18'),
(65, 'App\\Models\\Admin', 1, 'auth_token', 'a33611a152438820bd073abbad4459a0bf16cb83324fd92bb73d4c586ac0bd5b', '[\"*\"]', NULL, NULL, '2026-04-27 03:05:02', '2026-04-27 03:05:02'),
(66, 'App\\Models\\Admin', 16, 'auth_token', '7157abf9e55b677135afd4b0558f0ea4599fda3e6fc1e453d72c494ea323859a', '[\"*\"]', '2026-04-28 08:57:10', NULL, '2026-04-27 03:08:41', '2026-04-28 08:57:10');

-- --------------------------------------------------------

--
-- Table structure for table `tipe_kamar`
--

CREATE TABLE `tipe_kamar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `harga_per_malam` decimal(12,2) NOT NULL,
  `fasilitas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipe_tempat_tidur` enum('King','Queen','Twin','Single','Double','Suite') DEFAULT NULL,
  `tersedia` tinyint(1) NOT NULL DEFAULT 1,
  `stok` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tipe_kamar`
--

INSERT INTO `tipe_kamar` (`id`, `nama`, `foto`, `harga_per_malam`, `fasilitas`, `created_at`, `updated_at`, `tipe_tempat_tidur`, `tersedia`, `stok`) VALUES
(11, 'deluxe', 'room-types/1775791528_ChatGPT Image 9 Feb 2026, 12.58.05.png', 900000.00, 'wifi ac tv pool', '2026-04-09 20:25:09', '2026-04-28 06:15:09', 'Single', 1, 6),
(12, 'regular', 'room-types/1776448489_WhatsApp Image 2026-03-02 at 07.26.48.jpeg', 50000.00, 'wifi  wireless', '2026-04-17 10:54:51', '2026-04-24 03:44:07', 'Single', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_email_unique` (`email`);

--
-- Indexes for table `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kamar_nomor_kamar_unique` (`nomor_kamar`),
  ADD KEY `kamar_id_tipe_kamar_foreign` (`id_tipe_kamar`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_pemesanan_id_foreign` (`pemesanan_id`),
  ADD KEY `pembayaran_verified_by_foreign` (`verified_by`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pemesanan_nomor_pemesanan_unique` (`nomor_pemesanan`),
  ADD KEY `pemesanan_user_id_foreign` (`user_id`),
  ADD KEY `pemesanan_tipe_kamar_id_foreign` (`tipe_kamar_id`),
  ADD KEY `pemesanan_verified_by_foreign` (`verified_by`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `tipe_kamar`
--
ALTER TABLE `tipe_kamar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `kamar`
--
ALTER TABLE `kamar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `tipe_kamar`
--
ALTER TABLE `tipe_kamar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kamar`
--
ALTER TABLE `kamar`
  ADD CONSTRAINT `kamar_id_tipe_kamar_foreign` FOREIGN KEY (`id_tipe_kamar`) REFERENCES `tipe_kamar` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_pemesanan_id_foreign` FOREIGN KEY (`pemesanan_id`) REFERENCES `pemesanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembayaran_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `admin` (`id`);

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_tipe_kamar_id_foreign` FOREIGN KEY (`tipe_kamar_id`) REFERENCES `tipe_kamar` (`id`),
  ADD CONSTRAINT `pemesanan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pemesanan_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `admin` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
