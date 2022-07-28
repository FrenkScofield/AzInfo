(function($){
	var fileupload_uuid = 0;
    
    $.fn.extend({
         fileupload: function(options) {            
            var defaults = {
				callback:function(result){},
				action:'',
				type:''
            };
            var o =  $.extend(defaults, options);
            
            return this.each(function(){				
				var self=this;
				var $real = $(self);
				var $clone = $real.clone(true);
				$real.hide();
				$clone.insertAfter($real);
				fileupload_uuid++;
				var iframe_name = 'jquery_fileupload_iframe_'+fileupload_uuid;				
				var $iframe = $('<iframe name="'+iframe_name+'" style="display:none;" width=0 height=0 ></iframe>').appendTo('body');
				var $form = $('<form method="post" action="'+o.action+'" target="'+iframe_name+'" enctype="multipart/form-data" style="display:none;" />').appendTo('body');
				$real.attr('name','file').appendTo($form);
				
				$form.submit(function() {
					$iframe.load(function(){
						var result = handleData($iframe,o.type);
						$form.find('input[type=file]').val('');
						o.callback(result);						
					});
				}).submit();
            });
        }
    });
    
    function handleData(iframe, type) {
		var data, contents = $(iframe).contents().get(0);

		if ($.isXMLDoc(contents) || contents.XMLDocument) {
			return contents.XMLDocument || contents;
		}
		data = $(contents).find('body').html();

		switch (type) {
			case 'xml':
				data = parseXml(data);
				break;
			case 'json':
				//data = window.eval('(' + data + ')');
				data = $.parseJSON(data);
				break;
		}
		return data;
	}

	function parseXml(text) {
		if (window.DOMParser) {
			return new DOMParser().parseFromString(text, 'application/xml');
		} else {
			var xml = new ActiveXObject('Microsoft.XMLDOM');
			xml.async = false;
			xml.loadXML(text);
			return xml;
		}
	}
    
})(jQuery);
