CREATE TABLE `mod_site_ayar` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `baslik_tr` text,
  `baslik_en` text,
  `aciklama_tr` text,
  `aciklama_en` text,
  `kelimeler_tr` text,
  `kelimeler_en` text,
  `mail_host` text,
  `mail_port` text,
  `mail_username` text,
  `mail_password` text,
  `form1_alicilar` text,
  `form2_alicilar` text,
  `form3_alicilar` text,
  `form4_alicilar` text,
  `sosyal_url1` text,
  `sosyal_url2` text,
  `sosyal_url3` text,
  `sosyal_url4` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

