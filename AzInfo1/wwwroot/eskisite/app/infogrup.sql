-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `anasayfa_hizmet`;
CREATE TABLE `anasayfa_hizmet` (
  `anasayfa_hizmet_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sira` int(11) DEFAULT NULL,
  `baslik_tr` text,
  `baslik_en` text,
  `baslik_ru` text,
  `yazi_tr` text,
  `yazi_en` text,
  `yazi_ru` text,
  `resim` text,
  PRIMARY KEY (`anasayfa_hizmet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `anasayfa_hizmet` (`anasayfa_hizmet_id`, `sira`, `baslik_tr`, `baslik_en`, `baslik_ru`, `yazi_tr`, `yazi_en`, `yazi_ru`, `resim`) VALUES
(1,	1,	'KOROZYON',	'KOROZYON',	'KOROZYON',	'Soğutma kulelerinde ve Isıtma kazanlarında boruların aşınmasına sebep olan ciddi bir sorundur.',	NULL,	NULL,	'list-item-1.png|'),
(2,	2,	'KOROZYON',	'KOROZYON',	'KOROZYON',	'Soğutma kulelerinde ve Isıtma kazanlarında boruların aşınmasına sebep olan ciddi bir sorundur.',	NULL,	NULL,	'list-item-1.png|'),
(3,	3,	'KOROZYON',	'KOROZYON',	'KOROZYON',	'Soğutma kulelerinde ve Isıtma kazanlarında boruların aşınmasına sebep olan ciddi bir sorundur.',	NULL,	NULL,	'list-item-1.png|'),
(4,	4,	'KOROZYON',	'KOROZYON',	'KOROZYON',	'Soğutma kulelerinde ve Isıtma kazanlarında boruların aşınmasına sebep olan ciddi bir sorundur.',	NULL,	NULL,	'list-item-1.png|');

DROP TABLE IF EXISTS `anasayfa_referans`;
CREATE TABLE `anasayfa_referans` (
  `anasayfa_referans_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sira` int(11) DEFAULT NULL,
  `resim` text,
  PRIMARY KEY (`anasayfa_referans_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `anasayfa_referans` (`anasayfa_referans_id`, `sira`, `resim`) VALUES
(1,	1,	'sutas-logo.png|'),
(2,	2,	'sutas-logo.png|'),
(3,	3,	'sutas-logo.png|'),
(4,	4,	'sutas-logo.png|'),
(5,	5,	'sutas-logo.png|');

DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner` (
  `banner_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sira` int(11) DEFAULT NULL,
  `dil` varchar(2) DEFAULT NULL,
  `resim` text,
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `banner` (`banner_id`, `sira`, `dil`, `resim`) VALUES
(1,	1,	'tr',	'slide-1.jpg|'),
(2,	2,	'tr',	'slide-1.jpg|'),
(3,	1,	'en',	'slide-1.jpg|'),
(4,	1,	'ru',	'slide-1.jpg|');

DROP TABLE IF EXISTS `banner_mobil`;
CREATE TABLE `banner_mobil` (
  `banner_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sira` int(11) DEFAULT NULL,
  `resim` text,
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `banner_mobil` (`banner_id`, `sira`, `resim`) VALUES
(1,	1,	'ozon.jpg|'),
(2,	2,	'ozon.jpg|'),
(3,	3,	'ozon.jpg|');

DROP TABLE IF EXISTS `belge`;
CREATE TABLE `belge` (
  `belge_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bolum` varchar(32) DEFAULT NULL,
  `sira` int(11) DEFAULT NULL,
  `dil` varchar(2) DEFAULT NULL,
  `baslik` text,
  `dosya` text,
  PRIMARY KEY (`belge_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `belge` (`belge_id`, `bolum`, `sira`, `dil`, `baslik`, `dosya`) VALUES
(1,	'belgeler',	1,	'tr',	'Tehlikeli Maddde ve Müstahzarların Etkilenmesinde Kullanılan Tehlike Sembol ve İşaretleri',	NULL),
(2,	'belgeler',	1,	'tr',	'Tehlikeli Maddde ve Müstahzarların Etkilenmesinde Kullanılan Tehlike Sembol ve İşaretleri',	NULL),
(3,	'teknik_belgeler',	1,	'tr',	'Teknik Belge',	NULL),
(4,	'kalite_belgeleri',	1,	'tr',	'Kalite Belgesi',	NULL),
(5,	'sistem_bilgi_formatlari',	1,	'tr',	'Sistem Bilgi Formatı',	NULL);

DROP TABLE IF EXISTS `haber`;
CREATE TABLE `haber` (
  `haber_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tarih` date DEFAULT NULL,
  `baslik_tr` text,
  `baslik_en` text,
  `baslik_ru` text,
  `aciklama_tr` text,
  `aciklama_en` text,
  `aciklama_ru` text,
  `resimler` text,
  PRIMARY KEY (`haber_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `haber` (`haber_id`, `tarih`, `baslik_tr`, `baslik_en`, `baslik_ru`, `aciklama_tr`, `aciklama_en`, `aciklama_ru`, `resimler`) VALUES
(1,	'2017-07-26',	'INFO GROUP 11. Genel Satış Değerlendirme ve Motivasyon Toplantısı',	'INFO GROUP 11. Genel Satış Değerlendirme ve Motivasyon Toplantısı',	'INFO GROUP 11. Genel Satış Değerlendirme ve Motivasyon Toplantısı',	'INFO GROUP 11. Genel Satış Değerlendirme ve Motivasyon Toplantısını Antalya Adalya Elite Otel’de gerçekleştirmiştir. Toplantımıza Sayın Saffet Karpat katılım sağlayarak şirketimizi onore etmiştir.',	NULL,	NULL,	'1.jpg|:1.jpg|');

DROP TABLE IF EXISTS `hizmet`;
CREATE TABLE `hizmet` (
  `hizmet_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sira` int(11) DEFAULT NULL,
  `baslik_tr` text,
  `baslik_en` text,
  `baslik_ru` text,
  `aciklama_tr` text,
  `aciklama_en` text,
  `aciklama_ru` text,
  `resim` text,
  `resimler` text,
  PRIMARY KEY (`hizmet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `hizmet` (`hizmet_id`, `sira`, `baslik_tr`, `baslik_en`, `baslik_ru`, `aciklama_tr`, `aciklama_en`, `aciklama_ru`, `resim`, `resimler`) VALUES
(1,	1,	'SU ŞARTLANDIRMA HİZMETLERİMİZ',	'SU ŞARTLANDIRMA HİZMETLERİMİZ',	'SU ŞARTLANDIRMA HİZMETLERİMİZ',	'Firmaların sorunlarına göre ihtiyacı olan çözümler üretilir ve uygulamaya alınır. Bu çözümler ve cihazlarımızdan dozaj tanklarına kadar özenle kurduğumuz su şartlandırma istasyonlarının fotoğraflarını aşağıda bulabilirsiniz.',	NULL,	NULL,	'services.jpg|',	'services.jpg|:services.jpg|:services.jpg|:services.jpg|:services.jpg|');

DROP TABLE IF EXISTS `kurumsal`;
CREATE TABLE `kurumsal` (
  `kurumsal_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `baslik_tr` text,
  `baslik_en` text,
  `baslik_ru` text,
  `resim` text,
  `yazi_tr` text,
  `yazi_en` text,
  `yazi_ru` text,
  PRIMARY KEY (`kurumsal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `kurumsal` (`kurumsal_id`, `baslik_tr`, `baslik_en`, `baslik_ru`, `resim`, `yazi_tr`, `yazi_en`, `yazi_ru`) VALUES
(1,	'İnfo Group Endüstriyel Dan. ve Tic. A.Ş.',	NULL,	NULL,	'about.jpg|',	'<p>&Uuml;lkemizin &ouml;nemli ve prestijli kuruluşlarını portf&ouml;y&uuml;nde bulunduran INFO GROUP, T&uuml;rkiye&rsquo;de su şartlandırma danışmanlığı konusundaki otoritesini hizmet kalitesi ile rakipsizleştirmektedir.</p>\r\n\r\n<p>INFO GROUP, iş merkezlerinin, alışveriş merkezlerinin, fabrikaların, hastanelerin, &uuml;niversitelerin, otellerin i&ccedil;me-kullanım sularında, ısıtma-soğutma sistemlerinde, buhar kazanlarında, soğutma kulelerinde kullanılan kimyasalları ve kontrol ekipmanlarını s&uuml;rekli ve kaliteli servis hizmeti ile takip ederek m&uuml;şterilerimizin pahalı ekipman yatırımlarını koruyup, verimli &ouml;mr&uuml;n&uuml;n uzun olmasını sağlayarak ekonomiye katkı sağlamayı ama&ccedil; edinmiştir.</p>\r\n\r\n<p>Rakiplerin izlemek zorunda kaldıkları m&uuml;kemmel standartları oluşturan INFO GROUP&rsquo; un pazardaki bu &ouml;nc&uuml; &ccedil;izgisinin ardında, m&uuml;şterileri ile kurduğu g&uuml;&ccedil;l&uuml; iş birliği ve ortak hedefler vardır.</p>\r\n\r\n<p>Yatırımların verimliliği a&ccedil;ısından su şartlandırma danışmanlığı acil ve &ouml;nemli &ccedil;&ouml;z&uuml;m olmasının yanı sıra, &ccedil;evreci y&ouml;ntemlerin, titiz araştırmacılığın ve ihtiyaca &ouml;zel &ccedil;&ouml;z&uuml;mlerin &ouml;nem kazandığı bu &ouml;zel konuda INFO GROUP ger&ccedil;ek bir &ccedil;&ouml;z&uuml;m ortağıdır.</p>',	NULL,	NULL);

DROP TABLE IF EXISTS `mod_admin_email_template`;
CREATE TABLE `mod_admin_email_template` (
  `template_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` text,
  `content` text,
  `order` int(11) DEFAULT '999',
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `mod_admin_user`;
CREATE TABLE `mod_admin_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(40) DEFAULT NULL,
  `email` text,
  `password` varchar(40) DEFAULT NULL,
  `group_id` int(10) unsigned DEFAULT NULL,
  `confirm_status` enum('0','1') DEFAULT '0',
  `signature` text,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mod_admin_user` (`user_id`, `username`, `email`, `password`, `group_id`, `confirm_status`, `signature`) VALUES
(1,	'admin',	NULL,	'd033e22ae348aeb5660fc2140aec35850c4da997',	1,	'1',	NULL);

DROP TABLE IF EXISTS `mod_admin_user_group`;
CREATE TABLE `mod_admin_user_group` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text,
  `demo_mode` enum('0','1') DEFAULT NULL,
  `permissions` longtext,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mod_admin_user_group` (`group_id`, `name`, `demo_mode`, `permissions`) VALUES
(1,	'Admin',	NULL,	'a:9:{i:0;s:35:\"mod_admin/admin_mod_admin_user/list\";i:1;s:35:\"mod_admin/admin_mod_admin_user/edit\";i:2;s:37:\"mod_admin/admin_mod_admin_user/delete\";i:3;s:41:\"mod_admin/admin_mod_admin_user_group/list\";i:4;s:41:\"mod_admin/admin_mod_admin_user_group/edit\";i:5;s:43:\"mod_admin/admin_mod_admin_user_group/delete\";i:6;s:45:\"mod_admin/admin_mod_admin_email_template/list\";i:7;s:45:\"mod_admin/admin_mod_admin_email_template/edit\";i:8;s:47:\"mod_admin/admin_mod_admin_email_template/delete\";}');

DROP TABLE IF EXISTS `mod_lang_dict`;
CREATE TABLE `mod_lang_dict` (
  `word_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` text,
  `tr` text,
  `en` text,
  `ru` text,
  PRIMARY KEY (`word_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mod_lang_dict` (`word_id`, `key`, `tr`, `en`, `ru`) VALUES
(1,	'defaultTitle',	NULL,	NULL,	NULL),
(2,	'rootTitle',	NULL,	NULL,	NULL),
(3,	'404 Page not found',	NULL,	NULL,	NULL),
(4,	'The url you requested is invalid. Please correct the url and try again.',	NULL,	NULL,	NULL),
(5,	'KURUMSAL',	NULL,	NULL,	NULL),
(6,	'HİZMETLER',	NULL,	NULL,	NULL),
(7,	'ÜRÜNLER',	NULL,	NULL,	NULL),
(8,	'ÜRÜNLERİMİZ',	NULL,	NULL,	NULL),
(9,	'NFS\\\'Lİ ÜRÜNLERİMİZ',	NULL,	NULL,	NULL),
(10,	'OZON SİSTEMLERİ',	NULL,	NULL,	NULL),
(11,	'EKİPMANLARIMIZ',	NULL,	NULL,	NULL),
(12,	'BELGELER',	NULL,	NULL,	NULL),
(13,	'SERTİFİKALAR',	NULL,	NULL,	NULL),
(14,	'TEKNİK BELGELER',	NULL,	NULL,	NULL),
(15,	'KALİTE BELGELERİ',	NULL,	NULL,	NULL),
(16,	'SİSTEM BİLGİ FORMATLARI',	NULL,	NULL,	NULL),
(17,	'REFERANSLAR',	NULL,	NULL,	NULL),
(18,	'HABERLER',	NULL,	NULL,	NULL),
(19,	'İLETİŞİM',	NULL,	NULL,	NULL),
(20,	'ANASAYFA',	NULL,	NULL,	NULL),
(21,	'HAKKIMIZDA',	NULL,	NULL,	NULL),
(22,	'Hakkımızda',	NULL,	NULL,	NULL),
(23,	'Anasayfa',	NULL,	NULL,	NULL),
(24,	'HİZMETLERİMİZ',	NULL,	NULL,	NULL),
(25,	'Hizmetlerimiz',	NULL,	NULL,	NULL),
(26,	'Teknik Belgeler',	NULL,	NULL,	NULL),
(27,	'Sertifikalar',	NULL,	NULL,	NULL),
(28,	'Ürünler',	NULL,	NULL,	NULL),
(29,	'Belgeler',	NULL,	NULL,	NULL),
(30,	'Kalite Belgeleri',	NULL,	NULL,	NULL),
(31,	'Sistem Bilgi Formatları',	NULL,	NULL,	NULL),
(32,	'REFERANSLARIMIZ',	NULL,	NULL,	NULL),
(33,	'Referanslarımız',	NULL,	NULL,	NULL),
(34,	'İnsan Kaynakları',	NULL,	NULL,	NULL),
(35,	'Her Hakkı Saklıdır.',	NULL,	NULL,	NULL),
(36,	'İNSAN KAYNAKLARI',	NULL,	NULL,	NULL),
(37,	'İletişim',	NULL,	NULL,	NULL),
(38,	'Haberler',	NULL,	NULL,	NULL),
(39,	'Ürünlerimiz',	NULL,	NULL,	NULL),
(40,	'NFS\\\'li Ürünlerimiz',	NULL,	NULL,	NULL),
(41,	'Ozon Sistemleri',	NULL,	NULL,	NULL),
(42,	'ÜRÜN AÇIKLAMASI',	NULL,	NULL,	NULL),
(43,	'ONLINE SATIŞ',	NULL,	NULL,	NULL),
(44,	'UYGULAMA ALANLARI',	NULL,	NULL,	NULL),
(45,	'YARARLARI',	NULL,	NULL,	NULL),
(46,	'TEKNİK ÖZELLİKLER',	NULL,	NULL,	NULL),
(47,	'TÜMÜ',	NULL,	NULL,	NULL),
(48,	'İNSAN KAYNAKLARI FORMU',	NULL,	NULL,	NULL),
(49,	'Adınız  Soyadınız',	NULL,	NULL,	NULL),
(50,	'E-mail Adresiniz',	NULL,	NULL,	NULL),
(51,	'Telefon Numaranız',	NULL,	NULL,	NULL),
(52,	'Mesajınız',	NULL,	NULL,	NULL),
(53,	'GÖNDER',	NULL,	NULL,	NULL),
(54,	'IP',	NULL,	NULL,	NULL),
(55,	'Ad Soyad',	NULL,	NULL,	NULL),
(56,	'Lütfen Ad Soyad giriniz',	NULL,	NULL,	NULL),
(57,	'E-mail',	NULL,	NULL,	NULL),
(58,	'E-posta alanı gereklidir',	NULL,	NULL,	NULL),
(59,	'Lütfen geçerli bir e-posta adresi giriniz',	NULL,	NULL,	NULL),
(60,	'Telefon',	NULL,	NULL,	NULL),
(61,	'Lütfen Telefon giriniz',	NULL,	NULL,	NULL),
(62,	'Mesaj',	NULL,	NULL,	NULL),
(63,	'İNFO <span>TV</span>',	NULL,	NULL,	NULL),
(64,	'SORUN, ÇÖZÜM',	NULL,	NULL,	NULL),
(65,	'Su şartlandırma çalışmalarında İnfo Group’u tercih eden kurumlar',	NULL,	NULL,	NULL),
(66,	'Su sistemleriniz ile ilgili tüm sorularınızı uzmanlarımıza danışabilirsiniz.',	NULL,	NULL,	NULL),
(67,	'Arama',	NULL,	NULL,	NULL),
(68,	'ARAMA',	NULL,	NULL,	NULL),
(69,	'Aramanıza uygun sonuç bulunamadı.',	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `mod_site_ayar`;
CREATE TABLE `mod_site_ayar` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `baslik_tr` text,
  `baslik_en` text,
  `baslik_ru` text,
  `aciklama_tr` text,
  `aciklama_en` text,
  `aciklama_ru` text,
  `kelimeler_tr` text,
  `kelimeler_en` text,
  `kelimeler_ru` text,
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
  `metin1_tr` text,
  `metin1_en` text,
  `metin1_ru` text,
  `metin2_tr` text,
  `metin2_en` text,
  `metin2_ru` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mod_site_ayar` (`id`, `baslik_tr`, `baslik_en`, `baslik_ru`, `aciklama_tr`, `aciklama_en`, `aciklama_ru`, `kelimeler_tr`, `kelimeler_en`, `kelimeler_ru`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `form1_alicilar`, `form2_alicilar`, `form3_alicilar`, `form4_alicilar`, `sosyal_url1`, `sosyal_url2`, `sosyal_url3`, `sosyal_url4`, `metin1_tr`, `metin1_en`, `metin1_ru`, `metin2_tr`, `metin2_en`, `metin2_ru`) VALUES
(1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'pro03.ni.net.tr',	'465',	'web@taximpro.com',	'web2012..',	NULL,	'erenezgu@gmail.com',	NULL,	NULL,	'info@infogroup.com.tr',	'https://www.facebook.com',	'https://www.linkedin.com',	NULL,	'İŞLETMENİZE ÖZEL SU ŞARTLANDIRMA PROGRAMLARIMIZLA \nSU SİSTEMLERİNİZ KORUMA ALTINDA.',	'İŞLETMENİZE ÖZEL SU ŞARTLANDIRMA PROGRAMLARIMIZLA \nSU SİSTEMLERİNİZ KORUMA ALTINDA.',	'İŞLETMENİZE ÖZEL SU ŞARTLANDIRMA PROGRAMLARIMIZLA \nSU SİSTEMLERİNİZ KORUMA ALTINDA.',	'İŞLETMENİZE ÖZEL SU ŞARTLANDIRMA PROGRAMLARIMIZLA',	'İŞLETMENİZE ÖZEL SU ŞARTLANDIRMA PROGRAMLARIMIZLA',	'İŞLETMENİZE ÖZEL SU ŞARTLANDIRMA PROGRAMLARIMIZLA');

DROP TABLE IF EXISTS `nfs`;
CREATE TABLE `nfs` (
  `nfs_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sira` int(11) DEFAULT NULL,
  `isim` text,
  `dosya` text,
  PRIMARY KEY (`nfs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `nfs` (`nfs_id`, `sira`, `isim`, `dosya`) VALUES
(1,	1,	'1160',	NULL);

DROP TABLE IF EXISTS `ozon`;
CREATE TABLE `ozon` (
  `ozon_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sira` text,
  `baslik_tr` text,
  `baslik_en` text,
  `baslik_ru` text,
  `simge` text,
  `resim` text,
  `aciklama_tr` text,
  `aciklama_en` text,
  `aciklama_ru` text,
  `kutu1_tr` text,
  `kutu1_en` text,
  `kutu1_ru` text,
  `kutu2_tr` text,
  `kutu2_en` text,
  `kutu2_ru` text,
  `kutu3_tr` text,
  `kutu3_en` text,
  `kutu3_ru` text,
  `link` text,
  PRIMARY KEY (`ozon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ozon` (`ozon_id`, `sira`, `baslik_tr`, `baslik_en`, `baslik_ru`, `simge`, `resim`, `aciklama_tr`, `aciklama_en`, `aciklama_ru`, `kutu1_tr`, `kutu1_en`, `kutu1_ru`, `kutu2_tr`, `kutu2_en`, `kutu2_ru`, `kutu3_tr`, `kutu3_en`, `kutu3_ru`, `link`) VALUES
(1,	'1',	'PLS101',	'PLS101',	'PLS101',	'icon-5.png|',	'ozon.jpg|',	'<p>Akvaryum suyunun temizlenmesi berraklığının sağlanması balıklarda g&ouml;r&uuml;len mantar benzeri hastalıkların &ouml;nlenmesinde ozon en &ouml;nemli yoldur . Ozon uygulaması sudaki total organik karbon (Total Organic Carbon, TOC) oranını %15&rsquo;lere kadar &ccedil;ekebilmekte, sudaki nitrit d&uuml;zeyi ile suyun bulanıklılığını azaltmakta ve sudaki katı maddelerin oksidasyonunu sağlayarak uzaklaştırmaktadır.</p>\r\n\r\n<p>Ozon gazı balık yetiştiriciliğinde su kalitesini y&uuml;kselten, hızlı b&uuml;y&uuml;me ve gelişme sağlayan, mortalite oranını d&uuml;ş&uuml;ren, balıklar i&ccedil;in zararlı organik maddeleri yok eden, suyun dezenfeksiyonunu ve oksijen bakımından zenginleşmesini sağlayan son derece g&uuml;venilir bir gazdır.</p>\r\n\r\n<p>Balık dışkısı suda amonyak kaynağı olarak &ouml;nemli rol oynar. Suda 1mg/l konsantrasyonundaki amonyak balıklar i&ccedil;in &ouml;ld&uuml;r&uuml;c&uuml; dozda toksiktir ve 0.02 mg/l gibi d&uuml;ş&uuml;k konsantrasyonlarda bile solunga&ccedil;ları tahrip etmesi ve gelişmeyi yavaşlatması gibi olumsuz etkileri vardır.</p>\r\n\r\n<p>Yetiştiricilikte sudaki amonyak, amonyum, nitrit ve nitrat değerlerinin sırasıyla 0,02 mg/lt, 1,0 mg/lt, 0,2 mg/lt ve 10mg/lt&rsquo;ye kadar olması gerekmektedir. Sudaki azot d&ouml;ng&uuml;s&uuml;, amonyum (NH4+) &reg; amonyak (NH3+) &reg; nitrit (NO2-) &reg; nitrat (NO3-) şeklinde ger&ccedil;ekleşmektedir. Nitrit balıklar i&ccedil;in toksik olmasına rağmen nitrat zehirsizdir.</p>\r\n\r\n<p>Ozon gazı nitriti nitrata okside eder. B&ouml;ylece bir bakıma nitrobakterlerin g&ouml;revini &uuml;stlenerek balıklar i&ccedil;in toksik olan sudaki nitrit konsantrasyonunu d&uuml;ş&uuml;r&uuml;r.</p>',	NULL,	NULL,	'<p>S&uuml;s Havuzlarında</p>\r\n\r\n<p>S&uuml;s Havuzlarında</p>\r\n\r\n<p>S&uuml;s Havuzlarında</p>\r\n\r\n<p>S&uuml;s Havuzlarında</p>',	NULL,	NULL,	'<ul>\r\n	<li>Suyun berraklığını artırır.</li>\r\n	<li>Suyun berraklığını artırır.</li>\r\n	<li>Suyun berraklığını artırır.</li>\r\n	<li>Suyun berraklığını artırır.</li>\r\n	<li>Suyun berraklığını artırır.</li>\r\n	<li>Suyun berraklığını artırır.</li>\r\n	<li>Suyun berraklığını artırır.</li>\r\n	<li>Suyun berraklığını artırır.</li>\r\n	<li>Suyun berraklığını artırır.</li>\r\n	<li>Suyun berraklığını artırır.</li>\r\n</ul>',	NULL,	NULL,	'<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>Ozon &Uuml;retim Metodu</td>\r\n			<td>Corona Disharge</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Ozon &Uuml;retim Metodu</td>\r\n			<td>Corona Disharge</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Ozon &Uuml;retim Metodu</td>\r\n			<td>Corona Disharge</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Ozon &Uuml;retim Metodu</td>\r\n			<td>Corona Disharge</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Ozon &Uuml;retim Metodu</td>\r\n			<td>Corona Disharge</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Ozon &Uuml;retim Metodu</td>\r\n			<td>Corona Disharge</td>\r\n		</tr>\r\n	</tbody>\r\n</table>',	NULL,	NULL,	'javascript:void();');

DROP TABLE IF EXISTS `referans`;
CREATE TABLE `referans` (
  `referans_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kategori_id` int(10) unsigned DEFAULT NULL,
  `sira` int(11) DEFAULT NULL,
  `logo` text,
  `baslik_tr` text,
  `baslik_en` text,
  `baslik_ru` text,
  `aciklama_tr` text,
  `aciklama_en` text,
  `aciklama_ru` text,
  `videolar` text,
  PRIMARY KEY (`referans_id`),
  KEY `kategori_id` (`kategori_id`),
  CONSTRAINT `referans_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `referans_kategori` (`kategori_id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `referans` (`referans_id`, `kategori_id`, `sira`, `logo`, `baslik_tr`, `baslik_en`, `baslik_ru`, `aciklama_tr`, `aciklama_en`, `aciklama_ru`, `videolar`) VALUES
(1,	1,	1,	'info-logo.png|',	'CUMHURBAŞKANLIĞI',	NULL,	NULL,	'ISITMA SOĞUTMA KAPALI DEVRE KOROZYON KORUMA İLE KOROZYON İSTASYONLARI VE BAG FİLTRE UYGULAMALARI SOĞUTMA KULESİ KİMYASAL ŞARTLANDIRMA VE DOZAJ İSTASYONLARI KULLANIM SUYU DEZENFEKSİYONU SU ŞARTLANDIRMA DANIŞMANLIK HİZMETLERİ',	NULL,	NULL,	'https://www.youtube.com/watch?v=YE7VzlLtp-4\r\nhttps://www.youtube.com/watch?v=YE7VzlLtp-4\r\nhttps://www.youtube.com/watch?v=YE7VzlLtp-4');

DROP TABLE IF EXISTS `referans_kategori`;
CREATE TABLE `referans_kategori` (
  `kategori_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sira` int(11) DEFAULT NULL,
  `baslik_tr` text,
  `baslik_en` text,
  `baslik_ru` text,
  PRIMARY KEY (`kategori_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `referans_kategori` (`kategori_id`, `sira`, `baslik_tr`, `baslik_en`, `baslik_ru`) VALUES
(1,	1,	'AVM &amp; İŞ MERKEZLERİ',	'AVM &amp; İŞ MERKEZLERİ',	'AVM &amp; İŞ MERKEZLERİ');

DROP TABLE IF EXISTS `urun`;
CREATE TABLE `urun` (
  `urun_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kategori_id` int(10) unsigned DEFAULT NULL,
  `sira` int(11) DEFAULT NULL,
  `baslik_tr` text,
  `baslik_en` text,
  `baslik_ru` text,
  `aciklama_tr` text,
  `aciklama_en` text,
  `aciklama_ru` text,
  `resimler` text,
  PRIMARY KEY (`urun_id`),
  KEY `kategori_id` (`kategori_id`),
  CONSTRAINT `urun_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `urun_kategori` (`kategori_id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `urun` (`urun_id`, `kategori_id`, `sira`, `baslik_tr`, `baslik_en`, `baslik_ru`, `aciklama_tr`, `aciklama_en`, `aciklama_ru`, `resimler`) VALUES
(1,	1,	1,	'INFO 1100 Serisi - Oksijen Alıcı Ürünler',	'INFO 1100 Serisi - Oksijen Alıcı Ürünler',	'INFO 1100 Serisi - Oksijen Alıcı Ürünler',	'Kısa açıklama bilgisi gelebilir. Ürün hakkında kısaca ne işe yaradığı ne amaçla kullanıldığı gibi bilgiler  Kısa açıklama bilgisi gelebilir. Ürün hakkında kısaca ne işe yaradığı ne amaçla kullanıldığı gibi bilgiler',	NULL,	NULL,	'1.jpg|:1.jpg|:1.jpg|:1.jpg|:1.jpg|:1.jpg|');

DROP TABLE IF EXISTS `urun_kategori`;
CREATE TABLE `urun_kategori` (
  `kategori_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sira` int(11) DEFAULT NULL,
  `baslik_tr` text,
  `baslik_en` text,
  `baslik_ru` text,
  `simge` text,
  PRIMARY KEY (`kategori_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `urun_kategori` (`kategori_id`, `sira`, `baslik_tr`, `baslik_en`, `baslik_ru`, `simge`) VALUES
(1,	1,	'BUHAR ÜRETİM SİSTEMLERİ',	'BUHAR ÜRETİM SİSTEMLERİ',	'BUHAR ÜRETİM SİSTEMLERİ',	'icon-1.png|');

DROP TABLE IF EXISTS `video`;
CREATE TABLE `video` (
  `video_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sira` int(11) DEFAULT NULL,
  `dil` varchar(2) DEFAULT NULL,
  `baslik` text,
  `resim` text,
  `url` text,
  PRIMARY KEY (`video_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `video` (`video_id`, `sira`, `dil`, `baslik`, `resim`, `url`) VALUES
(1,	1,	'tr',	'SU SİSTEMLERİNİZİN ÖMRÜNÜ UZATAC ÇÖZÜMLER ÜRETİYORUZ',	'video-1.jpg',	'https://www.youtube.com/watch?v=YE7VzlLtp-4'),
(2,	2,	'tr',	'SU SİSTEMLERİNİZİN ÖMRÜNÜ UZATAC ÇÖZÜMLER ÜRETİYORUZ',	'video-1.jpg',	'https://www.youtube.com/watch?v=YE7VzlLtp-4'),
(3,	3,	'tr',	'SU SİSTEMLERİNİZİN ÖMRÜNÜ UZATAC ÇÖZÜMLER ÜRETİYORUZ',	'video-1.jpg',	'https://www.youtube.com/watch?v=YE7VzlLtp-4'),
(4,	4,	'tr',	'SU SİSTEMLERİNİZİN ÖMRÜNÜ UZATAC ÇÖZÜMLER ÜRETİYORUZ',	'video-1.jpg',	'https://www.youtube.com/watch?v=YE7VzlLtp-4');

-- 2017-08-01 12:40:08
