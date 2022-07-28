<?php 
$config = _getAppData('config',true);
if(isset($config['main']['seller'])) {
    $seller = $config['main']['seller'];
    $adminTitle=(isset($config['main']['adminTitle'])?$config['main']['adminTitle']:$config['main']['defaultTitle'])." Yönetici Paneli";
    ?>
    <fieldset class="grid_fs" style="font-size:13px; line-height:22px;">
        <legend class="grid_title"><?=$adminTitle;?> Web Sitesi Yönetici Paneline Hoşgeldiniz...</legend>
        <ul>
            <li>Panelimiz basit bir arayüzde ve kullanımı kolay / hızlı olacak şekilde tasarlanmıştır.</li>
            <li>Panelimizden yapabileceğiniz tüm işlemler için yukarıdaki menüyü kullanacağız.</li>
            <li>Panelden web sitenize veri / yazı / resim ekleyip çıkarabilecek, sitenizle ilgili tüm işlemleri takip edebileceksiniz.</li>
            <li>Panelimiz en hızlı <b>Google Chrome</b> ile çalışmaktadır. <b>Chrome</b> güncel sürümü indirmek için <a href="http://www.google.com/chrome/?hl=tr" style="color:blue">tıklayınız..</a></li>
            <li>Panel ve web sitesi hakkında her türlü problem için <a href="mailto:<?=$seller['email']?>" style="color:blue"><?=$seller['email']?></a> adresine mail atabilir, <span style="color:blue;"><?=$seller['tel']?></span> nolu telefondan bizleri arayabilirsiniz</li>
        </ul>
        <a href="<?=$seller['web']?>" target="_blank" style="color:blue"><?=$seller['firma']?> &raquo;</a>
    </fieldset>
    <?php 
}else {
    ?>
    <div style="padding:20px 10px;">
        <?=_l('Welcome to admin!')?>
    </div>
    <?php 
}