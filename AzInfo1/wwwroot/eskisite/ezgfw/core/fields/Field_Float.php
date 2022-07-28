<?php

class Field_Float extends CField
{
	public function showInput()
	{
		?><input type="text" name="<?=$this->name?>" value="<?=$this->value?>" id="<?=$this->id?>">
		<script type="text/javascript">
		$("#<?=$this->id?>").change( function(){
			// virgül varsa noktaya çevir
			$(this).val( $(this).val().replace( /\,/  ,".") );
			// metni ondalık sayıya çevir
			var num = parseFloat( $(this).val() );
			// metin sayı değilse 0 a eşitle
			if( isNaN(num))
				num = 0 ;
			//varsa noktayı (ondalık noktası) virgül yap
			var str = num.toString();
			var i = str.lastIndexOf('.');
			if(i != -1){
				str= str.substring(0, i) + ',' + str.substring(i+1, str.length);
			}
			$(this).val(str);
		}).change();
        </script>
		<?php 
	}
	
	public function input2db($input)
	{
		return floatval( str_replace(',','.',$input) );
	}
	
	public function db2input($value)
	{
		return str_replace('.',',',$value);
	}
}
