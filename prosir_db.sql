-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2025 at 07:20 AM
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
-- Database: `prosir_db`
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
  `level` enum('super_admin','kasir') NOT NULL,
  `status` enum('on','off','blokir') NOT NULL DEFAULT 'on',
  `login_attempts` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `username`, `password`, `gambar`, `level`, `status`, `login_attempts`, `created_at`, `updated_at`) VALUES
(9, 'wuwu@gmail.com', 'ayam', 'ayam', 'profile/1763560414_1763537447_1763440356_71.jpg', 'kasir', 'on', 0, '2025-11-18 20:23:35', '2025-11-25 21:05:27'),
(11, 'joko@gmail.com', 'hujung', 'ayam', 'profile/1764238282_Cuplikan layar 2025-11-25 195517.png', 'super_admin', 'on', 0, NULL, '2025-11-27 03:11:22'),
(12, 'gogok@gmail.com', 'huhu', '123', 'profile/1763537447_1763440356_71.jpg', 'kasir', 'on', 0, '2025-11-19 00:30:48', '2025-11-19 00:31:05'),
(14, 'kolo@gmail.com', 'gutu', 'ayam', 'profile/1764128988_placeholder.jpg', 'kasir', 'on', 0, '2025-11-25 20:49:48', '2025-11-27 18:01:45');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `kategori`, `gambar`, `created_at`, `updated_at`) VALUES
(2, 'jasa', '1764129102_logo.jpg', '2025-11-19 00:45:15', '2025-11-25 20:51:42'),
(5, 'jurumasak', '1764129151_71.jpg', '2025-11-25 20:52:31', '2025-11-25 20:52:31'),
(6, 'jasa bangun rumah', '1764156220_photoboth.png', '2025-11-26 04:23:41', '2025-11-26 04:23:41'),
(8, 'kuli', '1764170008_Cuplikan layar 2024-10-05 113855.png', '2025-11-26 08:13:28', '2025-11-26 08:13:28'),
(9, 'apalah', '1764173200_Cuplikan layar 2024-09-20 132157.png', '2025-11-26 09:06:40', '2025-11-26 09:06:40'),
(10, 'huhu', '1764173220_Cuplikan layar 2024-10-27 213616.png', '2025-11-26 09:07:00', '2025-11-26 09:07:00');

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
(4, '2025_11_15_045406_create_admins_table', 1),
(5, '2025_11_15_045407_create_kategoris_table', 1),
(6, '2025_11_15_045408_create_produks_table', 1),
(7, '2025_11_15_045413_create_transaksis_table', 1),
(8, '2025_11_15_084928_create_personal_access_tokens_table', 2),
(9, '2025_11_21_020047_add_barcode_to_produk_table', 3);

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
(1, 'App\\Models\\Admin', 4, 'auth_token', '44c42b0b649227a1cf74d52ae774988d616871402a72577431fc3d2abdd133a1', '[\"*\"]', NULL, NULL, '2025-11-15 01:51:02', '2025-11-15 01:51:02'),
(2, 'App\\Models\\Admin', 4, 'auth_token', '40470506c7fbc97f2b9425aa344b71f9da4345987a7bcf733bd1de0bcb072437', '[\"*\"]', NULL, NULL, '2025-11-15 04:14:02', '2025-11-15 04:14:02'),
(3, 'App\\Models\\Admin', 4, 'auth_token', '6bfd625cc9c71bc270cfa417c0374793dc8371515b78aaf5f40f388edbec2b48', '[\"*\"]', NULL, NULL, '2025-11-15 04:14:04', '2025-11-15 04:14:04'),
(4, 'App\\Models\\Admin', 4, 'auth_token', 'd90c0a843827cf1e01d49d7386bed4bd71c0aa9b5d5d49a90d79db2e072ed188', '[\"*\"]', NULL, NULL, '2025-11-15 04:36:37', '2025-11-15 04:36:37'),
(5, 'App\\Models\\Admin', 4, 'auth_token', '6daeabb9b7ab95ce8f9f3133fd219369434be8f752bfb4b753ba8f11868b25db', '[\"*\"]', NULL, NULL, '2025-11-15 04:39:43', '2025-11-15 04:39:43'),
(6, 'App\\Models\\Admin', 4, 'auth_token', '2a7b7521852a32d83ef885c9f2d6466f389e6dab5e1ccde80af5d34c51711e3b', '[\"*\"]', NULL, NULL, '2025-11-15 05:03:19', '2025-11-15 05:03:19'),
(7, 'App\\Models\\Admin', 4, 'auth_token', '7c0ca1b61be8f9f6855e739e560a0cf5e314dc3eb7a0fac2746411edb0914e3f', '[\"*\"]', NULL, NULL, '2025-11-15 05:08:16', '2025-11-15 05:08:16'),
(8, 'App\\Models\\Admin', 4, 'auth_token', '8a324f848302a2be26816bdd62adec46127756ae1cd5968efcececeab080f882', '[\"*\"]', NULL, NULL, '2025-11-15 05:11:40', '2025-11-15 05:11:40'),
(9, 'App\\Models\\Admin', 4, 'auth_token', 'd0622b6834e1652e1eb00186310dec829a72f41ace571600c32c24d8b9b4ecc6', '[\"*\"]', NULL, NULL, '2025-11-16 17:30:45', '2025-11-16 17:30:45'),
(10, 'App\\Models\\Admin', 4, 'auth_token', '369cecb781d48115e8e47f6746d8d50047a1d260d592ef5e3815aceed8288ffb', '[\"*\"]', NULL, NULL, '2025-11-16 17:30:49', '2025-11-16 17:30:49'),
(11, 'App\\Models\\Admin', 4, 'auth_token', 'd357ce791f1361ce55242a8e870ed67ff1781a5e583f0784396b1f1e1de9fe72', '[\"*\"]', NULL, NULL, '2025-11-16 17:56:01', '2025-11-16 17:56:01'),
(12, 'App\\Models\\Admin', 4, 'auth_token', '5aacc05465d3394139005dff492d34cc4c5731fcd1009785b081f16df22a0e0b', '[\"*\"]', NULL, NULL, '2025-11-16 17:56:53', '2025-11-16 17:56:53'),
(13, 'App\\Models\\Admin', 4, 'auth_token', '1ddb9d4b13e8a9c6098ca0c3ac078e62180e0933ef5de3750b2caacba6df3bc1', '[\"*\"]', NULL, NULL, '2025-11-16 17:57:24', '2025-11-16 17:57:24'),
(14, 'App\\Models\\Admin', 4, 'auth_token', '6395e4f9198029af739fb3f41b31d9da63836ba10b53214cc40ff720eefc2d10', '[\"*\"]', NULL, NULL, '2025-11-16 17:57:24', '2025-11-16 17:57:24'),
(15, 'App\\Models\\Admin', 4, 'auth_token', '4cf15846b83a0275930bca9e84e0f08332d2fce852a4719e83bac07455841270', '[\"*\"]', NULL, NULL, '2025-11-16 18:17:00', '2025-11-16 18:17:00'),
(16, 'App\\Models\\Admin', 4, 'auth_token', '5dbd1c527fb7d8c1d77e92b92491b6d051c9746569e4d62a8fbdb9a01d726cbe', '[\"*\"]', NULL, NULL, '2025-11-16 21:05:53', '2025-11-16 21:05:53'),
(17, 'App\\Models\\Admin', 4, 'auth_token', 'f97be7dc11af3207f7aaa6a1a8c2dd900ee2f0853eb3f1d6e6f943546f3cebd8', '[\"*\"]', NULL, NULL, '2025-11-16 21:06:24', '2025-11-16 21:06:24'),
(18, 'App\\Models\\Admin', 4, 'auth_token', '4bc49af805950230dcbbeb584e85191d18f0f0c5f9a7d27ff5583ca8ef2e0f54', '[\"*\"]', NULL, NULL, '2025-11-16 21:13:36', '2025-11-16 21:13:36'),
(19, 'App\\Models\\Admin', 4, 'auth_token', '2c57067f48e059366b466ee4c3a7d89850e41c92fd0e9c270dc2bd983a53591b', '[\"*\"]', NULL, NULL, '2025-11-16 21:18:44', '2025-11-16 21:18:44'),
(20, 'App\\Models\\Admin', 4, 'auth_token', '02abfd56b04a181800bcb5b9bdad5ffebee1587970a8d1a5501614b191ae90ef', '[\"*\"]', NULL, NULL, '2025-11-16 21:35:51', '2025-11-16 21:35:51'),
(21, 'App\\Models\\Admin', 4, 'auth_token', '6155d0c3d4f00ffcaf6472240dfffa03e8577f8f1bf4c45ac08e23623c8abdb7', '[\"*\"]', NULL, NULL, '2025-11-16 21:42:15', '2025-11-16 21:42:15'),
(22, 'App\\Models\\Admin', 4, 'auth_token', '66a7865dc41666868e351876f3229136c14e6eac3dcd09b1e656f40cf52b67df', '[\"*\"]', NULL, NULL, '2025-11-16 23:04:59', '2025-11-16 23:04:59'),
(23, 'App\\Models\\Admin', 4, 'auth_token', 'c90e3bb6c4c18bff9f9033aaf782d324a7d07e743416618405696fb1931dbf6c', '[\"*\"]', NULL, NULL, '2025-11-16 23:05:01', '2025-11-16 23:05:01'),
(24, 'App\\Models\\Admin', 4, 'auth_token', '341399a2652fa99420377fb0d0b0197a913084ffa61197a8ce00973ca3205b17', '[\"*\"]', NULL, NULL, '2025-11-16 23:10:10', '2025-11-16 23:10:10'),
(25, 'App\\Models\\Admin', 4, 'auth_token', '5e23898b4b8aef69984ef30578008f9a1c56b48db6f8309168dd1240a6a84f21', '[\"*\"]', NULL, NULL, '2025-11-16 23:39:55', '2025-11-16 23:39:55'),
(26, 'App\\Models\\Admin', 4, 'auth_token', 'f438d42a4df4af037a49199038aabeee46c96e6db5f5bd9f7c330d7c3d6e2fcb', '[\"*\"]', NULL, NULL, '2025-11-16 23:39:56', '2025-11-16 23:39:56'),
(27, 'App\\Models\\Admin', 4, 'auth_token', '767e4ac22b504997c010d02af4bf999ddcc4f71bbb68d1435e0c1bbb7417cde1', '[\"*\"]', NULL, NULL, '2025-11-16 23:49:46', '2025-11-16 23:49:46'),
(28, 'App\\Models\\Admin', 4, 'auth_token', '0f1bb00f6f1884df8f7be30cc8791e38fbf6a25495def89568dbb2af057064c6', '[\"*\"]', NULL, NULL, '2025-11-16 23:50:16', '2025-11-16 23:50:16'),
(29, 'App\\Models\\Admin', 4, 'auth_token', 'd5c626e3371f97c741ae2b416a354bc511d52c734ed551975d1d749aa1688937', '[\"*\"]', NULL, NULL, '2025-11-16 23:51:12', '2025-11-16 23:51:12'),
(30, 'App\\Models\\Admin', 4, 'auth_token', '7ec79cde1b8fabde281d54ce19744d561d6493bff5914c7baba2f075c9784cd8', '[\"*\"]', NULL, NULL, '2025-11-16 23:52:14', '2025-11-16 23:52:14'),
(31, 'App\\Models\\Admin', 4, 'auth_token', 'bfcc8fb1acebdf8fcdd5424c802dc2da4aa43cc90d04a2a7c501af72fae74020', '[\"*\"]', NULL, NULL, '2025-11-16 23:52:46', '2025-11-16 23:52:46'),
(32, 'App\\Models\\Admin', 4, 'auth_token', 'e5551a690c6897af5d7ee2a70d982ecdc293950275e2951556674668d24b6b35', '[\"*\"]', NULL, NULL, '2025-11-17 00:07:26', '2025-11-17 00:07:26'),
(33, 'App\\Models\\Admin', 4, 'auth_token', 'c6420c7545b9214002dd79f89b08ad140149429441a6cdae9465f87ceef234fb', '[\"*\"]', NULL, NULL, '2025-11-17 00:12:40', '2025-11-17 00:12:40'),
(34, 'App\\Models\\Admin', 4, 'auth_token', '17778e27d9bac6818b4be00d14fbfe3f29b287094536ccdf9b0bcdaac1b67c29', '[\"*\"]', NULL, NULL, '2025-11-17 00:12:59', '2025-11-17 00:12:59'),
(35, 'App\\Models\\Admin', 4, 'auth_token', '75373ea31ba4021129622263fb24b1fc66cbfc8cd73c9a327a8c202b6aee8e1d', '[\"*\"]', NULL, NULL, '2025-11-17 00:15:30', '2025-11-17 00:15:30'),
(36, 'App\\Models\\Admin', 4, 'auth_token', '304e76dc2cc4c38d02893c25771394f03a4c8e2360538d6d90da223588ed87c7', '[\"*\"]', NULL, NULL, '2025-11-17 00:16:01', '2025-11-17 00:16:01'),
(37, 'App\\Models\\Admin', 4, 'auth_token', '754015fb9c74c39da7bf3e42b05292df3c2d4fa9911be1d31c9286e798395eee', '[\"*\"]', NULL, NULL, '2025-11-17 00:18:33', '2025-11-17 00:18:33'),
(38, 'App\\Models\\Admin', 4, 'auth_token', '93e0eb47e0cc6d1b56f8e739d48c1063a4e6cf1e3f088e0d5be7a76db6fa39da', '[\"*\"]', NULL, NULL, '2025-11-17 00:22:51', '2025-11-17 00:22:51'),
(39, 'App\\Models\\Admin', 4, 'auth_token', 'a1933f5e87c54a392da5c06302dbf47848c87663546de2f34a07c24f1a0d50fc', '[\"*\"]', NULL, NULL, '2025-11-17 00:28:57', '2025-11-17 00:28:57'),
(40, 'App\\Models\\Admin', 4, 'auth_token', 'ff45d4233962cc79eaf1fe182396f195f80fbbf438923cd3cd913b1f57de95a6', '[\"*\"]', NULL, NULL, '2025-11-17 00:37:09', '2025-11-17 00:37:09'),
(41, 'App\\Models\\Admin', 4, 'auth_token', '1916eee9ab0db4196d0a3026db1408422d5313acf5c2fef0dc6b8fb49fe97068', '[\"*\"]', NULL, NULL, '2025-11-17 20:08:26', '2025-11-17 20:08:26'),
(42, 'App\\Models\\Admin', 4, 'auth_token', '3ffff377f364c55f1e0ef397aa413dde60fe94379643b235a531009413ea28e8', '[\"*\"]', NULL, NULL, '2025-11-17 20:08:28', '2025-11-17 20:08:28'),
(43, 'App\\Models\\Admin', 4, 'auth_token', '643f882553f97e45e7116c38bc0e34e6629e7715e5266525a9b46df1e9695ee1', '[\"*\"]', NULL, NULL, '2025-11-17 20:08:30', '2025-11-17 20:08:30'),
(44, 'App\\Models\\Admin', 4, 'auth_token', '29c9149cb8e3892c5427b9cffebd17ab25bfe2d1b535062c8c811e9d159e4fca', '[\"*\"]', NULL, NULL, '2025-11-17 20:26:33', '2025-11-17 20:26:33'),
(45, 'App\\Models\\Admin', 4, 'auth_token', 'e88f7a7d77164ab6d10e8e5b2a94363c64e689932ad15ee617b0bfbdc5a3d20d', '[\"*\"]', NULL, NULL, '2025-11-17 20:56:36', '2025-11-17 20:56:36'),
(46, 'App\\Models\\Admin', 4, 'auth_token', '35d2e345df24f23eff7a652c50cca30d31410154e8b703d9bd858104f2f81129', '[\"*\"]', NULL, NULL, '2025-11-17 20:57:24', '2025-11-17 20:57:24'),
(47, 'App\\Models\\Admin', 4, 'auth_token', '9439df2c73cd2eb04f9170b6070f7e5cd5d5faf8eda1ed64aa4230dfbc07c595', '[\"*\"]', NULL, NULL, '2025-11-17 20:57:29', '2025-11-17 20:57:29'),
(48, 'App\\Models\\Admin', 4, 'auth_token', '4246fff4d3e47894be8b335bcefd059f1ab9558eae54e887262952bd42f4c432', '[\"*\"]', NULL, NULL, '2025-11-17 20:57:56', '2025-11-17 20:57:56'),
(49, 'App\\Models\\Admin', 4, 'auth_token', 'b6df3c35b98d60d305b1c15f737b371b231f28f135f69120092bceeb61e82ec6', '[\"*\"]', NULL, NULL, '2025-11-17 20:58:26', '2025-11-17 20:58:26'),
(50, 'App\\Models\\Admin', 4, 'auth_token', '4f1f589d1f63b3288369a5ac75250f7494d1764204ca242a51757c3b1dce8d5a', '[\"*\"]', NULL, NULL, '2025-11-17 21:01:23', '2025-11-17 21:01:23'),
(51, 'App\\Models\\Admin', 4, 'auth_token', '594346e7635e8c8de16ce2861c49936e30f2a4696289c82d73830c1b6781e339', '[\"*\"]', NULL, NULL, '2025-11-17 21:02:10', '2025-11-17 21:02:10'),
(52, 'App\\Models\\Admin', 4, 'auth_token', 'f68d327d787c919a7359f3cc373ea75357a0926a6d2f704d7e878919fa3c271a', '[\"*\"]', NULL, NULL, '2025-11-17 21:40:12', '2025-11-17 21:40:12'),
(53, 'App\\Models\\Admin', 4, 'auth_token', '8e8f5b4552189a3ceb2c0930ab57824b5951fa5be54742f6747c7f9cbcb7a433', '[\"*\"]', NULL, NULL, '2025-11-17 21:40:13', '2025-11-17 21:40:13'),
(54, 'App\\Models\\Admin', 4, 'auth_token', '2a48c57ef0024807306c2e4bd2d4a647fcbf83588751ef72ef6c014a9c234474', '[\"*\"]', NULL, NULL, '2025-11-17 22:04:32', '2025-11-17 22:04:32'),
(55, 'App\\Models\\Admin', 4, 'auth_token', '0c00161669a60560f38c3aae2effba0cad438542b894b98ad994f83fc4759165', '[\"*\"]', NULL, NULL, '2025-11-18 23:25:42', '2025-11-18 23:25:42'),
(56, 'App\\Models\\Admin', 9, 'auth_token', '331095dcb821ad389f9e8eecf7970e9354b6a7fbc3c5f2f1c4ae6c9f63fe5625', '[\"*\"]', NULL, NULL, '2025-11-18 23:38:17', '2025-11-18 23:38:17'),
(57, 'App\\Models\\Admin', 9, 'auth_token', 'abb3ebac4e20c3608e31a798cb07ef960a86ca8eee4140f844d8033cf158de39', '[\"*\"]', NULL, NULL, '2025-11-18 23:51:19', '2025-11-18 23:51:19'),
(58, 'App\\Models\\Admin', 9, 'auth_token', '6962d98f45979a54a01e961261482582e5fdb888332ade2ee3695de61c706d84', '[\"*\"]', NULL, NULL, '2025-11-19 00:54:49', '2025-11-19 00:54:49'),
(59, 'App\\Models\\Admin', 9, 'auth_token', 'dff7d534f43fbdc037ede7221b5b15896b38fcf0b01bfdbc215465b7794097f6', '[\"*\"]', NULL, NULL, '2025-11-19 01:25:51', '2025-11-19 01:25:51'),
(60, 'App\\Models\\Admin', 9, 'auth_token', '97c14b03ec7800b26d7aeff99428a8655e31be2e9950eeba51d910637580ec00', '[\"*\"]', NULL, NULL, '2025-11-19 22:01:16', '2025-11-19 22:01:16'),
(61, 'App\\Models\\Admin', 11, 'auth_token', 'a4eac193129927a89a6a65b2a61d9e8816bbfd6613b9c041cf9dd6ecbbd33e5e', '[\"*\"]', NULL, NULL, '2025-11-20 20:50:32', '2025-11-20 20:50:32'),
(62, 'App\\Models\\Admin', 11, 'auth_token', '23b83fc1a1e71cdd3945ab6c8b2e21a348c965192e4690a575fcbca48707a569', '[\"*\"]', NULL, NULL, '2025-11-20 20:50:33', '2025-11-20 20:50:33'),
(63, 'App\\Models\\Admin', 9, 'auth_token', '051839a1819f8cc15df951cfed751112f401bd4fa3ddd66f09718686a8cc6af4', '[\"*\"]', NULL, NULL, '2025-11-23 23:37:53', '2025-11-23 23:37:53'),
(64, 'App\\Models\\Admin', 9, 'auth_token', 'd04476e116021a7f0d429f997b050b9c48f871b087d6fcb5af4be6fb818791f0', '[\"*\"]', NULL, NULL, '2025-11-24 00:30:59', '2025-11-24 00:30:59'),
(65, 'App\\Models\\Admin', 9, 'auth_token', '93c046a5f402879ab756346ec08379f2502304fcc6ea408b66b8dd3c82f43b73', '[\"*\"]', NULL, NULL, '2025-11-24 00:32:50', '2025-11-24 00:32:50'),
(66, 'App\\Models\\Admin', 9, 'auth_token', '4f80bdbf4660e08aafee8483c42e2cd2fb881d58d53d5f807648ea1f9a20bb85', '[\"*\"]', NULL, NULL, '2025-11-24 00:35:26', '2025-11-24 00:35:26'),
(67, 'App\\Models\\Admin', 9, 'auth_token', 'f3f2803e4fba151b92ab1a338794f9e33c40ec63041da57fc6fad9757c9b9c04', '[\"*\"]', NULL, NULL, '2025-11-25 05:43:27', '2025-11-25 05:43:27'),
(68, 'App\\Models\\Admin', 11, 'auth_token', 'fa254cd167ca3ad4f37b91792907a9ba628333d6cf07c837b88a427ae5e2fdbe', '[\"*\"]', NULL, NULL, '2025-11-25 07:26:19', '2025-11-25 07:26:19'),
(69, 'App\\Models\\Admin', 11, 'auth_token', '3987529e9fd3dc83511d327390e7a25f55f5310c38b4ccb624947555bdb142ea', '[\"*\"]', NULL, NULL, '2025-11-25 07:35:22', '2025-11-25 07:35:22'),
(70, 'App\\Models\\Admin', 11, 'auth_token', '9fa5a6dc5f1d9a978f4f69dc10833ec5cbee0fabd4d2271c1fcbc8584d9052d1', '[\"*\"]', NULL, NULL, '2025-11-25 07:36:26', '2025-11-25 07:36:26'),
(71, 'App\\Models\\Admin', 11, 'auth_token', '89a53651f0cb74780fb36ac0b6369f3365b4ef72481c63e2e0766338a9cf8160', '[\"*\"]', NULL, NULL, '2025-11-25 07:42:06', '2025-11-25 07:42:06'),
(72, 'App\\Models\\Admin', 9, 'auth_token', 'fc20cbe0854c6beacd3a9af31d6b595b110c0c0fb56a9a73ebdf942786ae8c67', '[\"*\"]', NULL, NULL, '2025-11-25 15:55:33', '2025-11-25 15:55:33'),
(73, 'App\\Models\\Admin', 9, 'auth_token', 'd6b5ed3064ac83fa980701d8db350695dad424323ac50b3afc63742190270842', '[\"*\"]', NULL, NULL, '2025-11-25 19:31:53', '2025-11-25 19:31:53'),
(74, 'App\\Models\\Admin', 9, 'auth_token', '0036178f0162be6412110c235181272df22580a2b400669b4d33425420d54d00', '[\"*\"]', NULL, NULL, '2025-11-25 20:29:17', '2025-11-25 20:29:17'),
(75, 'App\\Models\\Admin', 11, 'auth_token', 'de7ce57b0a4326c26a988afba3ab800fe10cd1ecf3136cb3732d901c15d9ccce', '[\"*\"]', NULL, NULL, '2025-11-25 20:41:10', '2025-11-25 20:41:10'),
(76, 'App\\Models\\Admin', 11, 'auth_token', '1b470a8c9d1aa2b31e7c6ad891e6210507d2b1eb3d71d7c39ec40159d9ff2175', '[\"*\"]', NULL, NULL, '2025-11-25 20:44:04', '2025-11-25 20:44:04'),
(77, 'App\\Models\\Admin', 14, 'auth_token', '93780750fc2fd608f5c24df630a10c8b59e760bc7d6b6fd30c17ed810e7b2946', '[\"*\"]', NULL, NULL, '2025-11-25 20:50:58', '2025-11-25 20:50:58'),
(78, 'App\\Models\\Admin', 11, 'auth_token', 'b559a28468c397da8780c720fd0ad70fd8b8681a4b986b1f10d0ea6d3a9ed1bf', '[\"*\"]', NULL, NULL, '2025-11-26 00:31:58', '2025-11-26 00:31:58'),
(79, 'App\\Models\\Admin', 11, 'auth_token', '1fdc719171d9cc5efba76854817750a6b12b9ec0189f56519b7276bde76a9989', '[\"*\"]', NULL, NULL, '2025-11-26 07:31:02', '2025-11-26 07:31:02'),
(80, 'App\\Models\\Admin', 12, 'auth_token', '686afa16b7880065c82f72896b80a641caa876a77259a8a46cbdbea2f87bd76e', '[\"*\"]', NULL, NULL, '2025-11-27 03:38:51', '2025-11-27 03:38:51'),
(81, 'App\\Models\\Admin', 11, 'auth_token', '78b2980fd4b4b94230054bac60ec248d0f9e844dab1021003b272fb58685e4c9', '[\"*\"]', NULL, NULL, '2025-11-27 03:45:55', '2025-11-27 03:45:55'),
(82, 'App\\Models\\Admin', 9, 'auth_token', '43d67b20aace5bcfbd05510ccac312c7ae6b8b90fb2232ef25126a9c25a6e6e9', '[\"*\"]', NULL, NULL, '2025-11-27 04:48:48', '2025-11-27 04:48:48'),
(83, 'App\\Models\\Admin', 11, 'auth_token', '6a1bdff25aa2f8b2ad619806d00671adb39b0b2c9dc128503c25596316b14d39', '[\"*\"]', NULL, NULL, '2025-11-27 04:56:28', '2025-11-27 04:56:28'),
(84, 'App\\Models\\Admin', 12, 'auth_token', '0df2c69f187bc51e52160671b0086bcf6caa7d67810964c7e74f4b1530c29258', '[\"*\"]', NULL, NULL, '2025-11-27 04:57:10', '2025-11-27 04:57:10'),
(85, 'App\\Models\\Admin', 14, 'auth_token', '012a2c9d3fffac618bf7ec49ec422733cce3aadf29ad8681d10d204b386a7f46', '[\"*\"]', NULL, NULL, '2025-11-27 04:58:28', '2025-11-27 04:58:28'),
(86, 'App\\Models\\Admin', 14, 'auth_token', '292e6a26809831b799498746f879b8bb92c0a52ea46b6c2266cd59cbf3ab7d3f', '[\"*\"]', NULL, NULL, '2025-11-27 05:12:21', '2025-11-27 05:12:21'),
(87, 'App\\Models\\Admin', 11, 'auth_token', 'c0ebb56542b539348bd80c7bfc127dbdefc8a2213d98b2da7f301c0acf55d062', '[\"*\"]', NULL, NULL, '2025-11-27 17:46:24', '2025-11-27 17:46:24'),
(88, 'App\\Models\\Admin', 14, 'auth_token', '465b5f46bd3cb56796c8e4b3d0bddd448104c3775be2fa5c2fe57efc70644236', '[\"*\"]', NULL, NULL, '2025-11-27 18:00:21', '2025-11-27 18:00:21'),
(89, 'App\\Models\\Admin', 14, 'auth_token', '291e17eb8f5fb0cd7a6f566f5ef06137a9644de5db5d5176c4ecb10cb14b43fc', '[\"*\"]', NULL, NULL, '2025-11-27 18:01:17', '2025-11-27 18:01:17'),
(90, 'App\\Models\\Admin', 11, 'auth_token', 'c21f786cf4cea38fa4ffa1585dfdfe2bed4444c3147405514cac3f6aa70817f7', '[\"*\"]', NULL, NULL, '2025-11-27 22:48:59', '2025-11-27 22:48:59');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL,
  `modal` varchar(255) NOT NULL,
  `harga_jual` varchar(255) NOT NULL,
  `keuntungan` varchar(255) DEFAULT NULL,
  `fid_kategori` bigint(20) UNSIGNED NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `ketersediaan` enum('tersedia','tidaktersedia') NOT NULL,
  `estimasi` enum('langsung_ambil','7_hari_kerja') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama_produk`, `stok`, `modal`, `harga_jual`, `keuntungan`, `fid_kategori`, `gambar`, `barcode`, `deskripsi`, `ketersediaan`, `estimasi`, `created_at`, `updated_at`) VALUES
(3, 'ayamgoreng', 0, '600', '8000', '7400', 2, '1764162888_Cuplikan layar 2025-11-26 180904.png', 'PROD-F1B5544D', 'enak', 'tersedia', 'langsung_ambil', '2025-11-20 20:44:04', '2025-11-26 06:14:48'),
(8, 'dcd', 0, '333', '3333', '3000', 2, '1764162225_placeholder.jpg', 'PROD-867F49A7', 'dss', 'tidaktersedia', '7_hari_kerja', '2025-11-20 22:28:57', '2025-11-27 21:04:07'),
(12, 'dcdd', 0, '90000', '70000', '-20000', 5, '1764291326_Cuplikan layar 2024-10-05 113855.png', 'PROD-1D21827E', 'enak', 'tersedia', 'langsung_ambil', '2025-11-27 17:55:26', '2025-11-27 17:55:26'),
(13, 'ikangoreng', 5, '5000', '10000', '5000', 2, NULL, 'PROD-068B3558', 'enak', 'tersedia', 'langsung_ambil', '2025-11-27 21:30:50', '2025-11-27 21:30:50');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `total_harga` bigint(20) NOT NULL,
  `fid_admin` bigint(20) UNSIGNED NOT NULL,
  `fid_produk` bigint(20) UNSIGNED NOT NULL,
  `detail` text DEFAULT NULL,
  `total_keuntungan` bigint(20) DEFAULT NULL,
  `tunai` decimal(10,2) NOT NULL DEFAULT 0.00,
  `kembalian` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `tanggal_pembelian`, `total_harga`, `fid_admin`, `fid_produk`, `detail`, `total_keuntungan`, `tunai`, `kembalian`, `created_at`, `updated_at`) VALUES
(59, '2025-11-28', 10000, 14, 13, '[{\"id\":13,\"nama_produk\":\"ikangoreng\",\"harga_jual\":\"10000\",\"modal\":\"5000\",\"gambar\":null,\"quantity\":1,\"total\":\"10000\",\"stok\":6}]', 5000, 0.00, 0.00, '2025-11-27 22:27:18', '2025-11-27 22:27:18'),
(60, '2025-11-28', 10000, 14, 13, '[{\"id\":13,\"nama_produk\":\"ikangoreng\",\"harga_jual\":\"10000\",\"modal\":\"5000\",\"gambar\":null,\"quantity\":1,\"total\":\"10000\",\"stok\":6}]', 5000, 0.00, 0.00, '2025-11-27 22:36:02', '2025-11-27 22:36:02'),
(61, '2025-11-28', 10000, 14, 13, '[{\"id\":13,\"nama_produk\":\"ikangoreng\",\"harga_jual\":\"10000\",\"modal\":\"5000\",\"gambar\":null,\"quantity\":1,\"total\":\"10000\",\"stok\":6}]', 5000, 90000.00, 80000.00, '2025-11-27 22:47:19', '2025-11-27 22:47:19'),
(62, '2025-11-28', 10000, 14, 13, '[{\"id\":13,\"nama_produk\":\"ikangoreng\",\"harga_jual\":\"10000\",\"modal\":\"5000\",\"gambar\":null,\"quantity\":1,\"total\":\"10000\",\"stok\":6}]', 5000, 100000.00, 90000.00, '2025-11-27 22:47:42', '2025-11-27 22:47:42'),
(63, '2025-11-28', 10000, 14, 13, '[{\"id\":13,\"nama_produk\":\"ikangoreng\",\"harga_jual\":\"10000\",\"modal\":\"5000\",\"gambar\":null,\"quantity\":1,\"total\":\"10000\",\"stok\":6}]', 5000, 100000.00, 90000.00, '2025-11-27 22:48:09', '2025-11-27 22:48:09'),
(64, '2025-12-01', 8000, 11, 3, '[{\"id\":3,\"nama_produk\":\"ayamgoreng\",\"harga_jual\":\"8000\",\"modal\":\"600\",\"gambar\":\"profile/1764162888_Cuplikan layar 2025-11-26 180904.png\",\"quantity\":1,\"total\":\"8000\",\"stok\":1}]', 7400, 9000000.00, 8992000.00, '2025-12-01 00:29:36', '2025-12-01 00:29:36');

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
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_fid_kategori_foreign` (`fid_kategori`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_fid_admin_foreign` (`fid_admin`),
  ADD KEY `transaksi_fid_produk_foreign` (`fid_produk`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_fid_kategori_foreign` FOREIGN KEY (`fid_kategori`) REFERENCES `kategori` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_fid_admin_foreign` FOREIGN KEY (`fid_admin`) REFERENCES `admin` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_fid_produk_foreign` FOREIGN KEY (`fid_produk`) REFERENCES `produk` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
