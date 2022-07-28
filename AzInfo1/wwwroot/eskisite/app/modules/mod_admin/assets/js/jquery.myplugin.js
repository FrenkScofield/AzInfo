(function($){
     $.fn.extend({
         myplugin: function(options) {            
            var defaults = {
                padding: 20,
                mouseOverColor : '#000000',
                mouseOutColor : '#ffffff'
            }                
            var options =  $.extend(defaults, options);
            return this.each(function(){
                var o = options;                
                //code to be inserted here
                //you can access the value like this
                alert(o.padding);            
            });
        }
    });    
})(jQuery);