<?php

class Field_Timestamp extends CField
{
	public function showInput()
	{
		?><input type="text" name="<?=$this->name?>" value="<?=$this->value?>" id="<?=$this->id?>">
		<script type="text/javascript">
		$("#<?=$this->id?>").change( function(){
			var result = parseInt($(this).val(),10);
			if( isNaN(result))
				$(this).val('0');
			else
				$(this).val(result);
		}).change();
		</script>
		<?php 
	}
	
	public function input2db($input)
	{
		return intval($input);
	}
	
	public function db2ui($dbValue=null){
		if($dbValue===null) $dbValue = $this->value;
		return empty($dbValue)?'':date('Y-m-d H:i:s',$dbValue);
	}	
}
