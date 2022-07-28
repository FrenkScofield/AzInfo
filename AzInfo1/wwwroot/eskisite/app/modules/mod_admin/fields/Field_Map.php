<?php

class Field_Map extends CField
{
	//public $allowHtml = true;
	
	public function db2ui($dbValue=null)
	{
		if($dbValue==null) $dbValue = $this->value;
		return $dbValue;		
	}
	
	public function showInput()
	{
		$lat = 0;
		$lng = 0;
		$zoom = 1;
		
		$parts = explode('|',$this->value);
		if(count($parts)==3){
			list($lat,$lng,$zoom) = $parts;
		}
		
		?>
		<input id="<?=$this->id?>" type="text" class="wide" name="<?=$this->name?>" value="<?=$this->value?>"/>
		
		<div id="<?=$this->id?>_map" ></div>
		
		<script type="text/javascript">
		$(function(){			
			$('#<?=$this->id?>_map').mapinput({
				width:'600px',
				height:'450px',				
				latInput:"map_lat",
				lngInput:"map_lng",
				zoomInput:"map_zoom",
				initPos:[<?=$lat?>,<?=$lng?>],
				initZoom:<?=$zoom?>,
				navigationControl:true,
				scaleControl:true,
				pointerTitle:"<?=  _mlang('Drag or click new position', 'main', 'mod_admin')?>",
				onChange:function(lat,lng,zoom){
					var data = [lat,lng,zoom];
					$('#<?=$this->id?>').val(data.join('|'));
				}
			});
		});
		</script>
		<?php 
	}
}
