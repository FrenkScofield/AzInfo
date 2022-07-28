<?php

class Field_AutoText extends CField
{
	public function showInput()
	{
		?><input type="text" name="<?=$this->name?>" value="<?=$this->value?>" id="<?=$this->id?>">
		<script type="text/javascript">
		$("#<?=$this->id?>").autocomplete("<?=CUrlHelper::getUrl('main/grid',array('model'=>get_class($this->ownerModel),'do'=>'acList','field'=>$this->name))?>", {
			width: 'auto',
			max: 20
		});
		</script>
		<?php 
	}
}
