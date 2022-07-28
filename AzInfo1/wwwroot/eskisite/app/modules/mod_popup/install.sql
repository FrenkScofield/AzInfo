CREATE TABLE `mod_popup_popup` (
  `popup_id` int(10) unsigned NOT NULL AUTO_INCREMENT,

  `aktif` enum('0','1') DEFAULT NULL,
  `baslik` text,
  `sira` int(11) DEFAULT NULL,
  `dil` varchar(2) DEFAULT NULL,
  `resim` text,
  `link` text,
  `bas_tarih` date DEFAULT NULL,
  `bit_tarih` date DEFAULT NULL,
  PRIMARY KEY (`popup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

