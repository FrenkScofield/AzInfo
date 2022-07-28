<?php 
header('Content-type:text/html;charset=utf-8',true);
$config = _getAppData('config',true);
$adminTitle=(isset($config['main']['adminTitle'])?$config['main']['adminTitle']:$config['main']['defaultTitle'].' '._l('Administration Panel'));
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$adminTitle?></title>

<link href="<?=ASSET_URL?>/css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="<?=ASSET_URL?>/css/ui/redmond/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="<?=ASSET_URL?>/js/jnotify/jquery.jnotify.css" rel="stylesheet" type="text/css" />
<link href="<?=ASSET_URL?>/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css" />
<link href="<?=ASSET_URL?>/js/jdMenu/jquery.jdMenu.css" rel="stylesheet" type="text/css" />
<link href="<?=ASSET_URL?>/css/print.css" rel="stylesheet" type="text/css" media="print"/>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3.1&sensor=false"></script>
<script type="text/javascript" src="<?=ASSET_URL?>/js/js.php"></script>
</head>

<body>
    <div id="StatusBar" style="position:fixed;top:69px;width:100%;z-index:100;"></div>
    <div id="maintop"><?=$adminTitle;?></div>
    <div id="main_menu"></div>
    <div id="loading_wrapper">
        <img class="loading" src="<?=ASSET_URL.'/images/'?>ajax-loader.gif" />
    </div>
    <div id="toolbar">
        <a title="<?= _l('Dashboard') ?>" href="javascript:newTab('<?= CUrlHelper::getModUrl('main') ?>','<?= _l('Dashboard') ?>');"><img src="<?=ASSET_URL?>/images/toolbar/anasayfa.png" /></a>
        <a title="<?= _l('Refresh') ?>" onclick="reloadCurrentTab();" ><img src="<?=ASSET_URL?>/images/toolbar/yenile.png" /></a>
        <a title="<?= _l('Refresh Menu') ?>" onclick="refresh_admin_menu();" ><img src="<?=ASSET_URL?>/images/toolbar/menu_yenile.png" /></a>
        <a title="<?= _l('Lock screen') ?>" onclick="ekran_kilitle();" ><img src="<?=ASSET_URL?>/images/toolbar/ekran_kilitle.png" /></a>
        <a title="<?= _l('Settings') ?>" href="javascript:newTab('<?= CUrlHelper::getModXUrl('mod_admin', 'user/settings') ?>','<?= _l('Settings') ?>')" ><img src="<?=ASSET_URL?>/images/toolbar/ayarlar.png" /></a>
        <a title="<?= _l('Logout') ?>" href="<?= CUrlHelper::getModUrl('user/logout') ?>" ><img src="<?=ASSET_URL?>/images/toolbar/cikis.png" /></a>
    </div>
    <div id="main_content">
        <div id="tabs"><ul></ul></div>
    </div>
    <?php 
    if(isset($config['main']['seller'])) {
        $seller = $config['main']['seller'];
        ?>
        <div id="footer2" style="clear:both;position:relative;width:100%;height:30px;"></div>
        <div id="footer" style="position:fixed;bottom:0;width:98%;height:18px; padding:1px 1%; font-size:12px;line-height:18px;border-top:1px solid #a6c9e2;background-color:#fff;z-index:100;">
            <a href="<?=$seller['web']?>" target="_blank"><img src="<?=ASSET_URL;?>/images/<?=$seller['logo']?>" title="<?=$seller['firma']?>" style="width:60px;height:18px;float:right;"></a>
            <?=$seller['panel_ad'];?>
            Site Yönetim Paneli v<?=$seller['surum'];?>
        </div>
    <?php 
    }
    ?>
	<?php /*
	<table id="layout" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td colspan="2" id="ust_panel" class="section">
				<div class="loading"><img src="<?=ASSET_URL.'/images/'?>ajax-loader.gif"></div>
			</td>
		</tr>

		<tr>
			<td id="menu" valign="top" class="section">
				<div align="center"><?=_l('Welcome')?></div>
				<div class="username"></div>
				<div></div>
				<ul id="menu_icons" class="ui-widget icon-collection">
					<li title="<?=_l('Dashboard')?>" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-home"></span><a class="xhr" href="<?=CUrlHelper::getModUrl('main')?>"><?=_l('Dashboard')?></a></li>
					<li title="<?=_l('Refresh')?>" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-refresh"></span><a onclick="reloadCurrentTab();"><?=_l('Refresh')?></a></li>
					<li title="<?=_l('Refresh Menu')?>" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-refresh"></span><a onclick="refresh_admin_menu();"><?=_l('Refresh Menu')?></a></li>
					<li title="<?=_l('Lock screen')?>" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-locked"></span><a onclick="ekran_kilitle(true);"><?=_l('Lock screen')?></a></li>
					<li title="<?=_l('Settings')?>" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-locked"></span><a class="xhr" href="<?=CUrlHelper::getModXUrl('mod_admin','user/settings')?>"><?=_l('Settings')?></a></li>
					<li title="<?=_l('Logout')?>" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-power"></span><a href="<?=CUrlHelper::getModUrl('user/logout')?>"><?=_l('Logout')?></a></li>
				</ul>
				<div id="admin_menu"></div>
				<div class="loading" style="margin-top:15px;"><img src="<?=ASSET_URL.'/images/'?>ajax-loader.gif"></div>

			</td>
			<td id="icerik" valign="top" class="section">
				<div id="tabs"><ul></ul></div>
			</td>
		</tr>

		<tr><td colspan="2" id="log" class="section"></td></tr>
	</table>
	 */?>

	<?php
	
	ModAdminUserHelper::initToken();
	
	$mainConfig = _getAppData(null);
	$mainConfig = $mainConfig['config']['main'];
	$urlType = $mainConfig['urlType'];
	?>

	<script type="text/javascript">
	var urlType = '<?=$urlType?>';
	var blocked = false;
	var pinger_running = false;

	var pinger = {};
	
	var token = '<?=$_SESSION['mod_admin_token']?>';

	var $tabs = {};

	var active_hash = '';
	var reload_hash = true;
	var tab_label = '...';

	var uuid = 1;


	function refresh_admin_menu()
	{
		$('.loading').show();
		<?php /*$('#admin_menu').load('<?=CUrlHelper::getModXUrl('mod_admin','main/admin_menu')?>',{},function(){$('.loading').hide();});*/?>
		$('#main_menu').load('<?=CUrlHelper::getModXUrl('mod_admin','main/admin_menu')?>',{},function(){$('.loading').hide();});
	}

	function newTab(url,title){
		tab_label = title;
		document.location.href = '#'+url;
		reload_hash = true;
	}

	$(function(){

		$tabs = $('#tabs');

		$tabs.tabs({
			collapsible : true,
			cache: true,
			spinner: '<?=_l('Loading')?>...',
			ajaxOptions: { cache: false },
			tabTemplate:'<li><a href="#{href}"><span>#{label}</span></a>  <div class="tabClose" onclick="closeTab(this);"></div> </li>',
			add: function(event, ui) {
				$tabs.tabs('select', '#' + ui.panel.id);
				$('.loading').hide();
			},
			load: function(){
				$('.loading').hide();
			}
		});

		refresh_admin_menu();

		$('a.xhr').live('click',function(e){
			e.preventDefault();
			var url = $(this).attr('href');
			tab_label = $(this).attr('title');
			if(tab_label=='' || tab_label==undefined) tab_label = $(this).text();
			reload_hash = true;
			document.location.href = '#'+url;
			return false;
		});


		var route_interval = setInterval(function(){
			var hash = document.location.hash;
			if( (hash!='' && active_hash!=hash) || reload_hash){
				$('.loading').show();
				reload_hash = false;
				active_hash = hash;
				var url = hash.replace(/^#/,'');
				if(url==''){
					url = '<?=CUrlHelper::getModXUrl('mod_admin','main')?>';
				}
				if(urlType=='parametric'){
					url = url + '&xhr';
				}else {
					url = url + '?xhr';
				}
				url = url + '&_token='+token;
				
				$tabs.tabs("add",url,tab_label);
				tab_label = '...';
			}
		},250);

		/*
		$('.grid_yenile').live('click',function(e){
			e.preventDefault();
			reloadCurrentTab();
			return false;
		});
		*/
		$('.grid_arama').live('click',function(e){
			e.preventDefault();
			$(this).parents('.list_container').eq(0).find('.arama').slideToggle();
			return false;
		});
		/*
		$('.grid_satir_ekle , .grid_satir_duzenle , .grid_satir_goster').live('click',function(e){
			e.preventDefault();
			$('.loading').show();
			var $editForm = $(this).parents('.list_container').eq(0).find('.editForm_container');
			var url = $(this).attr('href') +'?xhr';
			$editForm.html('').show().load(url,{},function(){
				$('.loading').hide();
			});
			return false;
		});*/
		$('.grid_satir_sil').live('click',function(e){
			e.preventDefault();
			var $container = $(this).parents('.list_container').eq(0);
			var $result = $container.find('.result');
			var row_id = $(this).attr('row_id');
			if(confirm('<?=_l('Do you want to delete this row?')?> ('+row_id+')')){
				var url = $(this).attr('href') +'?xhr&_token='+window.token;
				$result.load(url,function(){
					$container.find('.grid_yenile').trigger('click');
				});
			}
			return false;
		});
	});


	function ekran_kilitle(logout)
	{
		if(logout==undefined) logout = true;
		if(!blocked){
			$('#login_form').load('<?=CUrlHelper::getModUrl('user/login')?>?lock'+(logout?'&logout':'') ,function(){
				$.blockUI({
					message:$('#login_form'),
					showOverlay:true,
					baseZ: 250,
					css: {
						width:'300px',
						height:'auto'
					},
					overlayCSS:{
						backgroundColor:'#000',
						opacity:1.0
					}
				});
				blocked = true;
			});
		}
	}

	function ping(){
		if(pinger_running) return;
		pinger_running = true;
		$.post('<?=CUrlHelper::getModUrl('main/ping')?>',{},function(data){
			if(data===null) return;
			if(data.logged_in==false){
				ekran_kilitle();
			}
			$('.username').html(data.username);
			window.token = data.token;
		},'json');
		pinger_running = false;
	}

	function cron(){
		ping();
	}

	$(function(){
		cron();
		setInterval(cron,12000);
	});
	</script>
	<div id="login_form" style="display:none;"></div>
	<style type="text/css">
	.blockOverlay {
		background:#000000;
		filter:alpha(opacity=100);
		opacity: 1.0;
		-moz-opacity:1.0;
	}
	</style>
</body>
</html>
