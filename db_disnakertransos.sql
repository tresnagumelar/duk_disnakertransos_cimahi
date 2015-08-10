/*
Navicat MySQL Data Transfer

Source Server         : Local Pisan
Source Server Version : 50615
Source Host           : 127.0.0.1:3306
Source Database       : db_disnakertransos

Target Server Type    : MYSQL
Target Server Version : 50615
File Encoding         : 65001

Date: 2015-08-10 09:02:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for r_agama
-- ----------------------------
DROP TABLE IF EXISTS `r_agama`;
CREATE TABLE `r_agama` (
  `kd_agama` char(2) NOT NULL,
  `nama_agama` varchar(10) NOT NULL,
  PRIMARY KEY (`kd_agama`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of r_agama
-- ----------------------------
INSERT INTO `r_agama` VALUES ('01', 'Islam');
INSERT INTO `r_agama` VALUES ('02', 'Kristen');
INSERT INTO `r_agama` VALUES ('03', 'Al-Jancuki');

-- ----------------------------
-- Table structure for r_jabatan
-- ----------------------------
DROP TABLE IF EXISTS `r_jabatan`;
CREATE TABLE `r_jabatan` (
  `kd_jabatan` char(2) NOT NULL,
  `nama_jabatan` varchar(50) NOT NULL,
  PRIMARY KEY (`kd_jabatan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of r_jabatan
-- ----------------------------

-- ----------------------------
-- Table structure for r_pangkat
-- ----------------------------
DROP TABLE IF EXISTS `r_pangkat`;
CREATE TABLE `r_pangkat` (
  `kd_pangkat` char(2) NOT NULL,
  `nama_pangkat` varchar(10) NOT NULL,
  PRIMARY KEY (`kd_pangkat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of r_pangkat
-- ----------------------------

-- ----------------------------
-- Table structure for t_identitas
-- ----------------------------
DROP TABLE IF EXISTS `t_identitas`;
CREATE TABLE `t_identitas` (
  `foto` varchar(50) DEFAULT NULL,
  `nip` varchar(23) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `jenis_kelamin` char(1) DEFAULT NULL,
  `tempat_lahir` varchar(25) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `agama` char(1) DEFAULT NULL,
  `pangkat_gol` char(1) DEFAULT NULL,
  `pangkat_tmt` date DEFAULT NULL,
  `jabatan_nama` char(2) DEFAULT NULL,
  `jabatan_tmt` date DEFAULT NULL,
  `masa_kerja` int(4) DEFAULT NULL,
  `masa_kerjakes` int(4) DEFAULT NULL,
  PRIMARY KEY (`nip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_identitas
-- ----------------------------

-- ----------------------------
-- Table structure for t_latjab
-- ----------------------------
DROP TABLE IF EXISTS `t_latjab`;
CREATE TABLE `t_latjab` (
  `id_urut` int(6) NOT NULL,
  `nip` varchar(23) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `jumlah_jam` int(4) DEFAULT NULL,
  PRIMARY KEY (`id_urut`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_latjab
-- ----------------------------

-- ----------------------------
-- Table structure for t_pendidikan
-- ----------------------------
DROP TABLE IF EXISTS `t_pendidikan`;
CREATE TABLE `t_pendidikan` (
  `id_urut` int(6) NOT NULL,
  `nip` varchar(23) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `lembaga` varchar(50) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `strata` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`id_urut`),
  KEY `nip` (`nip`),
  CONSTRAINT `nip` FOREIGN KEY (`nip`) REFERENCES `t_identitas` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_pendidikan
-- ----------------------------
