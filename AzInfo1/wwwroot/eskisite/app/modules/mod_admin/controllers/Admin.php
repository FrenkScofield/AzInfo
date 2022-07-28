<?php

/*
 * @desc: Admin module basic controller class
 * @author: Eren Ezgü <erenezgu[at]gmail.com>
 *
*/
class Admin extends CController
{
	protected $_view_dir='admin';

	public $isXhr = false;

	public $modelName = '';

	public $_module = '';

	public $adminModel = null;
	public $editForm = null;


	public $className = 'Admin';
	public $controller = 'admin';
	
	public $row_id = null;
	
	public $allowInsert = true;
	public $allowUpdate = true;
	public $allowDelete = true;
	public $constantList = false;
	public $listCols = array();
	public $hideCols = array();
	/*
	 * Ex. (initially sort first column descending)
		public $sortCols = array(
			'0'=>'desc'
		);
	 */
	public $sortCols = array(); 
		
	/*
	 Sample:
		 public $subgrids = array(
			'Relation_name'=>'Admin_class_name',
		 );
	*/
	public $subgrids = array();
	
	/*
	 * Ex. 
	 public $rowFilter = array(
		'section'=>'about_us'
	 );
	 */
	public $rowFilter = array();


	public function __construct()
	{
		parent::__construct();
		$this->className = get_class($this);
		$this->controller = strtolower($this->className);
		if($this->constantList){
			$this->allowInsert = false;
			$this->allowDelete = false;
		}
	}
	
	// User defined trigger functions for CUD operations
	public function triggerInsert($id){}
	public function triggerUpdate($id){}
	public function triggerDelete($id){}
	
	protected function notify($msg,$type='message')
	{
		echo '<script type="text/javascript">notify("'.$msg.'","'.$type.'");</script>';
	}
	
	public function editFormToolbar(){
		
	}
	
	public function showToolbar($id){
		
	}

	public function _beforeAction($action=NULL)
	{
		//sleep(1);

		ModAdminUserHelper::requireLogin();

		if(isset($_GET['xhr'])){
			$this->layout = false;
			$this->isXhr = true;
		}

		if(empty($this->modelName) && $modelName = CCoreHelper::getParam('model'))
		{
			$this->modelName = $modelName;
		}

		if(empty($this->modelName))
		{
			die(_l('Model name undefined !'));
		}

		$this->modelName = ucfirst($this->modelName);
		$modelClass = $this->modelName.'Model';
		$this->adminModel = new $modelClass ();
		$this->adminModel->_modelName = $this->modelName;
		$this->adminModel->_rowFilter = $this->rowFilter;
	}


	public function createForm()
	{
		//echo is_object($this->adminModel)?'OK':'FALSE';
		$class = $this->adminModel->_editFormClass;
		$this->editForm = new $class($this->adminModel);

		// remove rowFilter fields
		foreach($this->rowFilter as $key=>$value)
		{
			unset($this->editForm->_fields[$key]);
		}
		
		// check confirm field
		$confirmField = $this->editForm->_confirmField;
		if(!empty($confirmField) && isset($this->editForm->_fields[$confirmField])){
			$confirm_action = strtolower($this->_controller).'/#confirm';
			$allow = ModAdminUserHelper::isAllowed($confirm_action);
			if(!$allow){
				unset($this->editForm->_fields[$confirmField]);
			}
		}
		
		// module based translation needed for field labels
		foreach($this->editForm->_fields as $key=>$field)
		{
			$f = & $this->editForm->_fields[$key]['_field'];
			$f->label = _mlang($f->label,'main',$this->_module);
		}
	}


	public function actionIndex()
	{
		$this->actionList();
	}
	
	protected function downloadXls(){
		$tablename = $this->adminModel->_tableName;
		
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download;");
		header("Content-Disposition: attachment;filename=".$tablename.".xls");
		header("Content-Transfer-Encoding: binary ");
		
		?><html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		</head>
		<body>
			<table>
				<thead>
					<tr>
						<?php 
						foreach($this->editForm->_fields as $name=>$f)
						{
							if(!in_array($name,$this->listCols))
							{
								continue;
							}
							?><th><?=$f['label']?></th><?php 
						}
						?>
					</tr>
				</thead>
				<tbody>
					<?php 
					$data = $this->getGridData();
					foreach($data['aaData'] as $row){
						?><tr><?php 
						foreach($row as $val){
							?><td><?=$val?></td><?php 
						}
						?></tr><?php 
					}?>
				</tbody>
			</table>
		</body><?php 
	}
	
	// Get data for grid
	protected function getGridData()
	{
		/**
		 * grid için sunucu parametreleri
		 * $_GET['iDisplayStart']  sayfalama başlangıç satırı
		 * $_GET['iDisplayLength'] sayfalama uzunluğu
		 * $_GET['iSortingCols']  sıralama yapılan sütun sayısı
		 * $_GET['iSortCol_'.$i] $i sıralama sütunu
		 * $_GET['sSortDir_'.$i] $i sıralama yönü
		 * $_GET['sSearch'] arama terimi (tüm alanlarda arama yapmak için)
		*/

		$data['is_ajax_grid'] = true;
		$this->layout = false;
		
		$isExport = false;
		$paging = true;
		if(isset($_GET['exportXls'])){
			$isExport = true;
			$paging = false;
		}
		
		$grid_data = array(
			'sEcho' => intval(isset($_GET['sEcho'])?$_GET['sEcho']:0 ),
			'iTotalRecords' => 0,
			'iTotalDisplayRecords' => 0,
			'aaData' => array()
		);
		$grid_data['iTotalRecords'] = $this->adminModel->count();

		$aColumns = $this->listCols;

		$colSearch = array();
		$nCols = count($aColumns);
		foreach ( $aColumns as $i=>$col )
		{
			if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == 'true' && isset($_GET['sSearch_'.$i]) && $_GET['sSearch_'.$i] != '' )
			{
				$colSearch[$i] = $_GET['sSearch_'.$i];
			}
		}
		
		$commonSearch = '';
		if(isset($_GET['sSearch']) && $_GET['sSearch']!=''){
			$commonSearch = $_GET['sSearch'];
		}
		$doCommonSearch = !empty($commonSearch);
		
		$doSearch = count($colSearch)>0 || $doCommonSearch;
		
		// paging
		if ( $paging && !$doSearch && isset( $_GET['iDisplayStart'] ) && isset($_GET['iDisplayLength']) && $_GET['iDisplayLength'] != '-1' )
		{
			$this->adminModel->limit(intval($_GET['iDisplayLength']),intval($_GET['iDisplayStart']));
		}

		//ordering
		$orderArr = array();
		
		if ( isset( $_GET['iSortCol_0'] ) )
		{			
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == 'true' )
				{
					$sort_col = intval( $_GET['iSortCol_'.$i] );
					if(isset($aColumns[$sort_col]) && isset($_GET['sSortDir_'.$i]))
						$orderArr[] = '`'.$this->adminModel->_tableName.'`.`'.$aColumns[$sort_col].'` '. $this->adminModel->real_escape_string( $_GET['sSortDir_'.$i] );
				}
			}			
		}
		elseif(!empty($this->adminModel->_defaultOrderBy)){
			$orderArr[] = $this->adminModel->_defaultOrderBy;
		}
		$this->adminModel->orderBy($orderArr);

		$filterCond = array();
		$filter = $this->rowFilter;

		is_object($this->editForm) || $this->createForm();
		
		foreach($this->editForm->_fields as $name=>$f)
		{
			if(($filter_val=CCoreHelper::getParamPure('_'.$name)))
			{
				$filter[$name] = $filter_val;
			}
		}
		//echo 'FILTER: '; debug($filter);
		foreach($filter as $key=>$value)
		{
			$filterCond[] = '`'.$this->adminModel->_tableName.'`.`'.$key.'` = \''.$this->adminModel->real_escape_string($value).'\'';
		}
		$filterCond = implode(' AND ',$filterCond);
		//echo 'FILTER: '; debug($filterCond);

		$cond = '';
		if(!empty($filterCond))
		{
			$cond = $filterCond;
			$grid_data['iTotalRecords'] = $this->adminModel->count($cond);
		}

		$this->adminModel->withAll()->where($cond)->run();

		$url_params = array();
		// model parameter is only required for Admin class
		if($this->className=='Admin'){
			$url_params['model'] = $this->modelName ;
		}
		
		$colTypes = array();
		$colObjects = array();
		foreach($this->editForm->_fields as $name=>$f){
			if(!in_array($name,$this->listCols))
			{
				continue;
			}
			$type = isset($f['type'])?$f['type'] : 'text';
			$colTypes[] = $type;
			$class = 'Field_'.ucfirst($type);
			$colObjects[] = new $class ();
		}
		
		$replaceCharsFrom = array('ö','ç','ş','ı','ğ','ü', 'Ö','Ç','Ş','İ','Ğ','Ü');
		$replaceCharsTo =     array('o','c','s','i','g','u', 'O','C','S','I','G','U');
		
		while($row = $this->adminModel->fetchRow())
		{
			$grid_row = array();
			$grid_row_data = array(); // unformatted row data

			$id =  $this->adminModel->getId();

			$url_params['id'] = $id;

			foreach($this->editForm->_fields as $name=>$f){
				if(!in_array($name,$this->listCols))
				{
					continue;
				}

				if(isset($f['related']) && isset($this->adminModel->_relations[$f['related']]))
				{
					$rel = $f['related'];
					$grid_row[] = $this->adminModel->$rel->getLabel();
				}
				else
				{
					$value =  $this->adminModel->$name;
					$f['_field']->setValue($value);
					$grid_row[] = ''.$f['_field'];
				}
				$grid_row_data[] = $this->adminModel->$name;
			}

			if($doSearch)
			{
				$found = true;
				foreach($colSearch as $i=>$q)
				{
					switch($colTypes[$i]){
						case 'date':
							$range_parts = explode('|', $q);
							if(count($range_parts)==2 && !empty($range_parts[0]) && !empty($range_parts[1])){
								$range_parts[0] = strtotime($range_parts[0]);
								$range_parts[1] = strtotime($range_parts[1]);
								$minVal = min($range_parts);
								$maxVal = max($range_parts); // time 23:59:59 of the max date
								$rowVal = strtotime($grid_row_data[$i]);
								$found = $found && ( $rowVal>=$minVal && $rowVal<=$maxVal );
							}else if(isset($range_parts[0]) && !empty($range_parts[0])) {
								$range_parts[0] = strtotime($range_parts[0]);
								$rowVal = strtotime($grid_row_data[$i]);
								$found = $found && ( $rowVal==$range_parts[0] );
							}
							break;
						case 'timestamp':
							$range_parts = explode('|', $q);
							if(count($range_parts)==2 && !empty($range_parts[0]) && !empty($range_parts[1])){
								$range_parts[0] = strtotime($range_parts[0]);
								$range_parts[1] = strtotime($range_parts[1]);
								$minVal = min($range_parts);
								$maxVal = max($range_parts) + 24*3600 -1; // time 23:59:59 of the max date
								$rowVal = $grid_row_data[$i];
								$found = $found && ( $rowVal>=$minVal && $rowVal<=$maxVal );
							}else if(isset($range_parts[0]) && !empty($range_parts[0])) {
								$range_parts[0] = strtotime($range_parts[0]);
								$minVal = $range_parts[0];
								$maxVal = $minVal + 24*3600 -1; // time 23:59:59 of the same date
								$rowVal = $grid_row_data[$i];
								$found = $found && ( $rowVal>=$minVal && $rowVal<=$maxVal );
							}
							break;
						default:							
							$haystack = str_replace($replaceCharsFrom, $replaceCharsTo, $grid_row[$i]);	
							$needle = str_replace($replaceCharsFrom, $replaceCharsTo, trim($q));
							$found = $found && stristr($haystack, $needle);
					}
				}
				
				// search for common term too if not empty
				$foundCommon= true;
				if($doCommonSearch){
					$foundCommon= false;
					foreach($grid_row as $i=>$val){
						$haystack = str_replace($replaceCharsFrom, $replaceCharsTo, $grid_row[$i]);	
						$needle = str_replace($replaceCharsFrom, $replaceCharsTo, trim($commonSearch));
						if(stristr($haystack, $needle)!==FALSE){
							$foundCommon = true;
							break;
						}
					}
				}
				
				if($found && $foundCommon)
					$grid_data['iTotalDisplayRecords'] ++;
				else
					continue; // while
			}
			
			if(!$isExport){
				ob_start();
				?>
				<a class="xhr grid_satir_goster" href="<?=CUrlHelper::getModUrl($this->controller.'/show',$url_params)?>" title="<?=_mlang('Show','main','mod_admin')?>"><?=_mlang('Show','main','mod_admin')?></a>
				<?php if($this->allowUpdate){?><a class="xhr grid_satir_duzenle" href="<?=CUrlHelper::getModUrl($this->controller.'/edit',$url_params)?>" title="<?=_mlang('Edit','main','mod_admin')?>"><?=_mlang('Edit','main','mod_admin')?></a><?php } ?>
				<?php if($this->allowDelete){?><a class="grid_satir_sil" row_id="<?=$id?>" target="_blank" href="<?=CUrlHelper::getModUrl($this->controller.'/delete',$url_params)?>" title="<?=_mlang('Delete','main','mod_admin')?>"><?=_mlang('Delete','main','mod_admin')?></a><?php }
				$grid_row[] = ob_get_clean();
			}
			$grid_data['aaData'][] = $grid_row;
		}

		if($doSearch && $paging)
		{
			// apply manual paging to result set
			if (isset( $_GET['iDisplayStart'] ) && isset($_GET['iDisplayLength']) && $_GET['iDisplayLength'] != '-1' )
			{
				  $grid_data['aaData'] = array_slice($grid_data['aaData'],intval($_GET['iDisplayStart']),intval($_GET['iDisplayLength']));
			}
		}
		else
		{
			$grid_data['iTotalDisplayRecords'] = $grid_data['iTotalRecords'];
		}
		return $grid_data;
	}

	
	public function refreshListCols(){
		// remove fields from listCols where allowHtml is true
		$tmp = array();
		foreach($this->listCols as $name){
			$f = & $this->editForm->_fields[$name]['_field'];
			if(!$f->allowHtml){
				$tmp[] = $name;
			}
		}
		$this->listCols = $tmp;
		unset($tmp);
	}
	
	public function actionList()  // Liste gösterimi
	{
		ModAdminUserHelper::requireAllow();
		if($this->allowUpdate)
		{
			$this->allowUpdate = ModAdminUserHelper::isAllowed($this->controller.'/edit');
		}
		if($this->allowInsert)
		{
			$this->allowInsert = ModAdminUserHelper::isAllowed($this->controller.'/edit');
		}
		if($this->allowDelete)
		{
			$this->allowDelete = ModAdminUserHelper::isAllowed($this->controller.'/delete');
		}
		
		$this->createForm();

		if(!count($this->listCols)>0)
		{
			foreach($this->editForm->_fields as $name=>$f)
			{
				if(!in_array($name, $this->hideCols)){
					$this->listCols[] = $name;
				}
			}
		}		
		// remove fields from listCols where allowHtml is true
		$this->refreshListCols();

		if(isset($_GET['exportXls']))
		{
			$this->downloadXls();
			return;
		}
		else if(CCoreHelper::getParam('ajax_grid')=='1')
		{
			echo json_encode($this->getGridData());
			return;
		}
		else
		{
			$data = array(
				'grid_id'=>uniqid(),
				'form'=>& $this->editForm,
				'filter'=>$this->rowFilter,
			);
			
			$filter = array();
			foreach($this->editForm->_fields as $name=>$f)
			{
				if(($filter_val=CCoreHelper::getParamPure('_'.$name)))
				{
					$filter[$name] = $filter_val;
				}
			}
			$data['filter'] =array_merge($data['filter'],$filter);
			
			$this->render('list',$data);
		}
	}



	public function actionDelete()
	{
		ModAdminUserHelper::requireToken();
		ModAdminUserHelper::requireAllow();

		// silme izni kontrolü
		if(!$this->allowDelete){
			$this->notify(_l('Error: Row deleting is disabled for this grid!'),'error');
		}
		elseif( $id = CCoreHelper::getIdParam('id') )
		{
			ModAdminUserHelper::requireNotDemoUser();
			
			if($this->adminModel->findByPk($id))
			{
				if($this->adminModel->delete())
				{
					$this->notify(_l('Row deleted!'),'message');
					$this->triggerDelete($id);
				}
				else
				{
					$this->notify(_l('Error: Row couldn\'t be deleted!'),'error');
				}
			}
			else
			{
				$this->notify(_l('Row not found!'),'error');
			}
		}
		else $this->notify(_l('Wrong usage!'),'error');
	}

	public function actionShow()
	{
		ModAdminUserHelper::requireAllow('notify',strtolower($this->className).'/list');
		$this->createForm();
		$data = array(
			'form'=> & $this->editForm,
		);
		$form = & $this->editForm;

		if( $id = CCoreHelper::getIdParam('id') )
		{
			$this->adminModel->findByPk($id) || $this->notify(_l('Row not found!'),'error');
			$data['id'] = $id;
			$form->setValues($this->adminModel->_data);
			$this->render('show',$data);
		}
		else
		{
			$this->notify(_l('Row not found!'),'error');
		}
	}
	
	/**
	 * Finds and edits the only line of the AdminModel	 * 
	 */
	public function actionEditOne(){
		//echo strtolower($this->className).'/edit'; die();
		ModAdminUserHelper::requireAllow('notify',strtolower($this->className).'/edit');		
		$id = null;		
		if($this->adminModel->find()){
			$id = $this->adminModel->getId();
		}		
		$this->actionEdit($id,true);
	}
	
	public function actionEdit($row_id=null,$skipRequireAllow=false) // add & update
	{
		ModAdminUserHelper::requireToken();
		
		if(!$skipRequireAllow){
			ModAdminUserHelper::requireAllow();
		}

		$allow = true;

		$this->createForm();
		$data = array(
			'form'=> & $this->editForm,
			'form_id'=>$this->modelName.'_'.uniqid(),
			'showForm'=>true, // izin yoksa gösterilmeyecek
		);
		$form = & $this->editForm;

		$priKey = $this->adminModel->_primaryKey;
		unset($form->_fields[$priKey]);
		
		// if id parameter is not given also check row_id parameter  (for custom extending in admin classes)
		if( ($id = CCoreHelper::getIdParam('id')) || ($id = $row_id) )
		{
			$this->row_id = $id;
			// another user cant edit Superuser account
			if( $this->className=='Admin_mod_admin_user' &&  $id==1 && !ModAdminUserHelper::isSuperUser() ){
				$this->notify(_l('Error: You are not allowed to edit this user!'),'error');
				$data['showForm'] = false;
				$allow = false;
			}
			// edit permission check
			elseif(!$this->allowUpdate)
			{
				$this->notify(_l('Error: Row updating is disabled for this grid!'),'error');
				$data['showForm'] = false;
				$allow = false;
			}
			else{
				$this->adminModel->findByPk($id) || $this->notify(_l('Row not found!'),'error');
				$data['id'] = $id;
				$form->setValues($this->adminModel->_data);
			}
		}
		elseif(!$this->allowInsert) // ekleme izni kontrolü
		{
			$this->notify(_l('Error: Row inserting is disabled for this grid!'),'error');
			$data['showForm'] = false;
			$allow = false;
		}
		
		// check filter and set form values if given
		$filter = array();
		foreach($form->_fields as $name=>$f){
			$fparam = '_'.$name;
			if($val=CCoreHelper::getParam($fparam)){
				$form->_fields[$name]['_field']->setValue($val);
			}
		}
		
		if($allow && count($_POST)>0)
		{
			if($form->run(false))
			{
				ModAdminUserHelper::requireNotDemoUser();
				$row = array();

				$do_edit = true; // will be set false for errors

				$unique_cond = array(); // fields that must be unique

				foreach($form->_fields as $name=>$f)
				{
					$field = & $form->_fields[$name]['_field'];

					$dbValue = $form->$name;

					if($dbValue!==false)
					{
						if($field->editable)
						{
							$row[$name] = $dbValue;
						}

						if($field->unique)
						{
							$unique_cond[$name] = $dbValue;
						}
					}
				}
				
				// dont allow user account set passive for superuser
				if($this->className=='Admin_mod_admin_user' && $id==1 && $form->_fields['confirm_status']['_field']->getValue()!=1){
					$this->notify(_l('Error: This user account can not be made passive!'),'error');
					$data['showForm'] = false;
					return false;
				}
				
				// apply filter values to row
				$row = array_merge($row,$this->rowFilter);
				
				// unique condition check
				if(count($unique_cond)>0)
				{
					if($id)
					{
						foreach($unique_cond as $f=>$val)
						{
							if( $this->adminModel->whereNot(array($this->adminModel->_primaryKey=>$id))->where(array($f=>$val),false)->count() )
							{
								$this->notify(_l('Field must be unique:').' '._l($form->_fields[$f]['_field']->label),'error');
								$do_edit = false;
								break;
							}
						}
					}
					else
					{
						foreach($unique_cond as $f=>$val)
						{
							if($this->adminModel->where(array($f=>$val))->count())
							{
								$this->notify(_l('Field must be unique:').' '._l($form->_fields[$f]['_field']->label),'error');
								$do_edit = false;
								break;
							}
						}
					}
				}
				//debug($row);
				if($do_edit)
				{
					if($id)
					{
						if($this->adminModel->update($row)){
							$this->notify(_l('Row updated.'),'message');
							$this->triggerUpdate($id);
						}
						else{
							$this->notify(_l('Error: Row couldn\'t be updated!'),'error');
						}
					}
					else{
						if($this->adminModel->insert($row)){
							$this->notify(_l('New row inserted.'),'message');
							$new_id = $this->adminModel->get_insert_id();
							$this->triggerInsert($new_id);
						}
						else{
							$this->notify(_l('Error: Row couldn\'t be inserted!'),'error');
						}
					}
				}
			}

			if($this->isXhr){
				if($form->hasErrors())
				{
					foreach($form->getErrors() as $error)
					{
						$this->notify($error,'error');
					}
				}
			}
			else{
				$this->render('edit',$data);
			}

		}
		else
		{
			$this->render('edit',$data);
		}
	}

	public function actionDelete_file()
	{
		$return = array();

		$controller = strtolower($this->_controller);

		if(!ModAdminUserHelper::isAllowed($controller.'/edit'))
		{
			$return['error'] = _mlang('You are not authorized to perform this action!','main','mod_admin');
			echo json_encode($return);
			return;
		}
		
		if(ModAdminUserHelper::isDemoUser()){
			die( json_encode(array('error'=>_mlang('You are not allowed to make changes in demo mode!','main','mod_admin'))) );
		}
		
		$error = _mlang('An error occured while file deleting!','main','mod_admin');

		// get filed properties from model->form->field
		if($modelName=CCoreHelper::getParam('model')){
			$mClass = $modelName.'Model';
			if(class_exists($mClass))
			{
				$model = new $mClass();
				$fClass = $model->_editFormClass;
				if(class_exists($fClass))
				{
					$form = new $fClass();
					if( ($field = CCoreHelper::getParam('field')) && isset($form->_fields[$field]))
					{
						$f = & $form->_fields[$field];
						$dir = isset($f['dir']) ? $f['dir'] :'';
						$file_path = (isset($f['file_path'])?$f['file_path']:FILES_PATH.'/').$dir;

						if(isset($_POST['file']) && !empty($_POST['file']))
						{
							$file = trim($_POST['file']);
							$file=str_replace(array('/','..'),'',$file);

							$ok = true;

							if(is_file($file_path.$file))
								$ok= $ok & (@unlink($file_path.$file));
							if($ok)
							{
								$error = '';
								$return['success']=true;
							}
						}

					}
				}
			}
		}

		if(!empty($error))
		{
			$return['error'] = $error;
		}

		echo json_encode($return);

	}

	public function actionDelete_image()
	{
		$return = array();

		$controller = strtolower($this->_controller);

		if(!ModAdminUserHelper::isAllowed($controller.'/edit'))
		{
			$return['error'] = _mlang('You are not authorized to perform this action!','main','mod_admin');
			echo json_encode($return);
			return;
		}
		
		if(ModAdminUserHelper::isDemoUser()){
			die( json_encode(array('error'=>_mlang('You are not allowed to make changes in demo mode!','main','mod_admin'))) );
		}

		$error = _mlang('An error occured while file deleting!','main','mod_admin');

		// get filed properties from model->form->field
		if($modelName=CCoreHelper::getParam('model')){
			$mClass = $modelName.'Model';
			if(class_exists($mClass))
			{
				$model = new $mClass();
				$fClass = $model->_editFormClass;
				if(class_exists($fClass))
				{
					$form = new $fClass();
					if( ($field = CCoreHelper::getParam('field')) && isset($form->_fields[$field]))
					{
						$f = & $form->_fields[$field];
						$size_options = isset($f['size_options'])?$f['size_options']:array();
						$dir = isset($f['dir']) ? $f['dir'] :'';
						$img_path = (isset($f['img_path'])?$f['img_path']:IMAGES_PATH.'/').$dir;

						if(isset($_POST['file']) && !empty($_POST['file']))
						{
							$file = trim($_POST['file']);
							$file=str_replace(array('/','..'),'',$file);

							$ok = true;
							foreach($size_options as $opt){
								$fpath = $img_path.$opt['prefix'].$file;
								if(is_file($fpath))
									$ok= $ok & (@unlink($fpath));
							}
							if(is_file($img_path.$file))
								$ok= $ok & (@unlink($img_path.$file));
							if($ok)
							{
								$error = '';
								$return['success']=true;
								// Delete image cache files for existing sizes
								$config = _getAppData('config',true);
								$image_size_options = isset($config['main']['image_size_options']) ? $config['main']['image_size_options'] : array();
								foreach($image_size_options as $opt)	{
									$fpath = MEDIA_PATH .'/cache/'.$opt['prefix'].$file;
									if(is_file($fpath)){
										@unlink($fpath);
									}
								}
							}
						}

					}
				}
			}
		}

		if(!empty($error))
		{
			$return['error'] = $error;
		}

		echo json_encode($return);

	}
	public function actionUpload_file()
	{
		$return = array();

		$controller = strtolower($this->_controller);

		if(!ModAdminUserHelper::isAllowed($controller.'/edit'))
		{
			$return['error'] = _mlang('You are not authorized to perform this action!','main','mod_admin');
			echo json_encode($return);
			return;
		}
		if(ModAdminUserHelper::isDemoUser()){
			die( json_encode(array('error'=>_mlang('You are not allowed to make changes in demo mode!','main','mod_admin'))) );
		}

		$error = _mlang('An error occured while file uploading!','main','mod_admin');

		$opts = array(
			'input_name'=>'file',
			'input_file'=>'',
			'file_path'=>FILES_PATH.'/',
			'keep_original_name'=>true,
		);

		// get filed properties from model->form->field
		if($modelName=CCoreHelper::getParam('model')){
			$mClass = $modelName.'Model';
			if(class_exists($mClass))
			{
				$model = new $mClass();
				$fClass = $model->_editFormClass;
				if(class_exists($fClass))
				{
					$form = new $fClass();
					if( ($field = CCoreHelper::getParam('field')) && isset($form->_fields[$field]))
					{
						$f = & $form->_fields[$field];

						foreach(array('file_path','keep_original_name') as $opt)
						{
							if(isset($f[$opt]))
								$opts[$opt] = $f[$opt];
						}

						if(isset($f['dir']))
							$opts['file_path'] .= $f['dir'];

						if($file = CUploadHelper::uploadFile($opts))
						{
							$error = '';
							$return['file'] = $file;
						}
					}
				}
			}
		}

		if(!empty($error))
		{
			$return['error'] = $error;
		}

		echo json_encode($return);
	}

	public function actionUpload_image()
	{
		$return = array();

		$controller = strtolower($this->_controller);

		if(!ModAdminUserHelper::isAllowed($controller.'/edit'))
		{
			$return['error'] = _mlang('You are not authorized to perform this action!','main','mod_admin');
			echo json_encode($return);
			return;
		}
		
		if(ModAdminUserHelper::isDemoUser()){
			die( json_encode(array('error'=>_mlang('You are not allowed to make changes in demo mode!','main','mod_admin'))) );
		}
		
		$error = _mlang('An error occured while file uploading!','main','mod_admin');

		$opts = array(
			'input_name'=>'file',
			'input_file'=>'',
			'img_path'=>IMAGES_PATH.'/',
			'size_options'=>array(),
			'empty_original'=>false,
			'keep_original_name'=>true,
			'original_max_width'=>5000,
			'original_max_height'=>5000,
		);

		// get field properties from model->form->field
		if($modelName=CCoreHelper::getParam('model')){
			$mClass = $modelName.'Model';
			if(class_exists($mClass))
			{
				$model = new $mClass();
				$fClass = $model->_editFormClass;
				if(class_exists($fClass))
				{
					$form = new $fClass();
					if( ($field = CCoreHelper::getParam('field')) && isset($form->_fields[$field]))
					{
						$f = & $form->_fields[$field];

						foreach(array('img_path','size_options','empty_original','keep_original_name','original_max_width','original_max_height') as $opt)
						{
							if(isset($f[$opt]))
								$opts[$opt] = $f[$opt];
						}
						if(isset($f['dir']))
							$opts['img_path'] .= $f['dir'];

						if(count($opts['size_options'])==0)
						{
							$opts['empty_original'] = false;
						}

						if($file = CUploadHelper::uploadImage($opts))
						{
							$error = '';
							$return['file'] = $file;
						}
					}
				}
			}
		}

		if(!empty($error))
		{
			$return['error'] = $error;
		}

		echo json_encode($return);
	}
	
	public function actionFields(){
		if(($f=CCoreHelper::getParam('f')) && ($do=CCoreHelper::getParam('do')) ){
			$this->createForm();
			if(isset($this->editForm->_fields[$f])){
				$Field = & $this->editForm->_fields[$f]['_field'];
				$method = 'faction'.ucfirst($do);
				
				if(method_exists($Field, $method) ){
					$Field->{$method} ();
				}
			}
		}
	}
	
}
