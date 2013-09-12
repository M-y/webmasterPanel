-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 12 Eyl 2013, 12:53:09
-- Sunucu sürümü: 5.5.32-0ubuntu0.13.04.1
-- PHP Sürümü: 5.4.9-4ubuntu2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `webmasterPanel`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayarlar`
--

CREATE TABLE IF NOT EXISTS `ayarlar` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `ad` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `veri` longblob NOT NULL,
  PRIMARY KEY (`no`),
  UNIQUE KEY `ad` (`ad`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cron`
--

CREATE TABLE IF NOT EXISTS `cron` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `modul` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sonCalisma` int(11) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=3 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
