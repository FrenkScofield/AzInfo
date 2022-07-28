<?php

class ModAdminMenuHelper extends CHelper {

	public static function showMainMenu() {
		ModAdminUserHelper::refreshData();
		header('Content-type:text/html;charset=utf-8',1);
		$menuArr = CCoreHelper::getModConfig('menu');
		//echo '<pre>'.print_r($menuArr,true).'</pre>';
		?>
		<ul id="nav_menu" class="jd_menu">
			<?php /*<li><?= _l('Admin Panel') ?> &raquo;
				<ul>
					<li><a href="javascript:newTab('<?= CUrlHelper::getModUrl('main') ?>','<?= _l('Dashboard') ?>');"><?= _l('Dashboard') ?></a></li>
					<li><a onclick="reloadCurrentTab();"><?= _l('Refresh') ?></a></li>
					<li><a onclick="refresh_admin_menu();"><?= _l('Refresh Menu') ?></a></li>
					<li><a onclick="ekran_kilitle(true);"><?= _l('Lock screen') ?></a></li>
					<li><a href="javascript:newTab('<?= CUrlHelper::getModXUrl('mod_admin', 'user/settings') ?>','<?= _l('Settings') ?>')"><?= _l('Settings') ?></a></li>
					<li><a href="<?= CUrlHelper::getModUrl('user/logout') ?>"><?= _l('Logout') ?></a></li>
				</ul>
			</li>*/?>
		<?php echo self::getMenu($menuArr); ?>
			<li><a href="<?= CUrlHelper::getModUrl('user/logout') ?>"><?= _l('Logout') ?></a></li>
		</ul>
		<script type="text/javascript">
			$('ul.jd_menu').jdMenu();
			$('ul.jd_menu li:first').css('border-left','0');
		</script>


		<?php 
	}
	
	public static function getMenu($menuArr, $depth=0) {
		ob_start();
		foreach ($menuArr as $title => $item) {
			if (is_array($item)) {
				?>
				<li><?php echo $title; ?> &raquo;
					<ul><?php echo self::getMenu($item, $depth + 1); ?></ul>
				</li>
				<?php 
			} else {
				$titleParam = str_replace(array("'","&#039;"), "\'", $title);
				/* ?><li><a class="xhr" href="<?=$item?>"><?=_l($title)?></a></li><?php */
				/* ?><li><a href="#<?=$item?>"><?=_l($title)?></a></li><?php */
				?><li><a href="javascript:newTab('<?= $item ?>','<?= _l($titleParam) ?>');"><?= _l($title) ?></a></li><?php 
			}
		}
		return ob_get_clean();
	}
	
	/**
	 * Returns full menu config structure without generating menu urls
	 * @return array
	 */
	public static function getFullMenuConfig(){
		$menu_config = array();
		// add enabled modules' admin menus
		$config = _getAppData('config');
		
		if(isset($config['main']['mod_admin_menu'])) // load initial mod_admin menu if set
		{
			$menu_config = $config['main']['mod_admin_menu'];
			
		}

		$modules = $config['main']['modules'];

		//debug($custom_menu);die();

		foreach($modules as $alias=>$m)
		{
			$module = is_array($m)?$m['module']:$m;
			$mconf = CCoreHelper::getModConfig('main','',$module);

			$admin_menu = array();
			if(isset($mconf['admin_menu'])){
				$admin_menu = $mconf['admin_menu'];
			}
			else if( isset($mconf['admin_menu_title'])&&isset($mconf['admin_menu_items']) ){
				$label = _mlang($mconf['admin_menu_title'], 'main', $module) ;
				$admin_menu = array(
					$label =>$mconf['admin_menu_items']
				);
			}
			else {
				continue;
			}			
			$menu_config = array_merge($menu_config,$admin_menu);	
		}
		if(is_callable('_admin_menu_config_modify')){
			$menu_config = _admin_menu_config_modify($menu_config);
		}
		return $menu_config;
	}
	
	/**
	 * Returns menu tree (to be used for generating admin menu html)
	 */
	public static function getMenuTree(){
		$menu_tree = array();
		// add enabled modules' admin menus
		$config = _getAppData('config');

		$custom_menu = array();
		if(isset($config['main']['mod_admin_menu'])) // load initial mod_admin menu if set
		{
			$custom_menu = self::menuConfig2MenuArray($config['main']['mod_admin_menu']);
		}

		$modules = $config['main']['modules'];

		//debug($custom_menu);die();

		foreach($modules as $alias=>$m)
		{
			$module = is_array($m)?$m['module']:$m;
			$mconf = CCoreHelper::getModConfig('main','',$module);

			$admin_menu = array();
			if(isset($mconf['admin_menu'])){
				$admin_menu = $mconf['admin_menu'];
			}
			else if( isset($mconf['admin_menu_title'])&&isset($mconf['admin_menu_items']) ){
				$admin_menu = array(
					$mconf['admin_menu_title'] =>$mconf['admin_menu_items']
				);
			}
			else {
				continue;
			}
			$admin_menu = self::menuConfig2MenuArray($admin_menu,$module);		
			$menu_tree = array_merge($menu_tree,$admin_menu);	
		}
		$menu_tree = array_merge($custom_menu,$menu_tree);
		if(is_callable('_admin_menu_tree_modify')){
			$menu_tree = _admin_menu_tree_modify($menu_tree);
		}
		return $menu_tree;
	}
	
	
	public static function menuConfig2MenuArray($config=array(),$module=null) {
		$custom_menu = array();
		foreach ($config as $conf_key => $conf) {
			if (is_array($conf) && isset($conf['admin_menu_title']) && isset($conf['admin_menu_items'])) {
				$menu_title = $conf['admin_menu_title'] . ''; // to avoid confusing with module titles
				// apply translation if module parameter given
				if(!empty($module)){
					$menu_title = _mlang($menu_title,'main',$module);
				}
				$custom_menu[$menu_title] = array(); // menu items

				foreach ($conf['admin_menu_items'] as $title => $data) {
					if(isset($data['action'])){
						$mod = isset($data['mod']) ? $data['mod'] : 'mod_admin';
						$perm_action = isset($data['permission_action']) ? $data['permission_action'] : $data['action'];
						if (!ModAdminUserHelper::isAllowed($perm_action, $mod) || (isset($data['menu_hidden'])&&$data['menu_hidden']) )
							continue;

						$url = CUrlHelper::getModXUrl($mod, $data['action']);
						$label = $title;
						$custom_menu[$menu_title][$label] = $url;
					}elseif(is_array($data)) { // assume as a submenu array
						$submenu = self::menuConfig2MenuArray(array($title=>$data));
						$custom_menu[$menu_title][$title] = $submenu[$title];
					}
				}
				if (!count($custom_menu[$menu_title])) {
					unset($custom_menu[$menu_title]);
				}
			}
			elseif(isset($conf['action'])) { // assume as 'title_key'=>menulink_data_array()
				$mod = isset($conf['mod']) ? $conf['mod'] : 'mod_admin';
				$perm_action = isset($conf['permission_action']) ? $conf['permission_action'] : $conf['action'];
				if(empty($conf['action'])){ // dont skip item if empty placeholder
					$url = '';
				} else {
					if (!ModAdminUserHelper::isAllowed($perm_action, $mod) || (isset($conf['menu_hidden'])&&$conf['menu_hidden']))
						continue;

					$url = CUrlHelper::getModXUrl($mod, $conf['action']);
				}
				$label = $conf_key;
				$custom_menu[$label] = $url;
			}
			elseif (is_array($conf)) { // assume array items as sub menu links
				$menu_title = $conf_key;
				// apply translation if module parameter given
				if(!empty($module)){
					$menu_title = _mlang($menu_title,'main',$module);
				}
				$custom_menu[$menu_title] = array(); // menu items

				foreach ($conf as $title => $data) {
					if(isset($data['action'])){
						$mod = isset($data['mod']) ? $data['mod'] : 'mod_admin';
						$perm_action = isset($data['permission_action']) ? $data['permission_action'] : $data['action'];
						if (!ModAdminUserHelper::isAllowed($perm_action, $mod) || (isset($data['menu_hidden'])&&$data['menu_hidden']))
							continue;

						$url = CUrlHelper::getModXUrl($mod, $data['action']);
						$label = $title;
						// apply translation if module parameter given
						if(!empty($module)){
							$label = _mlang($label,'main',$module);
						}
						$custom_menu[$menu_title][$label] = $url;
					}elseif(is_array($data)) { // assume as a submenu array
						$submenu = self::menuConfig2MenuArray(array($title=>$data));
						if(isset($submenu[$title])){
							$custom_menu[$menu_title][$title] = $submenu[$title];
						}
					}
				}
				if (!count($custom_menu[$menu_title])) {
					unset($custom_menu[$menu_title]);
				}
			}
		}
		return $custom_menu;
	}

}
