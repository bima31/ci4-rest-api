-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Jun 2021 pada 09.10
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci4`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2021-06-21-030812', 'App\\Database\\Migrations\\Users', 'default', 'App', 1624245843, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `monitoring`
--

CREATE TABLE `monitoring` (
  `id_monitoring` char(10) NOT NULL,
  `tgl_masuk_doc` datetime NOT NULL,
  `nm_perusahaan` varchar(100) NOT NULL,
  `no_tagihan` varchar(100) NOT NULL,
  `nominal` varchar(30) NOT NULL,
  `sts_data` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `monitoring`
--

INSERT INTO `monitoring` (`id_monitoring`, `tgl_masuk_doc`, `nm_perusahaan`, `no_tagihan`, `nominal`, `sts_data`) VALUES
('2021062501', '2021-06-25 16:09:09', 'PT. qwert', 'SK2021445', '2000000', '2'),
('2021062601', '2021-06-26 22:27:16', 'PT. ABC', 'SK2021445', '1000000', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `relasi_monitoring_user`
--

CREATE TABLE `relasi_monitoring_user` (
  `id` int(11) NOT NULL,
  `id_monitoring` char(10) NOT NULL,
  `status_id` varchar(10) NOT NULL,
  `tgl_submit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `relasi_monitoring_user`
--

INSERT INTO `relasi_monitoring_user` (`id`, `id_monitoring`, `status_id`, `tgl_submit`) VALUES
(1, '2021062501', 'admin', '2021-06-25 16:09:09'),
(1, '2021062601', 'admin', '2021-06-26 22:27:16'),
(2, '2021062501', 'guest', '2021-06-25 16:49:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `bidang` varchar(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `bidang`, `username`, `email`, `password`, `status`) VALUES
(1, 'lemes', 'maturidi', 'lemes', 'lemes@gg.com', '$2y$10$NHlJ3AAz2Aoz1Nclk4xfMOp5B.Nn5mBDT6ftSOLs1NnpSH4xlckf2', 1),
(2, 'maturidi', 'mrd', 'maturidi', 'maturidi@gg.com', '$2y$10$i93bcDFoUAmOqShEkNN0XeX3kS7lsH8Pgi8j11qeXO2CytJpGUFr.', 2),
(6, 'maturidi', 'mrd', 'maturidi2', 'maturidi2@gg.com', '$2y$10$TNGiiSWKOAuX2qcqMaYM4.lrc555p4f7DYpfAs0CqF0L4dQejUmAm', 2);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `monitoring`
--
ALTER TABLE `monitoring`
  ADD PRIMARY KEY (`id_monitoring`);

--
-- Indeks untuk tabel `relasi_monitoring_user`
--
ALTER TABLE `relasi_monitoring_user`
  ADD PRIMARY KEY (`id`,`id_monitoring`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
