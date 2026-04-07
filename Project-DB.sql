-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for mbg_report_db
CREATE DATABASE IF NOT EXISTS `mbg_report_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `mbg_report_db`;

-- Dumping structure for table mbg_report_db.gizi_menu
CREATE TABLE IF NOT EXISTS `gizi_menu` (
  `id_gizi` int NOT NULL AUTO_INCREMENT,
  `id_menu` int NOT NULL,
  `kalori` int DEFAULT '0',
  `serat` decimal(10,2) DEFAULT NULL,
  `energi` decimal(10,2) DEFAULT NULL,
  `protein` decimal(10,2) DEFAULT '0.00',
  `karbohidrat` decimal(10,2) DEFAULT '0.00',
  `lemak` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id_gizi`) USING BTREE,
  KEY `id_menu` (`id_menu`) USING BTREE,
  CONSTRAINT `gizi_menu_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu_harian` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table mbg_report_db.menu_harian
CREATE TABLE IF NOT EXISTS `menu_harian` (
  `id_menu` int NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `nama_menu` varchar(255) DEFAULT NULL,
  `foto_url` varchar(255) DEFAULT NULL,
  `riwayat` tinyint(1) DEFAULT '0',
  `id_sekolah` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_menu`),
  KEY `id_sekolah` (`id_sekolah`),
  CONSTRAINT `menu_harian_ibfk_1` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id_sekolah`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table mbg_report_db.pengaduan
CREATE TABLE IF NOT EXISTS `pengaduan` (
  `id_pengaduan` int NOT NULL AUTO_INCREMENT,
  `nama_pelapor` varchar(100) DEFAULT NULL,
  `kontak` varchar(50) DEFAULT NULL,
  `id_sekolah` varchar(255) DEFAULT NULL,
  `isi_pengaduan` text,
  `foto_bukti` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Diproses','Selesai') DEFAULT 'Pending',
  `catatan_petugas` text,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pengaduan`),
  KEY `id_sekolah` (`id_sekolah`),
  CONSTRAINT `pengaduan_ibfk_1` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id_sekolah`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table mbg_report_db.sekolah
CREATE TABLE IF NOT EXISTS `sekolah` (
  `id_sekolah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama_sekolah` varchar(255) DEFAULT NULL,
  `alamat` text,
  `kontak` varchar(50) DEFAULT NULL,
  `koordinat` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_sekolah`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table mbg_report_db.sppg
CREATE TABLE IF NOT EXISTS `sppg` (
  `id_sppg` varchar(50) NOT NULL DEFAULT 'AUTO_INCREMENT',
  `nama_tim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `jabatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `ketua_tim` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `kontak_tim` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `anggota_tim` text,
  `foto_tim` varchar(255) DEFAULT NULL,
  `id_sekolah` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_sppg`) USING BTREE,
  KEY `id_sekolah` (`id_sekolah`),
  CONSTRAINT `sppg_ibfk_1` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id_sekolah`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table mbg_report_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `uid` varchar(100) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `id_sekolah` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`uid`),
  KEY `id_sekolah` (`id_sekolah`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id_sekolah`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
