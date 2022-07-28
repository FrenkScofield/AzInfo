
Map Input is a plugin used for adding a map input into html forms. It's useful for situations when you need to get geographical position from the user by allowing selection of a position on the map (google maps). The map input field has 3 hidden inputs used for latitude, longitude, and map zoom level. Following is a sample call to the plugin (including all the options with their default values):


$(function(){
	$('.mapinput').mapinput({
		width:'600px',
		height:'450px',
		latInput:"map_lat",
		lngInput:"map_lng",
		zoomInput:"map_zoom",
		initPos:[0,0],
		initZoom:1,
		navigationControl:true,
		scaleControl:true,
		pointerTitle:"Drag or click new position"
	});
});

