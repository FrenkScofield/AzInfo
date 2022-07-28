<?php

$_config['permissions'] = array();

// add enabled modules' admin menus
$config = _getAppData('config');

$custom_perms = array();
if(isset($config['main']['mod_admin_menu'])) // load initial mod_admin menu if set
{
	foreach($config['main']['mod_admin_menu'] as $conf_key=>$conf)
	{
		if(is_array($conf) && isset($conf['admin_menu_title'])&&isset($conf['admin_menu_items']) ){
			$group_title = $conf['admin_menu_title'];
			if(!isset($conf['admin_permissions']))
			{
				$conf['admin_permissions'] = array();
				// set default (list,edit,delete) permission definitions for the action
				foreach($conf['admin_menu_items'] as $title=>$data)
				{
					$mod = isset($data['mod'])?$data['mod']:'mod_admin';
					$arr = explode('/',$data['action'],2);
					$controller = $arr[0];
					$conf['admin_permissions'][$title] = array(
						'List'=>$mod.'/'.$controller.'/list',
						'Edit'=>$mod.'/'.$controller.'/edit',
						'Delete'=>$mod.'/'.$controller.'/delete',
					);
				}
			}
			$key = 'custom,'.$group_title;
			$custom_perms[$key] = $conf['admin_permissions'];
		}elseif(isset($conf['action'])){
			$mod = isset($conf['mod'])?$conf['mod']:'mod_admin';
			$arr = explode('/',$conf['action'],2);
			$controller = $arr[0];

			$custom_perms['custom,'.$conf_key] = array(
				$conf_key=>array(
					'List'=>$mod.'/'.$controller.'/list',
					'Edit'=>$mod.'/'.$controller.'/edit',
					'Delete'=>$mod.'/'.$controller.'/delete',
				)
			);
		}
	}
}

$modules = $config['main']['modules'];

//debug($modules);

foreach($modules as $alias=>$m)
{
	$module = is_array($m)?$m['module']:$alias;

	$mconf = CCoreHelper::getModConfig('main','',$module);

	if(!( isset($mconf['admin_menu_items']) ))
		continue;

	$mod_title = isset($mconf['admin_menu_title']) ? $mconf['admin_menu_title'] : $module;


	//debug($mconf);
	if(!isset($mconf['admin_permissions']) )
	{
		// set default (list,edit,delete) permission definitions for the action
		foreach($mconf['admin_menu_items'] as $title=>$data)
		{
			$mod = isset($data['mod'])?$data['mod']:'mod_admin';
			$arr = explode('/',$data['action'],2);
			$controller = $arr[0];
			$mconf['admin_permissions'][$title] = array(
				'List'=>$mod.'/'.$controller.'/list',
				'Edit'=>$mod.'/'.$controller.'/edit',
				'Delete'=>$mod.'/'.$controller.'/delete',
			);
		}
	}
	$key = $module.','.$mod_title;
	$_config['permissions'][$key] = $mconf['admin_permissions'];
}

$_config['permissions'] = array_merge($custom_perms,$_config['permissions']);
