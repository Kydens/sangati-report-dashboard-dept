-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2024 at 06:34 AM
-- Server version: 11.2.2-MariaDB
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sangati__database`
--

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_departemen` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`id`, `nama_departemen`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN', '2024-06-05 20:22:55', '2024-06-05 20:22:55'),
(2, 'HRD', '2024-06-05 20:22:55', '2024-06-05 20:22:55'),
(3, 'Purchasing', '2024-06-05 20:22:55', '2024-06-05 20:22:55'),
(4, 'IT', '2024-06-05 20:22:55', '2024-06-05 20:22:55'),
(5, 'Accounting', '2024-06-05 20:22:55', '2024-06-05 20:22:55'),
(6, 'Finance', '2024-06-05 20:22:55', '2024-06-05 20:22:55'),
(7, 'Payroll', '2024-06-05 20:22:55', '2024-06-05 20:22:55'),
(8, 'Operation', '2024-06-05 20:22:55', '2024-06-05 20:22:55');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_terimapinjam_id` bigint(20) UNSIGNED NOT NULL,
  `nama_item` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `report_terimapinjam_id`, `nama_item`, `quantity`, `detail`, `created_at`, `updated_at`) VALUES
(1, 1, 'Testing', 'Testing', NULL, '2024-06-05 20:42:44', '2024-06-05 20:42:44'),
(2, 2, 'Laptop', '1 pcs', 'HP ENVY X360', '2024-06-05 20:43:43', '2024-06-05 20:43:43'),
(3, 2, 'Charger Laptop', '1 pcs', NULL, '2024-06-05 20:43:43', '2024-06-05 20:43:43'),
(4, 3, 'Handphone', '1 pcs', 'Redmi A3 Hitam (SN: 53911/14RY06047)', '2024-06-05 23:39:36', '2024-06-05 23:39:36'),
(5, 4, 'Handphone', '1 pcs', 'Redmi A3 Hitam (SN: 53911/14RY06047)', '2024-06-05 23:46:19', '2024-06-05 23:46:19'),
(6, 4, 'Kartu SIM Telkomsel Prabayar', '1 pcs', 'No: 081324580620', '2024-06-05 23:46:19', '2024-06-05 23:46:19'),
(7, 5, 'Laptop', '1 box', 'Asus Vivobook Abu-abu (SN: R9N0LP020684377)', '2024-06-06 00:24:11', '2024-06-06 00:24:11'),
(8, 6, 'Laptop', '1 box', 'ASUS Vivobook (SN: R9N0LP020684377)', '2024-06-06 00:26:23', '2024-06-06 00:26:23'),
(9, 7, 'Tinta Printer Epson 664', '3 pcs', 'Warna Hitam', '2024-06-06 00:28:53', '2024-06-06 00:28:53'),
(10, 7, 'Tinta Printer Epson 664', '1 pcs', 'Warna Kuning', '2024-06-06 00:28:53', '2024-06-06 00:28:53'),
(11, 8, 'testing', '1pcs', NULL, '2024-06-12 09:06:12', '2024-06-12 09:06:12');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_userit_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_kegiatan` varchar(255) NOT NULL,
  `status` enum('Proses','Done') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(123, '2014_10_12_000000_create_users_table', 1),
(124, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(125, '2019_08_19_000000_create_failed_jobs_table', 1),
(126, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(128, '2024_06_03_062741_create_tanda_terimapinjam_table', 1),
(129, '2024_06_03_062824_create_report_terimapinjam_table', 1),
(130, '2024_06_04_073008_create_departemen_table', 1),
(131, '2024_06_04_080223_create_items_table', 1),
(133, '2024_06_03_062529_create_perusahaan_table', 2),
(134, '2024_06_06_030923_create_roles_table', 3),
(173, '2024_06_10_131047_create_jobs_table', 4);

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
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `perusahaan`
--

INSERT INTO `perusahaan` (`id`, `nama_perusahaan`, `image`, `created_at`, `updated_at`) VALUES
(1, 'PT. Sangati Soerya Sejahtera', 'post-images/sangati.png', NULL, NULL),
(2, 'PT. L&M Systems Indonesia', 'post-images/lmsi.jpg', NULL, NULL),
(3, 'PT. Beberes Rumah Sejahtera', 'post-images/nyaman.jpg', NULL, NULL),
(4, 'PT. Sejahtera Karna Menggoreng', 'post-images/skm.png', NULL, NULL),
(5, 'PT. Main Outdoor', 'post-images/mo.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `report_terimapinjam`
--

CREATE TABLE `report_terimapinjam` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `perusahaan_id` bigint(20) UNSIGNED NOT NULL,
  `departemen_id` bigint(20) UNSIGNED NOT NULL,
  `tanda_terimapinjam_id` bigint(20) UNSIGNED NOT NULL,
  `pengirim` varchar(255) NOT NULL,
  `pengirim_dept_id` bigint(20) UNSIGNED NOT NULL,
  `penerima` varchar(255) NOT NULL,
  `penerima_dept_id` bigint(20) UNSIGNED NOT NULL,
  `terakhir_cetak` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report_terimapinjam`
--

INSERT INTO `report_terimapinjam` (`id`, `perusahaan_id`, `departemen_id`, `tanda_terimapinjam_id`, `pengirim`, `pengirim_dept_id`, `penerima`, `penerima_dept_id`, `terakhir_cetak`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 1, 'Testing-pengirim', 2, 'Testing-penerima', 4, '0000-00-00 00:00:00', '2024-06-05 20:42:44', '2024-06-05 20:42:44'),
(2, 1, 4, 1, 'Regita', 8, 'Andri', 4, '0000-00-00 00:00:00', '2024-06-05 20:43:43', '2024-06-05 20:43:43'),
(3, 4, 4, 1, 'Andri', 4, 'Alana', 8, '0000-00-00 00:00:00', '2024-06-05 23:39:36', '2024-06-05 23:39:36'),
(4, 4, 4, 1, 'Andri', 4, 'Alana', 8, '0000-00-00 00:00:00', '2024-06-05 23:46:19', '2024-06-05 23:46:19'),
(5, 1, 4, 1, 'Andri', 4, 'Ray', 4, '0000-00-00 00:00:00', '2024-06-06 00:24:11', '2024-06-06 00:24:11'),
(6, 1, 4, 1, 'Andri', 4, 'Rey', 4, '0000-00-00 00:00:00', '2024-06-06 00:26:23', '2024-06-06 00:26:23'),
(7, 1, 4, 1, 'Venny', 4, 'Kartika', 7, '2024-06-13 06:18:45', '2024-06-06 00:28:53', '2024-06-13 06:18:45');

-- --------------------------------------------------------

--
-- Table structure for table `report_userit`
--

CREATE TABLE `report_userit` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `user_req_perusahaan_id` bigint(20) UNSIGNED NOT NULL,
  `user_req_departemen_id` bigint(20) UNSIGNED NOT NULL,
  `user_request` varchar(255) NOT NULL,
  `program` varchar(255) NOT NULL,
  `tanggal_pengerjaan` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_role` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `nama_role`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2024-06-06 09:46:24', '2024-06-06 09:46:24'),
(2, 'user', '2024-06-06 09:46:24', '2024-06-06 09:46:24');

-- --------------------------------------------------------

--
-- Table structure for table `tanda_terimapinjam`
--

CREATE TABLE `tanda_terimapinjam` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tanda_terimapinjam`
--

INSERT INTO `tanda_terimapinjam` (`id`, `jenis`, `created_at`, `updated_at`) VALUES
(1, 'Tanda Terima', '2024-06-05 20:22:55', '2024-06-05 20:22:55'),
(2, 'Tanda Pinjam', '2024-06-05 20:22:55', '2024-06-05 20:22:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `roles_id` bigint(20) UNSIGNED NOT NULL DEFAULT 2,
  `perusahaan_id` bigint(20) UNSIGNED NOT NULL,
  `departemen_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `roles_id`, `perusahaan_id`, `departemen_id`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'admin', 'admin@admin.com', NULL, '$2y$12$ErAzDmA5P1/co5aL05Kd.O85OmraDGUTqJNJf7pQOUXLzdBeegoru', NULL, '2024-06-05 20:22:55', '2024-06-05 20:22:55'),
(2, 1, 1, 4, 'venny', 'venny@gmail.com', NULL, '$2y$12$5ETTt3zU7Qzh0WQn9y9IPe3bimsWuzwcDTC4NTOCtB9deAUy7f/9e', NULL, '2024-06-05 20:22:55', '2024-06-05 20:22:55'),
(3, 2, 1, 4, 'zidan', 'zidan@gmail.com', NULL, '$2y$12$9g.nezxx5ciJ2SwMrKnbqOVO87AMNZ6uAM8OLVny/WQye54CjEDn6', NULL, '2024-06-05 20:22:55', '2024-06-05 20:22:55'),
(4, 1, 1, 2, 'nisa', 'nisa@gmail.com', NULL, '$2y$10$D5zomEMU.MpCGRUAP76WNO6wJpF3G0M6ibz5II4eZuiGYqY4FfelC', NULL, NULL, NULL),
(5, 2, 1, 4, 'eddy', 'eddy@gmail.com', NULL, '$2y$10$D5zomEMU.MpCGRUAP76WNO6wJpF3G0M6ibz5II4eZuiGYqY4FfelC', NULL, NULL, NULL),
(6, 2, 1, 4, 'dian', 'dian@gmail.com', NULL, '$2y$12$9g.nezxx5ciJ2SwMrKnbqOVO87AMNZ6uAM8OLVny/WQye54CjEDn6', NULL, '2024-06-13 02:58:20', '2024-06-13 02:58:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
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
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_terimapinjam`
--
ALTER TABLE `report_terimapinjam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_userit`
--
ALTER TABLE `report_userit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tanda_terimapinjam`
--
ALTER TABLE `tanda_terimapinjam`
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
-- AUTO_INCREMENT for table `departemen`
--
ALTER TABLE `departemen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `report_terimapinjam`
--
ALTER TABLE `report_terimapinjam`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `report_userit`
--
ALTER TABLE `report_userit`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tanda_terimapinjam`
--
ALTER TABLE `tanda_terimapinjam`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
