<?php

class Field_AutoSelect extends CField
{	
	public $options = array();
	public $_gotOptions = false;
	
		
	public function showInput()
	{
		//trigger_error(CDebugHelper::debugArray($this));
		?>
		<input type="hidden" name="<?=$this->name?>" value="<?=$this->value?>" id="<?=$this->id?>">
		<input type="text" id="<?=$this->id?>_input" value="<?=$this->getText()?>">
		<script type="text/javascript">
		$("#<?=$this->id?>_input").autocomplete("<?=CUrlHelper::getUrl('main/grid',array('model'=>get_class($this->ownerModel),'do'=>'acList','field'=>$this->name))?>", {
			width: 'auto',
			max: 20,
			highlight: false,
			scroll: true,
			scrollHeight: 300,
			formatItem: function(data, i, n, value) {
				var jsonData = $.parseJSON(data[0]);
				//console.log(jsonData);				
				return jsonData.label;
			}
		});
		$("#<?=$this->id?>_input").result(function(event, data, formatted) {
			if(data){
				jsonData = $.parseJSON(data);
				//console.log(jsonData);
				$("#<?=$this->id?>_input").val(jsonData.label);
				$("#<?=$this->id?>").val(jsonData.id);
			}
		});
		</script>
		<?php 
	}
	
	protected function getOptions()
	{
		$options = $this->options;
		if(!empty($this->related))
		{
			$modelName = $this->related;
			$model = new $modelName();
			$model->run('select');
			while($model->fetchRow())
			{
				$model->setFieldValues();					
				$options[ $model->getId() ] = $model->getLabel();
			}
		}
		$this->options = $options;
		$this->_gotOptions = true;
	}
	
	public function getText()
	{
		if(!$this->_gotOptions)
		{
			$this->getOptions();
		}
		return isset($this->options[$this->value])?$this->options[$this->value] : $this->value;
	}
}
