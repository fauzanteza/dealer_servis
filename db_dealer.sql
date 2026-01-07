-- phpMyAdmin SQL Dump
-- Version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2026 at 03:30 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;
--
-- Database: `db_dealer`
--
-- --------------------------------------------------------
--
-- Table structure for table `tb_motor`
--
CREATE TABLE `tb_motor` (
    `id_motor` int(11) NOT NULL,
    `merk` varchar(50) NOT NULL,
    `tipe` varchar(100) NOT NULL,
    `warna` varchar(50) NOT NULL,
    `harga` decimal(15, 2) NOT NULL,
    `stok` int(11) NOT NULL,
    `foto` varchar(255) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
--
-- Dumping data for table `tb_motor`
--
INSERT INTO `tb_motor` (
        `id_motor`,
        `merk`,
        `tipe`,
        `warna`,
        `harga`,
        `stok`,
        `foto`
    )
VALUES (
        1,
        'Kawasaki',
        'Ninja ZX-25R',
        'Hijau',
        '105000000.00',
        3,
        'kawasaki_ninja.jpg'
    ),
    (
        2,
        'Yamaha',
        'NMAX 155 Connected',
        'Merah',
        '32500000.00',
        5,
        'yamaha_nmax.jpg'
    ),
    (
        3,
        'Honda',
        'BeAT Street',
        'Silver',
        '18500000.00',
        10,
        'honda_beat.jpg'
    ),
    (
        4,
        'Honda',
        'Vario 160 ABS',
        'Hitam Matte',
        '29500000.00',
        7,
        'honda_vario.png'
    );
-- --------------------------------------------------------
--
-- Table structure for table `tb_penjualan`
--
CREATE TABLE `tb_penjualan` (
    `id_penjualan` int(11) NOT NULL,
    `id_motor` int(11) NOT NULL,
    `nama_pembeli` varchar(100) NOT NULL,
    `tanggal` date NOT NULL,
    `jumlah_beli` int(11) NOT NULL,
    `total_harga` decimal(15, 2) NOT NULL,
    `status` varchar(20) DEFAULT 'Pending'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
-- --------------------------------------------------------
--
-- Table structure for table `tb_servis`
--
CREATE TABLE `tb_servis` (
    `id` int(11) NOT NULL,
    `nama_pelanggan` varchar(100) NOT NULL,
    `jenis_motor` varchar(100) NOT NULL,
    `keluhan` text NOT NULL,
    `status` enum('Menunggu', 'Diproses', 'Selesai') NOT NULL DEFAULT 'Menunggu'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
--
-- Dumping data for table `tb_servis`
--
INSERT INTO `tb_servis` (
        `id`,
        `nama_pelanggan`,
        `jenis_motor`,
        `keluhan`,
        `status`
    )
VALUES (
        1,
        'Budi Santoso',
        'Honda Vario 125',
        'Ganti Oli dan Servis Rutin',
        'Selesai'
    ),
    (
        2,
        'Siti Aminah',
        'Yamaha Mio',
        'Mesin bunyi klotok-klotok',
        'Diproses'
    ),
    (
        3,
        'Agus Setiawan',
        'Suzuki Satria FU',
        'Rem depan blong',
        'Menunggu'
    );
--
-- Indexes for dumped tables
--
--
-- Indexes for table `tb_motor`
--
ALTER TABLE `tb_motor`
ADD PRIMARY KEY (`id_motor`);
--
-- Indexes for table `tb_penjualan`
--
ALTER TABLE `tb_penjualan`
ADD PRIMARY KEY (`id_penjualan`);
--
-- Indexes for table `tb_servis`
--
ALTER TABLE `tb_servis`
ADD PRIMARY KEY (`id`);
--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `tb_motor`
--
ALTER TABLE `tb_motor`
MODIFY `id_motor` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 5;
--
-- AUTO_INCREMENT for table `tb_penjualan`
--
ALTER TABLE `tb_penjualan`
MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_servis`
--
ALTER TABLE `tb_servis`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 4;
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;
