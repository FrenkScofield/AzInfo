CREATE TABLE `mod_url_url` (
  `url_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` text COLLATE utf8_bin,
  `dil` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `ts` bigint(20) DEFAULT NULL,
  `tarih_duzenleme` date DEFAULT NULL,
  `tur` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `baslik` text COLLATE utf8_bin,
  `yonlendir` text COLLATE utf8_bin,
  `resim` text COLLATE utf8_bin,
  `aciklama` text COLLATE utf8_bin,
  `kelimeler` text COLLATE utf8_bin,
  `tags` text COLLATE utf8_bin,
  PRIMARY KEY (`url_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
