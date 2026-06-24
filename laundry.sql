-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 18, 2026 at 02:12 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` bigint UNSIGNED NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', '$2y$12$WHun8h5UKUnjpA1gRhmhaucUj5JJpXjix37Va8bf3Dy8hIOSiy4la');

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id_layanan` bigint UNSIGNED NOT NULL,
  `id_admin` bigint UNSIGNED NOT NULL,
  `nama_layanan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` double NOT NULL,
  `jenis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`id_layanan`, `id_admin`, `nama_layanan`, `harga`, `jenis`) VALUES
(1, 1, 'Reguler (2 hari)', 5000, 'Kiloan'),
(2, 1, 'Kilat (24 jam)', 8000, 'Kiloan'),
(3, 1, 'Express (12 jam)', 10000, 'Kiloan'),
(4, 1, 'Express (6 jam)', 15000, 'Kiloan'),
(5, 1, 'Jaket', 8000, 'Satuan'),
(6, 1, 'Jas', 20000, 'Satuan'),
(7, 1, 'Almamater', 10000, 'Satuan'),
(8, 1, 'kemeja', 5000, 'Satuan'),
(9, 1, 'Bed Cover', 25000, 'Pakaian Berat'),
(10, 1, 'Selimut', 10000, 'Pakaian Berat'),
(11, 1, 'Sprei', 9000, 'Pakaian Berat'),
(12, 1, 'Bantal', 15000, 'Khusus'),
(13, 1, 'Sepatu Reguler', 25000, 'Khusus'),
(14, 1, 'Sepatu Reguler (Putih)', 30000, 'Khusus'),
(15, 1, 'Sepatu Kilat', 35000, 'Khusus'),
(16, 1, 'Sepatu Kilat (Putih)', 40000, 'Khusus'),
(17, 1, 'Boneka Kecil', 15000, 'Khusus'),
(18, 1, 'Boneka Sedang', 35000, 'Khusus'),
(19, 1, 'Boneka Besar', 50000, 'Khusus'),
(20, 1, 'Tas', 15000, 'Khusus'),
(21, 1, 'Tas Carrier', 35000, 'Khusus'),
(22, 1, 'Karpet', 35000, 'Khusus'),
(23, 1, 'Cuci Kering', 4000, 'Tambahan'),
(24, 1, 'Setrika', 4000, 'Tambahan');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_12_02_153425_create_admin_table', 1),
(2, '2025_12_02_153535_create_pelanggan_table', 1),
(3, '2025_12_02_153629_create_layanan_table', 1),
(4, '2025_12_02_153714_create_pesanan_table', 1),
(5, '2025_12_02_153752_create_promoengine_table', 1),
(6, '2025_12_02_155057_create_sessions_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `progres_kg` decimal(8,2) NOT NULL DEFAULT '0.00',
  `bonus` tinyint(1) NOT NULL DEFAULT '0',
  `bonus_terakhir` datetime DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `password`, `no_hp`, `alamat`, `progres_kg`, `bonus`, `bonus_terakhir`, `remember_token`, `email`, `google_id`) VALUES
(1, 'zeino', '$2y$12$3kFKodXaG36QKSj39oebeuLki09rsxGqmQdtFYd/hAqDHlXTEefla', '+62895343020667', 'yk', 2.00, 1, NULL, 'U2nZ5QHQcMJDlFTxwv3hghsuI5YUs4bQJUeK6Rf2oNdJdpnRPUdHTqa4OUbk', NULL, NULL),
(2, 'reza', '$2y$12$iCN6z4MLgFZzZQXagReMROwne4H8ska8TYsj49oUXYhGy358vxgga', '+6289347623', 'yk', 0.00, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` bigint UNSIGNED NOT NULL,
  `id_pelanggan` bigint UNSIGNED NOT NULL,
  `id_layanan` bigint UNSIGNED NOT NULL,
  `berat` double DEFAULT NULL,
  `total_harga` double DEFAULT NULL,
  `status_pesanan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `snap_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_pesan` date NOT NULL,
  `metode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_bayar` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_pelanggan`, `id_layanan`, `berat`, `total_harga`, `status_pesanan`, `snap_token`, `tanggal_pesan`, `metode`, `jumlah_bayar`) VALUES
(1, 1, 1, 10, 45000, 'Selesai', 'b12a431b-06cb-4c7e-a43d-4814a9af5422', '2026-01-13', 'Antar Jemput', 45000),
(2, 1, 1, 10, 45000, 'Diproses', 'fcc4f4ae-ce6e-49ed-8440-3a16627e0421', '2026-01-15', 'Antar Jemput', 45000);

-- --------------------------------------------------------

--
-- Table structure for table `promoengine`
--

CREATE TABLE `promoengine` (
  `id_promo` bigint UNSIGNED NOT NULL,
  `id_pelanggan` bigint UNSIGNED NOT NULL,
  `id_admin` bigint UNSIGNED NOT NULL,
  `berat` double DEFAULT NULL,
  `hargaPerKg` double DEFAULT NULL,
  `hasilTagihan` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('VqFvo5BPzZxXWSHdEkzKKft7daqdo7UUoRHWR7gk', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTmdIYWRuS1ZxRmdyNWw1OHk1R2UyWHpLVXpjR3dxQmdodXJadlNMZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yaXdheWF0IjtzOjU6InJvdXRlIjtzOjc6InJpd2F5YXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1768444804);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `admin_username_unique` (`username`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id_layanan`),
  ADD KEY `layanan_id_admin_foreign` (`id_admin`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `pesanan_id_pelanggan_foreign` (`id_pelanggan`),
  ADD KEY `pesanan_id_layanan_foreign` (`id_layanan`);

--
-- Indexes for table `promoengine`
--
ALTER TABLE `promoengine`
  ADD PRIMARY KEY (`id_promo`),
  ADD KEY `promoengine_id_pelanggan_foreign` (`id_pelanggan`),
  ADD KEY `promoengine_id_admin_foreign` (`id_admin`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id_layanan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `promoengine`
--
ALTER TABLE `promoengine`
  MODIFY `id_promo` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `layanan`
--
ALTER TABLE `layanan`
  ADD CONSTRAINT `layanan_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_id_layanan_foreign` FOREIGN KEY (`id_layanan`) REFERENCES `layanan` (`id_layanan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pesanan_id_pelanggan_foreign` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `promoengine`
--
ALTER TABLE `promoengine`
  ADD CONSTRAINT `promoengine_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `promoengine_id_pelanggan_foreign` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
