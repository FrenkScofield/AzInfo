<?php 
header('Content-type:text/html;charset=utf-8', true);

$home_url = CUrlHelper::getUrl('main/index');

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="description" content="<?php $desc = _getAppData('seo_description'); echo!empty($desc) ? $desc : (class_exists('ModSiteHelper') ? ModSiteHelper::get_ayar('aciklama_' . LANG) : ''); ?>">
    <meta name="keywords" content="<?php $words = _getAppData('seo_keywords'); echo!empty($words) ? $words : (class_exists('ModSiteHelper') ? ModSiteHelper::get_ayar('kelimeler_' . LANG) : ''); ?>">
    <meta name="author" content="Baris Karaderili - Karaderili.baris@gmail.com">
    <title>
        <?= $title ?>
    </title>
    <!-- css -->
    <link rel="stylesheet" href="<?= BASE_URL.'/'?>css/uikit.css" media="screen" title-no="no title" charset="utf-8">
    <link rel="stylesheet" href="<?= BASE_URL.'/'?>css/main.css" media="screen" title-no="no title" charset="utf-8">
    <!-- javascript-->
    <script src="<?= BASE_URL.'/'?>library/jquery/dist/jquery.min.js" charset="utf-8">


    </script>
    <script src="<?= BASE_URL.'/'?>js/uikit.min.js" charset="utf-8"></script>
    <script src="<?= BASE_URL.'/'?>js/main.js" charset="utf-8"></script>

    <?php
	ModUrlHelper::headerTags();
	?>

</head>

<body>
    <!-- header start-->
    <header class="info-header uk-visible-large">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-collapse">
                <div class="uk-width-large-2-10 uk-position-relative">
                    <div class="info-header-logo uk-position-top-left"><a href="<?= $home_url ?>"><img src="<?= BASE_URL ?>/images/header/logo.png" alt=""></a></div>
                </div>
                <div class="uk-width-large-8-10">
                    <div class="uk-grid uk-grid-collapse">
                        <div class="uk-width-1-1">
                            <div class="info-header-search uk-flex">
                                <div class="info-header-input uk-position-relative">
                                    <form class="uk-form" method="POST" action="<?= CUrlHelper::getModXUrl('mod_search','main')?>">
                                        <?= CCoreHelper::getTokenInput(); ?>
                                            <div class="uk-form-row">
                                                <input type="text" name="q" placeholder="">
                                                <button class="uk-position-top-right"><img src="<?= BASE_URL ?>/images/header/search-icon.png" alt=""></button>
                                            </div>
                                    </form>
                                </div>
                                <div class="info-header-language">
                                    <ul class="uk-flex">
                                        <li><a href="<?= CUrlHelper::getLangUrl('tr')?>"><img src="<?= BASE_URL ?>/images/header/turkey-flag.png" alt=""></a></li>
                                        <li><a href="<?= CUrlHelper::getLangUrl('az')?>"><img src="<?= BASE_URL ?>/images/header/az-flag.png" alt=""></a></li>
                                        <li><a href="<?= CUrlHelper::getLangUrl('en')?>"><img src="<?= BASE_URL ?>/images/header/usa-flag.png" alt=""></a></li>
                                        <li><a href="<?= CUrlHelper::getLangUrl('ru')?>"><img src="<?= BASE_URL ?>/images/header/russian-flag.png" alt=""></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-1">
                            <div class="info-header-menu">
                                <nav class="uk-navbar">
                                    <div class="uk-navbar-flip">
                                        <ul class="uk-navbar-nav uk-text-center">
                                            <li><a href="<?= $home_url ?>"><img src="<?= BASE_URL ?>/images/header/home-icon.png" alt=""></a></li>
                                            <li>
                                                <a href="<?= CUrlHelper::getUrl('main/kurumsal')?>">
                                                    <?= _l('KURUMSAL') ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= CUrlHelper::getUrl('main/hizmetler')?>">
                                                    <?= _l('HİZMETLER') ?>
                                                </a>
                                            </li>
                                            <li class="uk-parent" data-uk-dropdown="{}">
                                                <a href="javascript:void(0)">
                                                    <?= _l('ÜRÜNLER') ?>
                                                </a>
                                                <div class="uk-dropdown">
                                                    <ul class="uk-nav">
                                                        <li>
                                                            <a href="<?= CUrlHelper::getUrl('main/urunler')?>">
                                                                <?= _l('ÜRÜNLERİMİZ') ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?= CUrlHelper::getUrl('main/nsf_urunler')?>">
                                                                <?= _l("NSF'Lİ ÜRÜNLERİMİZ") ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?= CUrlHelper::getUrl('main/ozon_sistemleri')?>">
                                                                <?= _l('OZON SİSTEMLERİ') ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="http://www.pulsa.com.tr/" target="_blank">
                                                                <?= _l('EKİPMANLARIMIZ') ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?= CUrlHelper::getUrl('main/belgeler')?>">
                                                                <?= _l('BELGELER') ?>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="uk-parent" data-uk-dropdown="{}">
                                                <a href="javascript:void(0)">
                                                    <?= _l('SERTİFİKALAR') ?>
                                                </a>
                                                <div class="uk-dropdown">
                                                    <ul class="uk-nav">
                                                        <li>
                                                            <a href="<?= CUrlHelper::getUrl('main/teknik_belgeler')?>">
                                                                <?= _l('TEKNİK BELGELER') ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?= CUrlHelper::getUrl('main/kalite_belgeleri')?>">
                                                                <?= _l('KALİTE BELGELERİ') ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?= CUrlHelper::getUrl('main/sistem_bilgi_formatlari')?>">
                                                                <?= _l('SİSTEM BİLGİ FORMATLARI') ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?= CUrlHelper::getUrl('main/seminerler')?>">
                                                                <?= _l('SEMİNERLER') ?>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <a href="<?= CUrlHelper::getUrl('main/referanslar')?>">
                                                    <?= _l('REFERANSLAR') ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= CUrlHelper::getUrl('main/haberler')?>">
                                                    <?= _l('HABERLER') ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= CUrlHelper::getUrl('main/iletisim')?>">
                                                    <?= _l('İLETİŞİM') ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- mobile header start-->
    <header class="info-mobile-header uk-hidden-large">
        <div class="info-mobile-header-logo"><a href="<?= $home_url ?>"><img src="<?= BASE_URL ?>/images/header/logo.png" alt=""></a></div><a class="uk-icon-bars uk-position-absolute" href="#info-mobile-menu" data-uk-offcanvas="{mode: 'slide'}"></a>
    </header>
    <div class="uk-offcanvas" id="info-mobile-menu">
        <div class="uk-offcanvas-bar">
            <div class="info-mobile-menu-logo"><a href="<?= $home_url ?>"><img src="<?= BASE_URL ?>/images/header/logo.png" alt=""></a></div>
            <div class="form uk-form">
                <div class="uk-form-row">
                    <form method="POST" action="<?= CUrlHelper::getModXUrl('mod_search','main')?>">
                        <?= CCoreHelper::getTokenInput(); ?>
                            <div class="uk-form-controls">
                                <input type="text" name="q" id="" placeholder="<?= _l('Arama') ?>">
                                <button><i class="uk-icon-search">   </i></button>
                            </div>
                    </form>
                </div>
            </div>
            <ul class="uk-nav uk-nav-offcanvas uk-nav-parent-icon" data-uk-nav="">
                <li class="uk-active">
                    <a href="<?= $home_url ?>">
                        <?= _l('ANASAYFA') ?>
                    </a>
                </li>
                <li>
                    <a href="<?= CUrlHelper::getUrl('main/kurumsal')?>">
                        <?= _l('KURUMSAL') ?>
                    </a>
                </li>
                <li>
                    <a href="<?= CUrlHelper::getUrl('main/hizmetler')?>">
                        <?= _l('HİZMETLER') ?>
                    </a>
                </li>
                <li class="uk-parent">
                    <a href="#">
                        <?= _l('ÜRÜNLERİMİZ') ?>
                    </a>
                    <ul class="uk-nav-sub">
                        <li>
                            <a href="<?= CUrlHelper::getUrl('main/urunler')?>">
                                <?= _l('ÜRÜNLERİMİZ') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= CUrlHelper::getUrl('main/nsf_urunler')?>">
                                <?= _l("NSF'Lİ ÜRÜNLERİMİZ") ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= CUrlHelper::getUrl('main/ozon_sistemleri')?>">
                                <?= _l('OZON SİSTEMLERİ') ?>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.pulsa.com.tr/" target="_blank">
                                <?= _l('EKİPMANLARIMIZ') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= CUrlHelper::getUrl('main/belgeler')?>">
                                <?= _l('BELGELER') ?>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="uk-parent">
                    <a href="#">
                        <?= _l('SERTİFİKALAR') ?>
                    </a>
                    <ul class="uk-nav-sub">
                        <li>
                            <a href="<?= CUrlHelper::getUrl('main/teknik_belgeler')?>">
                                <?= _l('TEKNİK BELGELER') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= CUrlHelper::getUrl('main/kalite_belgeleri')?>">
                                <?= _l('KALİTE BELGELERİ') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= CUrlHelper::getUrl('main/sistem_bilgi_formatlari')?>">
                                <?= _l('SİSTEM BİLGİ FORMATLARI') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= CUrlHelper::getUrl('main/seminerler')?>">
                                <?= _l('SEMİNERLER') ?>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?= CUrlHelper::getUrl('main/referanslar')?>">
                        <?= _l('REFERANSLAR') ?>
                    </a>
                </li>
                <li>
                    <a href="<?= CUrlHelper::getUrl('main/haberler')?>">
                        <?= _l('HABERLER') ?>
                    </a>
                </li>
                <li>
                    <a href="<?= CUrlHelper::getUrl('main/iletisim')?>">
                        <?= _l('İLETİŞİM') ?>
                    </a>
                </li>
            </ul>
            <div class="info-header-language">
                <ul class="uk-flex">
                    <li><a href="<?= CUrlHelper::getLangUrl('tr')?>"><img src="<?= BASE_URL ?>/images/header/turkey-flag.png" alt=""></a></li>
                    <li><a href="<?= CUrlHelper::getLangUrl('az')?>"><img src="<?= BASE_URL ?>/images/header/az-flag.png" alt=""></a></li>
                    <li><a href="<?= CUrlHelper::getLangUrl('en')?>"><img src="<?= BASE_URL ?>/images/header/usa-flag.png" alt=""></a></li>
                    <li><a href="<?= CUrlHelper::getLangUrl('ru')?>"><img src="<?= BASE_URL ?>/images/header/russian-flag.png" alt=""></a></li>
                </ul>
            </div>
        </div>
    </div>

    <?= $content ?>

        <!-- footer start-->
        <footer class="info-footer uk-position-relative">
            <div class="uk-container uk-container-center">
                <div class="uk-grid uk-grid-small">
                    <div class="uk-width-large-1-2">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-small-1-3"><span><?= _l('KURUMSAL') ?> </span>
                                <ul>
                                    <li>
                                        <a href="<?= CUrlHelper::getUrl('main/kurumsal') ?>">
                                            <?= _l('Hakkımızda') ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= CUrlHelper::getUrl('main/insan_kaynaklari') ?>">
                                            <?= _l('İnsan Kaynakları') ?>
                                        </a>
                                    </li>
                                    <li><a href="#">Bilgi Toplumu Hizmetleri</a></li>
                                </ul>
                            </div>
                            <div class="uk-width-small-1-3"><span><?= _l('HİZMETLER') ?> </span>
                                <ul>
                                    <?php
							$hizmetler = AppHelper::getHizmetler();
							foreach($hizmetler as $h){
							?>
                                        <li>
                                            <a href="<?=$h['url']?>">
                                                <?=$h['baslik']?>
                                            </a>
                                        </li>
                                        <?php } ?>
                                </ul>
                            </div>
                            <div class="uk-width-small-1-3"><span><?= _l('SERTİFİKALAR') ?> </span>
                                <ul>
                                    <li>
                                        <a href="<?= CUrlHelper::getUrl('main/teknik_belgeler') ?>">
                                            <?= _l('Teknik Belgeler') ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= CUrlHelper::getUrl('main/kalite_belgeleri') ?>">
                                            <?= _l('Kalite Belgeleri') ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= CUrlHelper::getUrl('main/sistem_bilgi_formatlari') ?>">
                                            <?= _l('Sistem Bilgi Formatları') ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-large-1-2">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-small-4-6"><span><?= _l('İLETİŞİM') ?></span>
                                <ul>
                                    <li>Tel: <a href="tel:+90 216 661 50 77">+994 12 555 70 51</a></li>
                                    <li>E-mail: <a href="mailto:info@azinfo.com.tr">info@azinfo.com.tr</a></li>
                                    <li>
                                        <address><?= _l('Narimanov District Ziya Bunyadov Street, 1965 House Baku, Azerbaijan') ?></address>
                                    </li>
                                </ul>
                            </div>
                            <div class="uk-width-small-2-6 uk-flex uk-flex-center uk-flex-middle"><a href="#" target="_blank"><img src="<?= BASE_URL ?>/images/footer/info-logo.png" alt=""></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="info-footer-copyright uk-flex uk-flex-middle uk-flex-center"><small><?=_l('Copyright © 2017')?> <?=_l('Info Group Endüstriyel Dan. San. ve Tic. A.Ş.')?> <?= _l('Her Hakkı Saklıdır.') ?></small></div>
        </footer>
        <?php ModPopupHelper::popupHtml(); ?>
</body>

</html>
