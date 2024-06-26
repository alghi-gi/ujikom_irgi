-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Mar 2020 pada 07.50
-- Versi server: 10.1.31-MariaDB
-- Versi PHP: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundri_v2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail_transaksi` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `qty` double NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail_transaksi`, `id_transaksi`, `id_paket`, `qty`, `keterangan`) VALUES
(5, 1, 4, 6, 'Kaos putih polos 3x, kaos hitam logo Ajax 3x'),
(6, 1, 7, 2, 'Sepatu basket x1 pasang & sepatu snekers x1 pasang'),
(7, 2, 6, 18, 'Jas Hitam x4, Celana hitam x4, Kaos polos putih x4, Selimut corak belang x2, bed cover bunga mawar x3 & Sepatu Fantovel x2'),
(8, 3, 4, 4, 'Kaos Hijau x2, Kaos belang hitam putih x2'),
(9, 3, 7, 1, 'Sepatu snekers x1 pasang'),
(10, 3, 1, 5, 'Jaket Hitam x1, Celana Jeans x1, Celana Pendek pink x3'),
(11, 3, 2, 1, 'Bed Cover Jingga corak hitam'),
(12, 5, 3, 460, 'selimut putih keperluan hotel'),
(13, 5, 2, 460, 'Bed Cover Putih, sama keperluan hotel'),
(14, 6, 1, 2, 'Celana Panjang hitam putih x2'),
(15, 15, 7, 2, 'Sepatu snekers putih x2 pasang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `member`
--

CREATE TABLE `member` (
  `id_member` int(11) NOT NULL,
  `nama_member` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL,
  `no_telepon` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `member`
--

INSERT INTO `member` (`id_member`, `nama_member`, `alamat`, `jenis_kelamin`, `no_telepon`) VALUES
(6, 'Jaya Saputra', 'Jl.Raya Puspiptek, Setu, Tangerang Selatan', 'laki-laki', '085745464664'),
(7, 'Habib Al Huda', 'Perumahan Grand Akasia, Pamulang , Tangerang Selatan', 'laki-laki', '0564879756'),
(8, 'Raihan Aditya', 'Perumahan Puri Serpong 2 blok AE2/05, Setu, Tangerang Selatan', 'laki-laki', '09893498'),
(9, 'Habib reyhan sengar', 'Jl.AMD Bakti jaya pocis No.105, Pamulang, Tangerang Selatan', 'laki-laki', '09893498'),
(11, 'Tsar Ahmad ', 'Komplek Perumahan Dinas BPPT No. 24, Setu, Tangerang Selatan', 'laki-laki', '675676756'),
(12, 'Teggar Rahmotulloh', 'Perumahan Bukit Dago blok E4/09, Parung, Bogor', 'laki-laki', '07877567887'),
(13, 'Muhammad Fikri', 'Gg.Salak, Pamulang, Tangerang Selatan', 'laki-laki', '0897768456371'),
(14, 'Juleha', 'Gg. Salak no.23, Pamulang, Tangerang Selatan', 'perempuan', '099778366488'),
(15, 'Muhammad Raihan ', 'Jl.AMD Bakti jaya pocis No.56, Pamulang, Tangerang Selatan', 'laki-laki', '08977978794'),
(16, 'Alya Talita Shakhi', 'Perumahan Puri Serpong 1 blok D5/07, Seru, Tangerang Selatan', 'perempuan', '098898777645');

-- --------------------------------------------------------

--
-- Struktur dari tabel `outlet`
--

CREATE TABLE `outlet` (
  `id_outlet` int(11) NOT NULL,
  `nama_outlet` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `no_telepon` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `outlet`
--

INSERT INTO `outlet` (`id_outlet`, `nama_outlet`, `alamat`, `no_telepon`) VALUES
(1, 'SlowClean Serpong', 'Jl.Pasar Serpong Ruko no 09, Tangerang Selatan', '087746933036');

-- --------------------------------------------------------

--
-- Struktur dari tabel `paket`
--

CREATE TABLE `paket` (
  `id_paket` int(11) NOT NULL,
  `id_outlet` int(11) NOT NULL,
  `jenis` enum('kiloan','selimut','bed cover','kaos','hemat','sepatu') NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `harga` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `paket`
--

INSERT INTO `paket` (`id_paket`, `id_outlet`, `jenis`, `nama_paket`, `harga`) VALUES
(1, 1, 'kiloan', 'Paket Kiloan', 8000),
(2, 1, 'bed cover', 'Paket Bed Cover', 10000),
(3, 1, 'selimut', 'Paket Selimut', 10000),
(4, 1, 'kaos', 'Paket Kaos', 7500),
(6, 1, 'hemat', 'Paket Hemat', 3000),
(7, 1, 'sepatu', 'Paket Sepatu', 12000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `total_harga_cuci` int(11) NOT NULL,
  `uang_bayar` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `id_member` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `total_harga_cuci`, `uang_bayar`, `kembalian`, `tgl_bayar`, `id_member`, `id_transaksi`) VALUES
(1, 9200000, 10000000, 800000, '2020-03-28', 3, 5),
(2, 75900, 80000, 4100, '2020-03-30', 3, 1),
(3, 26400, 30000, 3600, '2020-03-31', 3, 15);

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat`
--

CREATE TABLE `riwayat` (
  `id_riwayat` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `waktu` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `riwayat`
--

INSERT INTO `riwayat` (`id_riwayat`, `id_user`, `keterangan`, `waktu`) VALUES
(1, 3, 'menambahkan transaksi', '2020-03-28 13:31:58'),
(2, 0, 'meng-hapus transaksi', '2020-03-28 13:32:06'),
(3, 3, 'menambahkan transaksi', '2020-03-28 13:32:49'),
(4, 0, 'meng-hapus transaksi', '2020-03-28 13:33:03'),
(5, 3, 'meng-ubah transaksi', '2020-03-28 13:39:58'),
(6, 3, 'meng-ubah transaksi', '2020-03-28 13:40:10'),
(7, 3, 'meng-ubah transaksi', '2020-03-28 13:40:41'),
(8, 3, 'meng-ubah transaksi', '2020-03-28 13:40:49'),
(9, 3, 'meng-ubah transaksi', '2020-03-28 13:41:42'),
(10, 3, 'meng-ubah transaksi', '2020-03-28 13:42:23'),
(11, 3, 'meng-ubah transaksi', '2020-03-28 13:42:42'),
(12, 3, 'meng-ubah transaksi', '2020-03-28 13:42:51'),
(13, 3, 'menambahkan detail transaksi', '2020-03-28 13:47:22'),
(14, 3, 'menambahkan detail transaksi', '2020-03-28 13:47:54'),
(15, 3, 'meng-hapus Detail transaksi', '2020-03-28 13:49:46'),
(16, 3, 'meng-hapus Detail transaksi', '2020-03-28 13:49:56'),
(17, 3, 'menambahkan detail transaksi', '2020-03-28 13:50:49'),
(18, 3, 'meng-hapus Detail transaksi', '2020-03-28 13:50:57'),
(19, 3, 'menambahkan detail transaksi', '2020-03-28 13:51:28'),
(20, 3, 'meng-hapus Detail transaksi', '2020-03-28 13:51:35'),
(21, 3, 'menambahkan detail transaksi', '2020-03-28 13:52:03'),
(22, 3, 'menambahkan detail transaksi', '2020-03-28 13:53:02'),
(23, 3, 'meng-hapus user', '2020-03-28 13:59:24'),
(24, 3, 'meng-hapus user', '2020-03-28 13:59:42'),
(25, 3, 'meng-update user', '2020-03-28 14:01:47'),
(26, 3, 'meng-update user', '2020-03-28 14:01:58'),
(27, 3, 'menambahkan Pelanggan cuci', '2020-03-28 14:04:53'),
(28, 3, 'meng-hapus pelanggan', '2020-03-28 14:06:27'),
(29, 3, 'meng-ubah pelanggan', '2020-03-28 14:08:15'),
(30, 3, 'meng-ubah pelanggan', '2020-03-28 14:10:02'),
(31, 3, 'meng-ubah pelanggan', '2020-03-28 14:11:40'),
(32, 3, 'meng-ubah pelanggan', '2020-03-28 14:12:05'),
(33, 3, 'meng-ubah pelanggan', '2020-03-28 14:12:36'),
(34, 3, 'meng-ubah pelanggan', '2020-03-28 14:13:02'),
(35, 3, 'meng-ubah pelanggan', '2020-03-28 14:14:09'),
(36, 3, 'meng-ubah pelanggan', '2020-03-28 14:15:26'),
(37, 3, 'meng-ubah pelanggan', '2020-03-28 14:16:01'),
(38, 3, 'meng-ubah pelanggan', '2020-03-28 14:17:17'),
(39, 3, 'meng-ubah pelanggan', '2020-03-28 14:17:49'),
(40, 3, 'menambahkan detail transaksi', '2020-03-28 18:18:10'),
(41, 3, 'meng-ubah transaksi', '2020-03-28 18:18:39'),
(42, 3, 'meng-ubah transaksi', '2020-03-28 18:18:54'),
(43, 3, 'menambahkan detail transaksi', '2020-03-28 18:19:34'),
(44, 3, 'menambahkan detail transaksi', '2020-03-28 18:20:05'),
(45, 3, 'menambahkan detail transaksi', '2020-03-28 18:22:20'),
(46, 3, 'menambahkan detail transaksi', '2020-03-28 18:23:23'),
(47, 3, 'meng-ubah transaksi', '2020-03-28 18:23:56'),
(48, 3, 'menambahkan detail transaksi', '2020-03-28 18:25:41'),
(49, 3, 'menambahkan detail transaksi', '2020-03-28 18:27:04'),
(50, 3, 'meng-ubah transaksi', '2020-03-28 18:27:37'),
(51, 3, 'menambahkan detail transaksi', '2020-03-28 18:28:44'),
(52, 3, 'meng-ubah transaksi', '2020-03-28 18:29:04'),
(53, 3, 'meng-ubah transaksi', '2020-03-28 19:13:45'),
(54, 3, 'menambahkan transaksi', '2020-03-28 19:17:57'),
(55, 3, 'menambahkan Pelanggan cuci', '2020-03-29 08:55:32'),
(56, 3, 'meng-hapus pelanggan', '2020-03-29 08:55:41'),
(57, 3, 'menambahkan Pelanggan cuci', '2020-03-29 08:57:08'),
(58, 3, 'meng-hapus pelanggan', '2020-03-29 08:57:16'),
(59, 3, 'menambahkan Pelanggan cuci', '2020-03-29 08:58:41'),
(60, 3, 'meng-hapus pelanggan', '2020-03-29 08:58:46'),
(61, 3, 'menambahkan Pelanggan cuci', '2020-03-29 08:59:43'),
(62, 3, 'meng-hapus pelanggan', '2020-03-29 08:59:49'),
(63, 3, 'menambahkan Pelanggan cuci', '2020-03-29 09:01:09'),
(64, 3, 'meng-hapus pelanggan', '2020-03-29 09:01:14'),
(65, 3, 'menambahkan Pelanggan cuci', '2020-03-29 09:02:31'),
(66, 3, 'meng-hapus pelanggan', '2020-03-29 09:05:50'),
(67, 3, 'menambahkan Pelanggan cuci', '2020-03-29 14:54:30'),
(68, 3, 'meng-hapus pelanggan', '2020-03-29 14:54:39'),
(69, 3, 'menambahkan Pelanggan cuci', '2020-03-29 14:55:29'),
(70, 3, 'meng-hapus pelanggan', '2020-03-30 11:39:39'),
(71, 3, 'menambahkan Pelanggan cuci', '2020-03-30 11:40:08'),
(72, 3, 'menambahkan Pelanggan cuci', '2020-03-30 11:41:19'),
(73, 3, 'meng-hapus pelanggan', '2020-03-30 11:41:32'),
(74, 3, 'meng-hapus pelanggan', '2020-03-30 11:41:39'),
(75, 3, 'menambahkan Pelanggan cuci', '2020-03-30 11:42:20'),
(76, 3, 'menambahkan Pelanggan cuci', '2020-03-30 11:43:23'),
(77, 3, 'menambahkan Pelanggan cuci', '2020-03-30 11:43:29'),
(78, 3, 'meng-hapus pelanggan', '2020-03-30 11:43:40'),
(79, 3, 'meng-hapus pelanggan', '2020-03-30 11:43:46'),
(80, 3, 'meng-hapus pelanggan', '2020-03-30 11:43:51'),
(81, 3, 'menambahkan Pelanggan cuci', '2020-03-30 11:44:01'),
(82, 3, 'meng-hapus pelanggan', '2020-03-30 12:23:20'),
(83, 3, 'meng-ubah pelanggan', '2020-03-30 12:25:29'),
(84, 3, 'meng-ubah pelanggan', '2020-03-30 12:25:45'),
(85, 3, 'meng-ubah pelanggan', '2020-03-30 12:28:08'),
(86, 3, 'meng-ubah pelanggan', '2020-03-30 12:28:32'),
(87, 3, 'meng-ubah pelanggan', '2020-03-30 12:28:42'),
(88, 3, 'menambahkan paket', '2020-03-30 12:31:09'),
(89, 3, 'meng-hapus paket', '2020-03-30 12:32:39'),
(90, 3, 'meng-hapus paket', '2020-03-30 12:32:57'),
(91, 3, 'menambahkan paket', '2020-03-30 12:33:08'),
(92, 3, 'meng-hapus paket', '2020-03-30 12:33:16'),
(93, 3, 'meng-hapus paket', '2020-03-30 12:34:13'),
(94, 3, 'meng-update paket', '2020-03-30 12:36:01'),
(95, 3, 'meng-update paket', '2020-03-30 12:36:11'),
(96, 3, 'menambahkan transaksi', '2020-03-30 12:40:20'),
(97, 0, 'meng-hapus transaksi', '2020-03-30 12:42:09'),
(98, 3, 'meng-ubah transaksi', '2020-03-30 12:44:27'),
(99, 3, 'meng-ubah transaksi', '2020-03-30 12:44:38'),
(100, 3, 'menambahkan detail transaksi', '2020-03-30 12:48:55'),
(101, 3, 'meng-hapus Detail transaksi', '2020-03-30 12:50:30'),
(102, 3, 'meng-ubah transaksi', '2020-03-30 12:55:23'),
(103, 3, 'meng-update user', '2020-03-30 13:02:38'),
(104, 3, 'meng-update user', '2020-03-30 13:02:47'),
(105, 3, 'meng-hapus user', '2020-03-30 13:03:52'),
(106, 3, 'meng-hapus user', '2020-03-30 15:19:27'),
(107, 3, 'meng-update user', '2020-03-30 15:37:39'),
(108, 3, 'meng-update user', '2020-03-30 17:32:57'),
(109, 3, 'meng-hapus user', '2020-03-30 17:34:47'),
(110, 3, 'menambahkan transaksi', '2020-03-30 20:56:28'),
(111, 3, 'menambahkan detail transaksi', '2020-03-30 21:18:35'),
(112, 3, 'meng-ubah transaksi', '2020-03-30 21:24:43'),
(113, 3, 'meng-ubah transaksi', '2020-03-31 11:39:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_outlet` int(11) NOT NULL,
  `kode_invoice` varchar(100) NOT NULL,
  `id_member` int(11) NOT NULL,
  `tgl` datetime NOT NULL,
  `batas_waktu` datetime NOT NULL,
  `biaya_tambahan` int(11) DEFAULT NULL,
  `diskon` double DEFAULT NULL,
  `pajak` int(11) DEFAULT NULL,
  `status` enum('baru','proses','selesai','diambil') NOT NULL,
  `dibayar` enum('sudah dibayar','belum dibayar') NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_outlet`, `kode_invoice`, `id_member`, `tgl`, `batas_waktu`, `biaya_tambahan`, `diskon`, `pajak`, `status`, `dibayar`, `id_user`, `id_pembayaran`) VALUES
(1, 1, '001', 11, '2020-03-23 00:00:00', '2020-03-25 00:00:00', NULL, 0, 6900, 'diambil', 'sudah dibayar', 3, 0),
(2, 1, '002', 9, '2020-03-23 00:00:00', '2020-03-24 00:00:00', NULL, 0, 5400, 'proses', 'belum dibayar', 3, 0),
(3, 1, '003', 12, '2020-03-25 00:00:00', '2020-03-27 00:00:00', NULL, 9200, 9200, 'selesai', 'belum dibayar', 3, 0),
(5, 1, '004', 13, '2020-03-25 00:00:00', '2020-03-26 00:00:00', NULL, 920000, 920000, 'selesai', 'sudah dibayar', 3, 0),
(6, 1, '005', 14, '2020-03-22 00:00:00', '2020-03-25 00:00:00', NULL, 0, 1600, 'proses', 'belum dibayar', 3, 0),
(14, 1, '006', 16, '2020-03-28 00:00:00', '2020-03-30 00:00:00', NULL, NULL, NULL, 'baru', 'belum dibayar', 3, 0),
(15, 1, '007', 7, '2020-03-25 00:00:00', '2020-03-27 00:00:00', NULL, 0, 2400, 'diambil', 'sudah dibayar', 3, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `id_outlet` int(11) NOT NULL,
  `role` enum('admin','kasir','owner') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `username`, `password`, `id_outlet`, `role`) VALUES
(3, 'muhammad irgi al ghithraf', 'irgi', '$2y$10$kVRd1HJbzqeObi/DyGWkDeGr21l42aks6xVXVlKg3DOUpl30Q/BQO', 1, 'admin'),
(19, 'Anggit zurbergh', 'anggit', '$2y$10$UL33k/VjzO1THVqvYH0tVeoo2KvHJDyjcfpwdH9cok16ivzB5KKpi', 1, 'kasir'),
(21, 'Heru Suharmoko', 'hes', '$2y$10$avG8cdGmPSQHbkbs.s6Zj.yy6e8aie4xtjW1arkpoA3YdQUFoKEZK', 1, 'owner');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail_transaksi`),
  ADD KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `id_paket` (`id_paket`);

--
-- Indeks untuk tabel `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_member`);

--
-- Indeks untuk tabel `outlet`
--
ALTER TABLE `outlet`
  ADD PRIMARY KEY (`id_outlet`);

--
-- Indeks untuk tabel `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id_paket`),
  ADD KEY `id_outlet` (`id_outlet`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_member` (`id_member`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indeks untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`id_riwayat`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_outlet` (`id_outlet`),
  ADD KEY `id_member` (`id_member`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_pembayaran` (`id_pembayaran`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_outlet` (`id_outlet`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `member`
--
ALTER TABLE `member`
  MODIFY `id_member` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `outlet`
--
ALTER TABLE `outlet`
  MODIFY `id_outlet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `paket`
--
ALTER TABLE `paket`
  MODIFY `id_paket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
