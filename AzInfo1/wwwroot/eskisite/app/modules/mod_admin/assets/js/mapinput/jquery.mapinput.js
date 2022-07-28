(function($){
     $.fn.extend({
         mapinput: function(options) {
            var defaults = {
                width:'600px',
                height:'450px',
                latInput:"map_lat",
                lngInput:"map_lng",
                zoomInput:"map_zoom",
                initPpos:[0,0],
                initZoom:5,
                navigationControl:true,
                scaleControl:true,
                pointerTitle:"Drag or click new position",
				onChange:function(lat,lng,zoom){}
            };
            var mapinputUuid = 1;
            var options =  $.extend(defaults, options);
            return this.each(function(){
                var o = options;
                var $t = $(this);
                                
                var canvasId = 'map_canvas_'+ (mapinputUuid++);
                $t.append('<input name="'+o.latInput+'" type="hidden" value="'+o.initPos[0]+'"><input name="'+o.lngInput+'" value="'+o.initPos[1]+'" type="hidden"><input name="'+o.zoomInput+'" type="hidden" value="'+o.initZoom+'"><div class="canvas" id="'+canvasId+'" style="width:'+o.width+';height:'+o.height+';"></div>');
                                
                var $latInput = $t.find('input[name="'+o.latInput+'"]');
                var $lngInput = $t.find('input[name="'+o.lngInput+'"]');
                var $zoomInput = $t.find('input[name="'+o.zoomInput+'"]');
                
				var onChangeRun = function(){
					o.onChange($latInput.val(),$lngInput.val(),$zoomInput.val());
				};
				
                var pos = new google.maps.LatLng(o.initPos[0],o.initPos[1]);
				var mapOptions = {
					zoom: o.initZoom,
					center: pos,
					mapTypeId: google.maps.MapTypeId.HYBRID,
					navigationControl: o.navigationControl,
					scaleControl: o.scaleControl
				};
				var map = new google.maps.Map(document.getElementById(canvasId),mapOptions);				
				var marker = new google.maps.Marker({
					position: pos, 
					map: map,
					title:o.pointerTitle,
					draggable: true
				});							
				google.maps.event.addListener(map, 'zoom_changed', function(){
					zoomLevel = map.getZoom();
					if(zoomLevel == 0){
					  map.setZoom(10);
					  zoomLevel = 10;
					}
					$zoomInput.val(zoomLevel);
					onChangeRun();
				});
				google.maps.event.addListener(map, 'click', function(event) {
					var latLng = event.latLng;
					marker.setPosition(latLng);
					$latInput.val(latLng.lat());
					$lngInput.val(latLng.lng());
					onChangeRun();
				});							
				google.maps.event.addListener(marker, 'dragend', function() {			
					var latLng = marker.getPosition();
					$latInput.val(latLng.lat());
					$lngInput.val(latLng.lng());
					onChangeRun();
				});                
            });
        }
    });    
})(jQuery);
