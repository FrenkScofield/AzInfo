<?php

class Field_Price extends CField
{
	public function input2db($input)
	{
		//ör: 1.234.567,89
		//noktaları kaldır
		$val = str_replace('.','',$input); // 1234567,89
		//virgülü noktaya çevir
		$val = str_replace(',','.',$val);
		return floatval($val);
	}
	
	public function db2ui($dbValue=null){
		if($dbValue===null) $dbValue = $this->value;
		return number_format(floatval($dbValue),2,',','.');
	}
	
	public function db2input($value)
	{
		//ör: 1234567.89 > 1.234.567,89
		return number_format(floatval($value),2,',','.');
	}
	
	public function showInput()
	{
		?><input type="text" name="<?=$this->name?>" value="<?=$this->db2input($this->value)?>" id="<?=$this->id?>" <?=$this->getHtmlAttrs()?>/>
		<script type="text/javascript">
		Number.prototype.formatMoney = function(c, d, t){
			var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
			return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
		};
		
		$("#<?=$this->id?>").change( function(){			
			var num = $(this).val();
			num = num.replace( /\./  ,'');
			num = num.replace( /\,/  ,'.');
			num = parseFloat(num);
			num = (num).formatMoney(2,',','.');
			$(this).val(num);
		}).change();		
		</script>
		<?php 
	}
	
}
